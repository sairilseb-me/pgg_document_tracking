@extends('layouts.admin')

@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <h3>Users Page</h3>
            </div>
            <div class="col-12 d-flex justify-content-between mb-3">
                <button type="button" data-toggle="modal" data-target="#control-modal" id="add-user-btn" class="btn btn-primary">Create User</button>
                <input type="text" name="search" id="search" placeholder="Search User..." class="px-2">
            </div>
        </div>
        <div class="row">
            <div class="col-12 mb-3">
                @if($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            <p>{{ $error }}</p>
                        </div>
                    @endforeach
                @endif

                @if (session('success'))
                    <div class="alert alert-success">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
            </div>
            <div class="col-12 mb-3">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Department</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->role->name }}</td>
                                <td>{{ $user->department->office_name }}</td>
                                <td>
                                    <div class="">
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#control-modal" data-user="{{ $user }}">Edit</button>
                                        <button type="button" class="btn btn-danger btn-sm">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

{{-- User Control Modal --}}

<div class="modal fade" id="control-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="/users" method="POST" id="user-form">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="controlModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter name here...">
                </div>
                <div class="form-group mb-3">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Enter username here...">
                </div>
                <div class="form-group mb-3 password-div">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter password here...">
                </div>
                <div class="form-group mb-3">
                    <label for="role">Role</label>
                    <select name="role" id="select-role" class="form-control">
                        <option disbaled selected class="text-muted pr-1">Select Role</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="department">Department</label>
                    <select name="department" id="select-department" class="form-control">
                        <option disbaled selected class="text-muted pr-1">Select Department</option>
                    </select>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
        </form>
      </div>
    </div>
</div>

@section('script')
    <script>

        let roles = {!! json_encode($roles->toArray(), JSON_HEX_TAG) !!}
        let departments = {!! json_encode($departments->toArray(), JSON_HEX_TAG) !!}

        $('#add-user-btn').on('click', function(){
            $('#controlModalLabel').text('Add User')
            resetForm($('#control-modal'))
            $('.password-div').show()
            $('#update-input').remove()
        })

        $('#control-modal').on('show.bs.modal', function(e){
            $('.role-list').remove()
            $('.department-list').remove()
            resetForm($('#control-modal'))
            let user;
            if($(e.relatedTarget).data('user'))
            {
                user = $(e.relatedTarget).data('user')
                $('#name').val(user.name)
                $('.password-div').hide()
                $('#username').val(user.username)
                $('#select-role').text(roles[user.role_id])
                $('#select-department selected').text(departments[user.department_id])  
                let updateInput = '<input type="hidden" name="_method" value="PATCH" id="update-input">'
                $('#user-form').prepend(updateInput)
                $('#user-form').attr('action', '/users/' + user.id)
            }

            roles.forEach(role => {
                    let list = ''
                    if(typeof user !== 'undefined')
                    {
                        if(user.role_id == role.id)
                        {
                            list = '<option value="' + role.id + '" class="role-list" style="cursor: pointer" selected>' + role.name + '</option>'
                        }else {
                            list = '<option value="' + role.id + '" class="role-list" style="cursor: pointer">' + role.name + '</option>'
                        }
                    }else {
                        list = '<option value="' + role.id + '" class="role-list" style="cursor: pointer">' + role.name + '</option>'
                    }
                    $('#select-role').append(list)
                });

            departments.forEach(department => {
                let list = ''
                if(typeof user !== 'undefined')
                {
                    if(department.id == user.department_id)
                    {
                        list = '<option value="' + department.id + '" class="department-list" style="cursor: pointer" selected>' + department.office_name + '</option>'
                    } else {
                        list = '<option value="' + department.id + '" class="department-list" style="cursor: pointer">' + department.office_name + '</option>'
                    }
                }else {
                    list = '<option value="' + department.id + '" class="department-list" style="cursor: pointer">' + department.office_name + '</option>'
                }
                
                $('#select-department').append(list)
            })

        })

        function resetForm($form)
        {
            $form.find('input:text, input:password, textarea, input:file, select').val("")
        }
        
    </script>
@endsection
