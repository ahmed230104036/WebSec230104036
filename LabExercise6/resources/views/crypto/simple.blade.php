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
                    <select class="form-select" id="operation" name="operation" required>
                        <option value="encrypt" {{ (old('operation', $operation ?? '') == 'encrypt') ? 'selected' : '' }}>Encrypt</option>
                        <option value="decrypt" {{ (old('operation', $operation ?? '') == 'decrypt') ? 'selected' : '' }}>Decrypt</option>
                        <option value="hash" {{ (old('operation', $operation ?? '') == 'hash') ? 'selected' : '' }}>Hash</option>
                    </select>
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


@endsection
