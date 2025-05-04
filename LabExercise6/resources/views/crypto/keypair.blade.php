@extends('layouts.master')
@section('title', 'Key Pair Generation')
@section('content')
<div class="container">
    <h1 class="mb-4">Key Pair Generation Result</h1>
    
    <div class="alert alert-warning">
        <strong>Warning:</strong> In a real-world application, you should never display private keys on a web page. This is for demonstration purposes only.
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    <h3>Private Key</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="input-group">
                            <textarea class="form-control" id="privateKey" rows="15" readonly>{{ $privateKey }}</textarea>
                            <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('privateKey')">Copy</button>
                        </div>
                        <small class="text-muted">Keep this key secret! It can be used to decrypt messages and sign data.</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h3>Public Key</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="input-group">
                            <textarea class="form-control" id="publicKey" rows="15" readonly>{{ $publicKey }}</textarea>
                            <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('publicKey')">Copy</button>
                        </div>
                        <small class="text-muted">This key can be shared publicly. It can be used to encrypt messages and verify signatures.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <h3>Key Information</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Key Size:</strong> {{ $bits }} bits</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Digest Algorithm:</strong> {{ $digestAlg }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="d-flex justify-content-between">
        <a href="{{ route('crypto.index') }}" class="btn btn-primary">Back to Crypto Tools</a>
        
        <div>
            <a href="{{ route('crypto.index') }}#sign" class="btn btn-success" onclick="prepareForSigning()">Use for Signing</a>
            <a href="{{ route('crypto.index') }}#pk-encrypt" class="btn btn-info" onclick="prepareForEncryption()">Use for Encryption</a>
        </div>
    </div>
</div>

<script>
function copyToClipboard(elementId) {
    const textarea = document.getElementById(elementId);
    textarea.select();
    document.execCommand('copy');
}

function prepareForSigning() {
    // Store the private key in sessionStorage to be used on the next page
    sessionStorage.setItem('privateKey', document.getElementById('privateKey').value);
}

function prepareForEncryption() {
    // Store the public key in sessionStorage to be used on the next page
    sessionStorage.setItem('publicKey', document.getElementById('publicKey').value);
}

// Add event listeners to populate fields from sessionStorage when page loads
document.addEventListener('DOMContentLoaded', function() {
    const signTab = document.getElementById('sign-tab');
    if (signTab) {
        signTab.addEventListener('click', function() {
            const privateKey = sessionStorage.getItem('privateKey');
            if (privateKey) {
                document.querySelector('#sign textarea[name="private_key"]').value = privateKey;
                sessionStorage.removeItem('privateKey');
            }
        });
    }
    
    const encryptTab = document.getElementById('pk-encrypt-tab');
    if (encryptTab) {
        encryptTab.addEventListener('click', function() {
            const publicKey = sessionStorage.getItem('publicKey');
            if (publicKey) {
                document.querySelector('#pk-encrypt textarea[name="public_key"]').value = publicKey;
                sessionStorage.removeItem('publicKey');
            }
        });
    }
});
</script>
@endsection
