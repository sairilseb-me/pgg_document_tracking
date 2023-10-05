@extends('layouts.admin')

@section('main-content')
    <div class="container">
        <div class="row mb-2">
            <div class="col-12 d-flex justify-content-between">
                <h3>Incoming</h3>
                <div class="d-flex">
                    <p class="bg-warning px-5 py-2 mr-2 text-white">Pending: {{ $pending }}</p>
                    <p class="bg-success px-5 py-2 text-white">Received: {{ $received }}</p>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <input type="text" name="search" id="search" placeholder="Search File...." class="px-2 py-1">
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                @if($errors->any())
                    @foreach ($errors->all() as $error)
                        <p class="aler alert-danger">{{ $error }}</p>
                    @endforeach
                @endif

                @if (session('success'))
                    <p class="alert alert-success">
                        {{ session('success') }}
                    </p>
                @endif
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Filename</th>
                        <th>Sent by</th>
                        <th>Status</th>
                        <th>Received Date</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($incomings as $key => $incoming)
                        <tr>
                            <td>{{ $incoming->files[0]->filename }}</td>
                            <td>{{ $incoming->files[0]->user->username }}</td>
                            {{-- <td><p class="badge {{ $incoming->status == 0 ? 'badge-warning' : 'badge-success' }} text-wrap">{{ $incoming->status == 0 ? 'Pending' : 'Received' }}</p></td> --}}
                            <td>
                                @if($incoming->status == 0)
                                    <p class="badge badge-warning text-wrap">Pending</p>
                                @elseif ($incoming->status == 1)
                                    <p class="badge badge-success text-wrap">Received</p>
                                @endif
                            </td>
                            <td>{{ $incoming->received_date ? date('M-d-Y H:i:s', strtotime($incoming->received_date)) : 'N/A' }}</td>
                            <td class="d-flex">
                                @php
                                    $filenameArray = explode('/', $incoming->files[0]->file_path);
                                    $filename = end($filenameArray);
                                @endphp
                                @if($incoming->status == 0)
                                    <form action="/file-received/{{ $incoming->id }}" method="POST" class="mr-1">
                                        @csrf
                                        <input type="hidden" name="_method" value="PATCH">
                                        <button type="submit" class="btn btn-primary btn-sm">Received</button>
                                    </form>                
                                @else
                                    <div>
                                        @if(count($incoming->reroutes) > 0)
                                            @php
                                                $remarks = $incoming->reroutes;
                                            @endphp
                                            <button type="button" class="btn btn-danger btn-sm" id="reroute-request-modal" data-toggle="tooltip" data-placement="top" title="Click to see reason!" onclick="showReason({{ $remarks }})">Reroute Disapproved</button>
                                        @endif
                                        <a href="{{ asset('storage/files/'.$filename) }}" class="btn btn-secondary btn-sm">Download</a>
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#reroute-modal" data-incoming="{{ $incoming }}">Re-route</button>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

<!-- Re-route Modal -->
<div class="modal fade" id="reroute-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="/request-reroute" method="POST" id="reroute-form">
            @csrf
            <input type="hidden" name="_method" value="POST">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Re-route Incoming File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                    <div class="form-group">
                        <label for="remarks">Remarks:</label>
                        <textarea name="remarks" id="remarks" cols="30" rows="3" placeholder="Enter your remarks..." class="form-control" required></textarea>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-warning">Re Route File</button>
            </div>
        </form>
        
      </div>
    </div>
</div>

{{-- End of Re-route Modal --}}

{{-- Reroute Request Disapproved Modal --}}

<div class="modal fade" id="disapproved-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reroute Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                    <p id="remarks-reason"></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
      </div>
    </div>
</div>

{{-- End of Reroute Request Disapproved Modal --}}

@section('script')
    <script>
        $(document).ready(function(){

            $('#reroute-modal').on('show.bs.modal', function(e){
                let incoming = $(e.relatedTarget).data('incoming')
                $('#reroute-form').attr('action', '/request-reroute/' + incoming.id)
            })
        })

        function showReason(remarks){
            $('#disapproved-modal').modal('show')
            let latestReroute = remarks.at(-1)
            $('#remarks-reason').html(latestReroute.remarks)
        }
    </script>
@endsection
