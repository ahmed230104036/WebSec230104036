@extends('layouts.master')
@section('title', 'OpenSSL Crypto Functions')
@section('content')
<div class="container">
    <h1 class="mb-4">OpenSSL Cryptography Functions</h1>
    
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <div class="row">
        <div class="col-md-6">
            <!-- Symmetric Encryption Section -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3>Symmetric Encryption</h3>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs mb-3" id="symmetricTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="encrypt-tab" data-bs-toggle="tab" data-bs-target="#encrypt" type="button" role="tab" aria-controls="encrypt" aria-selected="true">Encrypt</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="decrypt-tab" data-bs-toggle="tab" data-bs-target="#decrypt" type="button" role="tab" aria-controls="decrypt" aria-selected="false">Decrypt</button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="symmetricTabContent">
                        <!-- Encrypt Tab -->
                        <div class="tab-pane fade show active" id="encrypt" role="tabpanel" aria-labelledby="encrypt-tab">
                            <form action="{{ route('crypto.encrypt') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="plaintext" class="form-label">Plaintext</label>
                                    <textarea class="form-control" id="plaintext" name="plaintext" rows="3" required>{{ old('plaintext') }}</textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="cipher" class="form-label">Cipher Method</label>
                                    <select class="form-select" id="cipher" name="cipher" required>
                                        @foreach($cipherMethods as $method)
                                            <option value="{{ $method }}" {{ $method == $defaultCipher ? 'selected' : '' }}>{{ $method }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="key" class="form-label">Encryption Key (optional)</label>
                                    <input type="text" class="form-control" id="key" name="key" placeholder="Leave blank to use default key">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="iv" class="form-label">Initialization Vector (optional)</label>
                                    <input type="text" class="form-control" id="iv" name="iv" placeholder="Leave blank to use default IV">
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Encrypt</button>
                            </form>
                        </div>
                        
                        <!-- Decrypt Tab -->
                        <div class="tab-pane fade" id="decrypt" role="tabpanel" aria-labelledby="decrypt-tab">
                            <form action="{{ route('crypto.decrypt') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="ciphertext" class="form-label">Ciphertext (Base64)</label>
                                    <textarea class="form-control" id="ciphertext" name="ciphertext" rows="3" required>{{ old('ciphertext') }}</textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="cipher" class="form-label">Cipher Method</label>
                                    <select class="form-select" id="cipher" name="cipher" required>
                                        @foreach($cipherMethods as $method)
                                            <option value="{{ $method }}" {{ $method == $defaultCipher ? 'selected' : '' }}>{{ $method }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="key" class="form-label">Decryption Key (optional)</label>
                                    <input type="text" class="form-control" id="key" name="key" placeholder="Leave blank to use default key">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="iv" class="form-label">Initialization Vector (optional)</label>
                                    <input type="text" class="form-control" id="iv" name="iv" placeholder="Leave blank to use default IV">
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Decrypt</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Hashing Section -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h3>Hashing</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('crypto.hash') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="data" class="form-label">Data to Hash</label>
                            <textarea class="form-control" id="data" name="data" rows="3" required>{{ old('data') }}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="algorithm" class="form-label">Hash Algorithm</label>
                            <select class="form-select" id="algorithm" name="algorithm" required>
                                @foreach($digestMethods as $method)
                                    <option value="{{ $method }}">{{ $method }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-success">Generate Hash</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <!-- Asymmetric Cryptography Section -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h3>Asymmetric Cryptography</h3>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs mb-3" id="asymmetricTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="generate-tab" data-bs-toggle="tab" data-bs-target="#generate" type="button" role="tab" aria-controls="generate" aria-selected="true">Generate Keys</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="sign-tab" data-bs-toggle="tab" data-bs-target="#sign" type="button" role="tab" aria-controls="sign" aria-selected="false">Sign</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="verify-tab" data-bs-toggle="tab" data-bs-target="#verify" type="button" role="tab" aria-controls="verify" aria-selected="false">Verify</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pk-encrypt-tab" data-bs-toggle="tab" data-bs-target="#pk-encrypt" type="button" role="tab" aria-controls="pk-encrypt" aria-selected="false">Encrypt</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pk-decrypt-tab" data-bs-toggle="tab" data-bs-target="#pk-decrypt" type="button" role="tab" aria-controls="pk-decrypt" aria-selected="false">Decrypt</button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="asymmetricTabContent">
                        <!-- Generate Keys Tab -->
                        <div class="tab-pane fade show active" id="generate" role="tabpanel" aria-labelledby="generate-tab">
                            <form action="{{ route('crypto.generate-keypair') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="bits" class="form-label">Key Size (bits)</label>
                                    <select class="form-select" id="bits" name="bits" required>
                                        <option value="1024">1024</option>
                                        <option value="2048" selected>2048</option>
                                        <option value="4096">4096</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="digest_alg" class="form-label">Digest Algorithm</label>
                                    <select class="form-select" id="digest_alg" name="digest_alg" required>
                                        @foreach($digestMethods as $method)
                                            <option value="{{ $method }}" {{ $method == 'sha256' ? 'selected' : '' }}>{{ $method }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <button type="submit" class="btn btn-info">Generate Key Pair</button>
                            </form>
                        </div>
                        
                        <!-- Sign Tab -->
                        <div class="tab-pane fade" id="sign" role="tabpanel" aria-labelledby="sign-tab">
                            <form action="{{ route('crypto.sign') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="data" class="form-label">Data to Sign</label>
                                    <textarea class="form-control" id="data" name="data" rows="3" required>{{ old('data') }}</textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="private_key" class="form-label">Private Key (PEM format)</label>
                                    <textarea class="form-control" id="private_key" name="private_key" rows="5" required>{{ old('private_key') }}</textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="algorithm" class="form-label">Signature Algorithm</label>
                                    <select class="form-select" id="algorithm" name="algorithm" required>
                                        @foreach($digestMethods as $method)
                                            <option value="{{ $method }}" {{ $method == 'sha256' ? 'selected' : '' }}>{{ $method }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <button type="submit" class="btn btn-info">Sign Data</button>
                            </form>
                        </div>
                        
                        <!-- Verify Tab -->
                        <div class="tab-pane fade" id="verify" role="tabpanel" aria-labelledby="verify-tab">
                            <form action="{{ route('crypto.verify') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="data" class="form-label">Original Data</label>
                                    <textarea class="form-control" id="data" name="data" rows="3" required>{{ old('data') }}</textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="signature" class="form-label">Signature (Base64)</label>
                                    <textarea class="form-control" id="signature" name="signature" rows="3" required>{{ old('signature') }}</textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="public_key" class="form-label">Public Key (PEM format)</label>
                                    <textarea class="form-control" id="public_key" name="public_key" rows="5" required>{{ old('public_key') }}</textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="algorithm" class="form-label">Signature Algorithm</label>
                                    <select class="form-select" id="algorithm" name="algorithm" required>
                                        @foreach($digestMethods as $method)
                                            <option value="{{ $method }}" {{ $method == 'sha256' ? 'selected' : '' }}>{{ $method }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <button type="submit" class="btn btn-info">Verify Signature</button>
                            </form>
                        </div>
                        
                        <!-- Public Key Encrypt Tab -->
                        <div class="tab-pane fade" id="pk-encrypt" role="tabpanel" aria-labelledby="pk-encrypt-tab">
                            <form action="{{ route('crypto.public-key-encrypt') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="data" class="form-label">Data to Encrypt</label>
                                    <textarea class="form-control" id="data" name="data" rows="3" required>{{ old('data') }}</textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="public_key" class="form-label">Public Key (PEM format)</label>
                                    <textarea class="form-control" id="public_key" name="public_key" rows="5" required>{{ old('public_key') }}</textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-info">Encrypt with Public Key</button>
                            </form>
                        </div>
                        
                        <!-- Private Key Decrypt Tab -->
                        <div class="tab-pane fade" id="pk-decrypt" role="tabpanel" aria-labelledby="pk-decrypt-tab">
                            <form action="{{ route('crypto.private-key-decrypt') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="data" class="form-label">Data to Decrypt (Base64)</label>
                                    <textarea class="form-control" id="data" name="data" rows="3" required>{{ old('data') }}</textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="private_key" class="form-label">Private Key (PEM format)</label>
                                    <textarea class="form-control" id="private_key" name="private_key" rows="5" required>{{ old('private_key') }}</textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-info">Decrypt with Private Key</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            <h3>OpenSSL Information</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4>OpenSSL Version</h4>
                    <pre>{{ OPENSSL_VERSION_TEXT }}</pre>
                </div>
                <div class="col-md-6">
                    <h4>Available Cipher Methods</h4>
                    <div style="max-height: 200px; overflow-y: auto;">
                        <ul class="list-group">
                            @foreach($cipherMethods as $method)
                                <li class="list-group-item">{{ $method }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
