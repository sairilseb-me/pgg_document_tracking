@extends('layouts.admin')

@section('main-content')
    <div class="container">
        <div class="row">
            <h3>Incoming</h3>
        </div>
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th>Filename</th>
                        <th>Sent by</th>
                        <th>Status</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($incomings as $key => $incoming)
                        <tr>
                            <td>{{ $incoming->files[0]->filename }}</td>
                            <td>{{ $incoming->files[0]->user->username }}</td>
                            <td><p class="badge {{ $incoming->status == 0 ? 'badge-warning' : 'badge-success' }} text-wrap">{{ $incoming->status == 0 ? 'Pending' : 'Received' }}</p></td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm">Received</button>
                                <button type="button" class="btn btn-secondary btn-sm">Download</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection