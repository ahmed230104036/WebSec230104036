@extends('layouts.master')
@section('title', 'RSA Key Pair')
@section('content')
<div class="container">
    <h1 class="mb-4">Generated RSA Key Pair</h1>
    
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
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3>Key Details</h3>
                </div>
                <div class="card-body">
                    <p><strong>Key Size:</strong> {{ $bits }} bits</p>
                    <p><strong>Digest Algorithm:</strong> {{ $digestAlg }}</p>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h3>Private Key</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> Keep this key secure! Never share your private key.
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" rows="10" readonly>{{ $privateKey }}</textarea>
                    </div>
                    <button class="btn btn-primary mt-2" onclick="copyToClipboard('private')">Copy to Clipboard</button>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h3>Public Key</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <textarea class="form-control" rows="5" readonly>{{ $publicKey }}</textarea>
                    </div>
                    <button class="btn btn-primary mt-2" onclick="copyToClipboard('public')">Copy to Clipboard</button>
                </div>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('crypto.simple') }}" class="btn btn-primary">Back to Crypto Tools</a>
                <a href="{{ route('crypto.simple') }}?operation=sign" class="btn btn-success">Use for Signing</a>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(type) {
    const textareas = document.querySelectorAll('textarea');
    const textarea = type === 'private' ? textareas[0] : textareas[1];
    
    textarea.select();
    document.execCommand('copy');
    
    // Show feedback
    const buttons = document.querySelectorAll('.btn-primary');
    const button = type === 'private' ? buttons[0] : buttons[1];
    const originalText = button.textContent;
    
    button.textContent = 'Copied!';
    button.classList.remove('btn-primary');
    button.classList.add('btn-success');
    
    setTimeout(() => {
        button.textContent = originalText;
        button.classList.remove('btn-success');
        button.classList.add('btn-primary');
    }, 2000);
}
</script>
@endsection
