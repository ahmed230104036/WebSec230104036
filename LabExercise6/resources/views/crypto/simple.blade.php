@extends('layouts.master')
@section('title', 'Cryptography Operations')
@section('content')
<div class="container">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $errorMsg)
                <li>{{ $errorMsg }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (!empty($error))
    <div class="alert alert-danger">
        <p class="mb-0">{{ $error }}</p>
    </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('crypto.process') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="data" class="form-label">Data:</label>
                    <textarea class="form-control" id="data" name="data" rows="3" required>{{ old('data', $data ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="operation" class="form-label">Operation:</label>
                    <select class="form-select" id="operation" name="operation" required onchange="toggleKeyFields()">
                        <option value="encrypt" {{ (old('operation', $operation ?? '') == 'encrypt') ? 'selected' : '' }}>Encrypt</option>
                        <option value="decrypt" {{ (old('operation', $operation ?? '') == 'decrypt') ? 'selected' : '' }}>Decrypt</option>
                        <option value="hash" {{ (old('operation', $operation ?? '') == 'hash') ? 'selected' : '' }}>Hash</option>
                        <option value="sign" {{ (old('operation', $operation ?? '') == 'sign') ? 'selected' : '' }}>Sign</option>
                        <option value="verify" {{ (old('operation', $operation ?? '') == 'verify') ? 'selected' : '' }}>Verify</option>
                    </select>
                </div>

                <div id="key_fields" class="d-none">
                    <div class="mb-3" id="private_key_field">
                        <label for="private_key" class="form-label">Private Key (PEM format):</label>
                        <div class="input-group">
                            <textarea class="form-control" id="private_key" name="private_key" rows="3">{{ old('private_key', $private_key ?? '') }}</textarea>
                            <button class="btn btn-outline-secondary" type="button" onclick="generateKeyPair()">Generate Keys</button>
                        </div>
                        <small class="form-text text-muted">Click "Generate Keys" to create a new RSA key pair.</small>
                    </div>

                    <div class="mb-3" id="public_key_field">
                        <label for="public_key" class="form-label">Public Key (PEM format):</label>
                        <textarea class="form-control" id="public_key" name="public_key" rows="3">{{ old('public_key', $public_key ?? '') }}</textarea>
                    </div>

                    <div class="mb-3" id="signature_field">
                        <label for="signature" class="form-label">Signature (Base64):</label>
                        <textarea class="form-control" id="signature" name="signature" rows="3">{{ old('signature', $signature ?? '') }}</textarea>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="result" class="form-label">Result:</label>
                    <textarea class="form-control" id="result" name="result" rows="3" readonly>{{ $result ?? '' }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

    @if(isset($result_status))
    <div class="mt-3">
        <div class="alert alert-success">
            <strong>Result Status:</strong> {{ $result_status }}
        </div>
    </div>
    @endif
</div>


<script>
function toggleKeyFields() {
    const operation = document.getElementById('operation').value;
    const keyFields = document.getElementById('key_fields');
    const privateKeyField = document.getElementById('private_key_field');
    const publicKeyField = document.getElementById('public_key_field');
    const signatureField = document.getElementById('signature_field');

    keyFields.classList.add('d-none');
    privateKeyField.classList.add('d-none');
    publicKeyField.classList.add('d-none');
    signatureField.classList.add('d-none');

    if (operation === 'sign') {
        keyFields.classList.remove('d-none');
        privateKeyField.classList.remove('d-none');
        publicKeyField.classList.remove('d-none');
    } else if (operation === 'verify') {
        keyFields.classList.remove('d-none');
        publicKeyField.classList.remove('d-none');
        signatureField.classList.remove('d-none');
    }
}

function generateKeyPair() {
    const privateKeyField = document.getElementById('private_key');
    const publicKeyField = document.getElementById('public_key');

    privateKeyField.value = "Generating keys...";
    publicKeyField.value = "Please wait...";

    // Create form data
    const formData = new FormData();
    formData.append('bits', 2048);
    formData.append('digest_alg', 'sha256');
    formData.append('_token', '{{ csrf_token() }}');

    fetch('{{ route("crypto.generate-keypair") }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            privateKeyField.value = data.privateKey;
            publicKeyField.value = data.publicKey;
        } else {
            privateKeyField.value = "Error generating keys: " + data.error;
            publicKeyField.value = "";
        }
    })
    .catch(error => {
        privateKeyField.value = "Error generating keys. Please try again.";
        console.error('Error:', error);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    toggleKeyFields();
});
</script>
@endsection
