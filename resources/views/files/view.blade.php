@extends('layouts.admin')

@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p><strong>Filename:</strong> {{ $file->filename }}</p>
                <p><strong>Uploaded By:</strong> {{ $file->user->username }}</p>
                <p><strong>Upload at:</strong> {{ $file->created_at }}</p>
            </div>
            <div class="col-12">
                <p>{{ $file->file_path }}</p>
                <iframe src="{{ asset('/storage/files/1691061501-Cyril Seberiaga CV - 12.23.2022.pdf') }}" frameborder="0" style="width:100%;min-height:640px;"></iframe>
            </div>
        </div>
    </div>
@endsection