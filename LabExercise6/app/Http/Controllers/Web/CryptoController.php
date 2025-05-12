<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Exception;

class CryptoController extends Controller
{
    // Default encryption settings
    private $cipher = 'aes-256-cbc';
    private $defaultKey = 'websec_default_key_12345';
    private $defaultIv = 'websec_iv_123456';

    /**
     * Show the main crypto page
     */
    public function index()
    {
        // Get available cipher methods
        $cipherMethods = openssl_get_cipher_methods();

        // Get available digest methods
        $digestMethods = openssl_get_md_methods();

        return view('crypto.index', [
            'cipherMethods' => $cipherMethods,
            'digestMethods' => $digestMethods,
            'defaultCipher' => $this->cipher
        ]);
    }

    /**
     * Show the simple crypto page
     */
    public function simpleIndex()
    {
        // Check if there's an error message in the session
        $error = session('error') ?? '';

        return view('crypto.simple', [
            'error' => $error
        ]);
    }

    /**
     * Process crypto operation (encrypt, decrypt, or hash)
     */
    public function processOperation(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'data' => 'required|string',
            'operation' => 'required|in:encrypt,decrypt,hash'
        ]);

        if ($validator->fails()) {
            return redirect()->route('crypto.simple')
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->input('data');
        $operation = $request->input('operation');
        $result = '';
        $result_status = '';

        try {
            switch ($operation) {
                case 'encrypt':
                    // Encrypt the data
                    $key = $this->defaultKey;
                    $iv = $this->defaultIv;
                    $cipher = $this->cipher;

                    // Ensure key and IV are the correct length
                    $key = $this->padKey($key, $cipher);
                    $iv = $this->padIV($iv, $cipher);

                    // Encrypt the data
                    $encrypted = openssl_encrypt($data, $cipher, $key, 0, $iv);

                    if ($encrypted === false) {
                        throw new Exception('Encryption failed: ' . openssl_error_string());
                    }

                    // Base64 encode for safe display
                    $result = base64_encode($encrypted);
                    $result_status = 'Encrypted Successfully';
                    break;

                case 'decrypt':
                    // Decrypt the data
                    $key = $this->defaultKey;
                    $iv = $this->defaultIv;
                    $cipher = $this->cipher;

                    // Ensure key and IV are the correct length
                    $key = $this->padKey($key, $cipher);
                    $iv = $this->padIV($iv, $cipher);

                    // Base64 decode the input
                    $decodedCiphertext = base64_decode($data);

                    // Decrypt the data
                    $decrypted = openssl_decrypt($decodedCiphertext, $cipher, $key, 0, $iv);

                    if ($decrypted === false) {
                        throw new Exception('Decryption failed: ' . openssl_error_string());
                    }

                    $result = $decrypted;
                    $result_status = 'Decrypted Successfully';
                    break;

                case 'hash':
                    // Hash the data
                    $algorithm = 'sha256';

                    // Generate the hash
                    $hash = openssl_digest($data, $algorithm);

                    if ($hash === false) {
                        throw new Exception('Hashing failed: ' . openssl_error_string());
                    }

                    $result = $hash;
                    $result_status = 'Hashed Successfully';
                    break;
            }

            return view('crypto.simple', [
                'data' => $data,
                'operation' => $operation,
                'result' => $result,
                'result_status' => $result_status
            ]);

        } catch (Exception $e) {
            return redirect()->route('crypto.simple')
                ->withErrors(['error' => $e->getMessage()])
                ->withInput()
                ->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    /**
     * Encrypt data using OpenSSL
     */
    public function encrypt(Request $request)
    {
        $request->validate([
            'plaintext' => 'required|string',
            'key' => 'nullable|string',
            'iv' => 'nullable|string',
            'cipher' => 'required|string'
        ]);

        try {
            $plaintext = $request->input('plaintext');
            $key = $request->input('key') ?: $this->defaultKey;
            $iv = $request->input('iv') ?: $this->defaultIv;
            $cipher = $request->input('cipher') ?: $this->cipher;

            // Ensure key and IV are the correct length
            $key = $this->padKey($key, $cipher);
            $iv = $this->padIV($iv, $cipher);

            // Encrypt the data
            $encrypted = openssl_encrypt($plaintext, $cipher, $key, 0, $iv);

            if ($encrypted === false) {
                throw new Exception('Encryption failed: ' . openssl_error_string());
            }

            // Base64 encode for safe display
            $base64Encrypted = base64_encode($encrypted);

            return view('crypto.result', [
                'result' => $base64Encrypted,
                'operation' => 'Encryption',
                'input' => $plaintext,
                'key' => $key,
                'iv' => $iv,
                'cipher' => 'aes-256-cbc'
            ]);
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Decrypt data using OpenSSL
     */
    public function decrypt(Request $request)
    {
        $request->validate([
            'ciphertext' => 'required|string',
            'key' => 'nullable|string',
            'iv' => 'nullable|string',
            'cipher' => 'required|string'
        ]);

        try {
            $ciphertext = $request->input('ciphertext');
            $key = $request->input('key') ?: $this->defaultKey;
            $iv = $request->input('iv') ?: $this->defaultIv;
            $cipher = $request->input('cipher') ?: $this->cipher;

            // Ensure key and IV are the correct length
            $key = $this->padKey($key, $cipher);
            $iv = $this->padIV($iv, $cipher);

            // Base64 decode the input
            $decodedCiphertext = base64_decode($ciphertext);

            // Decrypt the data
            $decrypted = openssl_decrypt($decodedCiphertext, $cipher, $key, 0, $iv);

            if ($decrypted === false) {
                throw new Exception('Decryption failed: ' . openssl_error_string());
            }

            return view('crypto.result', [
                'result' => $decrypted,
                'operation' => 'Decryption',
                'input' => $ciphertext,
                'key' => $key,
                'iv' => $iv,
                'cipher' => 'aes-256-cbc'
            ]);
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Generate a hash using OpenSSL
     */
    public function hash(Request $request)
    {
        $request->validate([
            'data' => 'required|string',
            'algorithm' => 'required|string'
        ]);

        try {
            $data = $request->input('data');
            $algorithm = $request->input('algorithm') ?: 'sha256';

            // Generate the hash
            $hash = openssl_digest($data, $algorithm);

            if ($hash === false) {
                throw new Exception('Hashing failed: ' . openssl_error_string());
            }

            return view('crypto.result', [
                'result' => $hash,
                'operation' => 'Hashing',
                'input' => $data,
                'algorithm' => $algorithm
            ]);
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Generate a key pair using OpenSSL
     */
    public function generateKeyPair(Request $request)
    {
        $request->validate([
            'bits' => 'required|integer|min:1024|max:4096',
            'digest_alg' => 'required|string'
        ]);

        try {
            $bits = $request->input('bits');
            $digestAlg = $request->input('digest_alg');

            // Configuration for key generation
            $config = [
                'digest_alg' => $digestAlg,
                'private_key_bits' => $bits,
                'private_key_type' => OPENSSL_KEYTYPE_RSA,
            ];

            // Generate the key pair
            $res = openssl_pkey_new($config);

            if ($res === false) {
                throw new Exception('Key pair generation failed: ' . openssl_error_string());
            }

            // Extract the private key
            openssl_pkey_export($res, $privateKey);

            // Extract the public key
            $publicKeyDetails = openssl_pkey_get_details($res);
            $publicKey = $publicKeyDetails['key'];

            return view('crypto.keypair', [
                'privateKey' => $privateKey,
                'publicKey' => $publicKey,
                'bits' => $bits,
                'digestAlg' => $digestAlg
            ]);
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Sign data using a private key
     */
    public function sign(Request $request)
    {
        $request->validate([
            'data' => 'required|string',
            'private_key' => 'required|string',
            'algorithm' => 'required|string'
        ]);

        try {
            $data = $request->input('data');
            $privateKey = $request->input('private_key');
            $algorithm = $request->input('algorithm');

            // Create the signature
            $signature = null;
            $result = openssl_sign($data, $signature, $privateKey, $algorithm);

            if ($result === false) {
                throw new Exception('Signing failed: ' . openssl_error_string());
            }

            // Base64 encode the signature for safe display
            $base64Signature = base64_encode($signature);

            return view('crypto.result', [
                'result' => $base64Signature,
                'operation' => 'Signing',
                'input' => $data,
                'algorithm' => $algorithm
            ]);
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Verify a signature using a public key
     */
    public function verify(Request $request)
    {
        $request->validate([
            'data' => 'required|string',
            'signature' => 'required|string',
            'public_key' => 'required|string',
            'algorithm' => 'required|string'
        ]);

        try {
            $data = $request->input('data');
            $signature = base64_decode($request->input('signature'));
            $publicKey = $request->input('public_key');
            $algorithm = $request->input('algorithm');

            // Verify the signature
            $result = openssl_verify($data, $signature, $publicKey, $algorithm);

            if ($result === -1) {
                throw new Exception('Verification failed: ' . openssl_error_string());
            }

            $verificationResult = ($result === 1) ? 'Signature is valid' : 'Signature is invalid';

            return view('crypto.result', [
                'result' => $verificationResult,
                'operation' => 'Signature Verification',
                'input' => $data,
                'algorithm' => $algorithm
            ]);
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Encrypt data using a public key
     */
    public function publicKeyEncrypt(Request $request)
    {
        $request->validate([
            'data' => 'required|string',
            'public_key' => 'required|string'
        ]);

        try {
            $data = $request->input('data');
            $publicKey = $request->input('public_key');

            // Encrypt the data
            $encrypted = null;
            $result = openssl_public_encrypt($data, $encrypted, $publicKey);

            if ($result === false) {
                throw new Exception('Public key encryption failed: ' . openssl_error_string());
            }

            // Base64 encode for safe display
            $base64Encrypted = base64_encode($encrypted);

            return view('crypto.result', [
                'result' => $base64Encrypted,
                'operation' => 'Public Key Encryption',
                'input' => $data
            ]);
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Decrypt data using a private key
     */
    public function privateKeyDecrypt(Request $request)
    {
        $request->validate([
            'data' => 'required|string',
            'private_key' => 'required|string'
        ]);

        try {
            $data = base64_decode($request->input('data'));
            $privateKey = $request->input('private_key');

            // Decrypt the data
            $decrypted = null;
            $result = openssl_private_decrypt($data, $decrypted, $privateKey);

            if ($result === false) {
                throw new Exception('Private key decryption failed: ' . openssl_error_string());
            }

            return view('crypto.result', [
                'result' => $decrypted,
                'operation' => 'Private Key Decryption',
                'input' => $request->input('data')
            ]);
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Helper function to pad the key to the correct length
     */
    private function padKey($key, $cipher)
    {
        $keyLength = openssl_cipher_key_length($cipher);
        if ($keyLength === false) {
            // Default to 32 bytes for AES-256
            $keyLength = 32;
        }

        // Pad or truncate the key to the required length
        if (strlen($key) < $keyLength) {
            return str_pad($key, $keyLength, '0');
        } elseif (strlen($key) > $keyLength) {
            return substr($key, 0, $keyLength);
        }

        return $key;
    }

    /**
     * Helper function to pad the IV to the correct length
     */
    private function padIV($iv, $cipher)
    {
        $ivLength = openssl_cipher_iv_length($cipher);
        if ($ivLength === false) {
            // Default to 16 bytes for AES
            $ivLength = 16;
        }

        // Pad or truncate the IV to the required length
        if (strlen($iv) < $ivLength) {
            return str_pad($iv, $ivLength, '0');
        } elseif (strlen($iv) > $ivLength) {
            return substr($iv, 0, $ivLength);
        }

        return $iv;
    }
}
