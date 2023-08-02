@extends('layouts.admin')

@section('main-content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#upload-file">Upload a File</button>
                <input type="text" name="" id="" placeholder="Search File...">
            </div>
        </div>
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    <p>{{ $error }}</p>
                </div>
            @endforeach
        @endif

        @if(session('success'))
        <div class="alert alert-success">
            <p>{{ session('success') }}</p>
        </div>
        @endif
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th>File Number</th>
                        <th>Filename</th>
                        <th>Format</th>
                        <th>Uploaded By</th>
                        <th>Uploaded Date</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($files as $file)
                        <tr>
                            <td>{{ $file->document_id }}</td>
                            <td>{{ $file->filename }}</td>
                            <td>{{ $file->format }}</td>
                            <td>Admin</td>
                            <td>{{ $file->created_at }}</td>
                            <td>
                                <button type="button" class="btn btn-secondary btn-sm">View</button>
                                <button type="button" class="btn btn-warning btn-sm">Edit</button>
                                <button type="button" class="btn btn-danger btn-sm">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

{{-- Upload file modal --}}
<div class="modal fade" id="upload-file" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/files" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" name="user-id" id="" value="{{ Auth::user()->id }}" hidden>
                    <div class="form-group mb-3">
                        <label for="filename">Filename</label>
                        <input type="text" name="filename" id="filename" class="form-control" placeholder="Enter Filename">
                    </div>
                     <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" name="file" id="file" class="custom-file-input" aria-describedby="inputGroupFileAddon01">
                            <label class="custom-file-label" id="file-name" for="inputGroupFile01">Choose file</label>
                        </div>
                     </div>
                     <div class="form-group mb-3">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
                     </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </div>
        </form>
        
    </div>
</div>
{{-- end of Upload file modal --}}



@section('script')
    <script>
        $('#file').on('change', function(e) {
            let filename = event.target.files[0].name
            $('#file-name').text(filename)
        })
    </script>
@endsection


