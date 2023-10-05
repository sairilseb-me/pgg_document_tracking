@extends('layouts.admin')

@section('main-content')
    <div class="container">
        <h3 class="mb-3">Re-Routes</h3>
        <div class="row">
            <div class="card col-12">
                <div class="col-12">
                    <div class="col-12 mt-3">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <table class="table mt-5 col-12">
                        <thead>
                            <tr>
                                <th>Filename</th>
                                <th>Requested By</th>
                                <th>Remarks</th>
                                <th>Status</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reroutes as $reroute)
                                <tr>
                                    <td>{{ $reroute->incoming->files[0]->filename }}</td>
                                    <td>{{ $reroute->from_office }}</td>
                                    <td>{!! $reroute->remarks !!}</td>
                                    <td>
                                        @if ($reroute->status == 0)
                                            <p class="badge badge-warning text-wrap">Pending Approval</p>
                                        @elseif ($reroute->status == 1)
                                            <p class="badge badge-danger text-wrap">Disapproved</p>
                                        @else
                                            <p class="badge badge-success text-wrap">Approved</p>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($reroute->status == 0)
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#disapprove-modal" data-reroute="{{ $reroute }}">Disapprove</button>
                                        @endif
                                            <button type="button" class="btn btn-success btn-sm">Approve</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Disapprove Modal -->
<div class="modal fade" id="disapprove-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="" method="POST" id="disapprove-form">
            @csrf
            <input type="hidden" name="_method" value="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Disapprove Re-route Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <label for="remarks">Remarks</label>
                  <textarea name="remarks" id="remarks" cols="30" rows="5" placeholder="Enter why the request was disapproved?" class="form-control"></textarea>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Disapprove</button>
              </div>
        </form>
      </div>
    </div>
</div>

{{-- Ending of Disapprove Modal --}}

@section('script')
    <script>
        $(document).ready(function(){
            $('#disapprove-modal').on('show.bs.modal', function(e){
                let reroute = $(e.relatedTarget).data('reroute')
                let incoming_id = reroute.incoming.id
                $('#disapprove-form').attr('action', '/reroutes-disapproved/' + incoming_id + '/' + reroute.id)
            })
        })
    </script>
@endsection