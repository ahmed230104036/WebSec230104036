@extends('layouts.master')
@section('title', 'Crypto Operation Result')
@section('content')
<div class="container">
    <h1 class="mb-4">{{ $operation }} Result</h1>
    
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h3>Result</h3>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">{{ $operation }} Result</label>
                <div class="input-group">
                    <textarea class="form-control" rows="5" readonly>{{ $result }}</textarea>
                    <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('result')">Copy</button>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Input</label>
                <textarea class="form-control" rows="3" readonly>{{ $input }}</textarea>
            </div>
            
            @if(isset($key))
            <div class="mb-3">
                <label class="form-label">Key</label>
                <input type="text" class="form-control" value="{{ $key }}" readonly>
            </div>
            @endif
            
            @if(isset($iv))
            <div class="mb-3">
                <label class="form-label">IV</label>
                <input type="text" class="form-control" value="{{ $iv }}" readonly>
            </div>
            @endif
            
            @if(isset($cipher))
            <div class="mb-3">
                <label class="form-label">Cipher</label>
                <input type="text" class="form-control" value="{{ $cipher }}" readonly>
            </div>
            @endif
            
            @if(isset($algorithm))
            <div class="mb-3">
                <label class="form-label">Algorithm</label>
                <input type="text" class="form-control" value="{{ $algorithm }}" readonly>
            </div>
            @endif
        </div>
    </div>
    
    <div class="d-flex justify-content-between">
        <a href="{{ route('crypto.index') }}" class="btn btn-primary">Back to Crypto Tools</a>
        
        @if($operation == 'Encryption')
        <a href="{{ route('crypto.index') }}#decrypt" class="btn btn-success" onclick="prepareDecryption('{{ $result }}', '{{ $cipher }}')">Decrypt This</a>
        @endif
        
        @if($operation == 'Decryption')
        <a href="{{ route('crypto.index') }}#encrypt" class="btn btn-success">Encrypt New Data</a>
        @endif
    </div>
</div>

<script>
function copyToClipboard(type) {
    const textarea = document.querySelector('textarea');
    textarea.select();
    document.execCommand('copy');
}

function prepareDecryption(ciphertext, cipher) {
    // Store the values in sessionStorage to be used on the next page
    sessionStorage.setItem('ciphertext', ciphertext);
    sessionStorage.setItem('cipher', cipher);
    
    // The decrypt tab will use these values when loaded
}

// Add event listener to populate fields from sessionStorage when page loads
document.addEventListener('DOMContentLoaded', function() {
    const decryptTab = document.getElementById('decrypt-tab');
    if (decryptTab) {
        decryptTab.addEventListener('click', function() {
            const ciphertext = sessionStorage.getItem('ciphertext');
            const cipher = sessionStorage.getItem('cipher');
            
            if (ciphertext) {
                document.getElementById('ciphertext').value = ciphertext;
                sessionStorage.removeItem('ciphertext');
            }
            
            if (cipher) {
                const cipherSelect = document.querySelector('#decrypt select[name="cipher"]');
                if (cipherSelect) {
                    for (let i = 0; i < cipherSelect.options.length; i++) {
                        if (cipherSelect.options[i].value === cipher) {
                            cipherSelect.selectedIndex = i;
                            break;
                        }
                    }
                }
                sessionStorage.removeItem('cipher');
            }
        });
    }
});
</script>
@endsection
