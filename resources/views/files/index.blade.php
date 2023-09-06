@extends('layouts.admin')

@section('main-content')
    <div class="container">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between">
                <button type="button" class="btn btn-primary" data-toggle="modal" id="add-modal" data-target="#upload-file" data-departments="{{ $departments }}">Upload a File</button>
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
                            <td>{{ $file->user->username }}</td>
                            <td>{{ $file->created_at }}</td>
                            <td>
                                <a href="/files/{{ $file->document_id }}" class="btn btn-secondary btn-sm">View</a>
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edit-modal" data-file="{{ $file }}">Edit</button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete-modal" data-file="{{ $file }}">Delete</button>
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
                     <div id="departments-div" class="row d-flex justify-content-between ml-2">
                        
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

{{-- Edit Modal --}}
<div class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/files" method="POST" id="edit-form">
            @csrf
            <input type="hidden" name="_method" id="_control" value="PUT">
            <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Edit Document</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label for="">Filename:</label>
                        <input type="text" name="filename" id="edit-filename" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Description:</label>
                        <textarea name="description" id="edit-description" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
      
    </div>
  </div>

  {{-- End Edit Modal --}}
  <div class="modal fade" id="delete-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="/files" method="POST" id="delete-form">
            @csrf
            <input type="hidden" name="_method" id="_delete-control" value="DELETE">
            <div class="modal-header">
                <h5 class="modal-title">Delete Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>You are about to delete <strong><span id="delete-filename"></span></strong>, continue?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
        
      </div>
    </div>
  </div>

  {{-- Delete Modal --}}

@section('script')
    <script>
        $('#file').on('change', function(e) {
            let filename = event.target.files[0].name
            $('#file-name').text(filename)
        })

        $('#upload-file').on('show.bs.modal', function(e) {
            let departments = $(e.relatedTarget).data('departments')
            departments.forEach(department => {
                let department_div = '<div class="col-6 form-check department-class mb-1"><input type="checkbox" name="departments[]" class="form-check-input" value="' + department.id + '" id="department-' + department.id + '" style="cursor:pointer"><label="form-check-label" for="department-' + department.id + '">' + department.office_name + '</label></div>'
                $('#departments-div').append(department_div)
            });
        })

        $('#edit-modal').on('show.bs.modal', function(e) {
            let file = $(e.relatedTarget).data('file')
            $('#edit-filename').val(file.filename)
            $('#edit-description').val(file.description)
            $('#edit-form').attr('action', '/files/' + file.document_id)
        })

        $('#delete-modal').on('show.bs.modal', function(e) {
            let file = $(e.relatedTarget).data('file')
            $('#delete-form').attr('action', '/files/' + file.document_id)
            $('#delete-filename').html(file.filename)
        })

    </script>
@endsection


