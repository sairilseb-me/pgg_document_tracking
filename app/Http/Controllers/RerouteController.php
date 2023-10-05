<?php

namespace App\Http\Controllers;

use App\Models\Incoming;
use App\Models\Reroute;
use Illuminate\Http\Request;

class RerouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reroutes = Reroute::with(['incoming.files'])->orderBy('status', 'asc')->get();
        return view('reroutes.index')->with('reroutes', $reroutes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Reroute $reroute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reroute $reroute)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reroute $reroute)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reroute $reroute)
    {
        //
    }

    public function requestReroute(Request $request, $incoming_id)
    {
        $validate = $request->validate([
            'remarks' => 'required|string'
        ]);

        $incoming = Incoming::findOrFail($incoming_id);
        $incoming->status = 2;
        $incoming->update();

        $reroute = Reroute::create([
            'incoming_id' => $incoming_id,
            'from_office' => auth()->user()->department->office_name,
            'status' => 0,
            'remarks' => "<strong>".auth()->user()->department->office_name."</strong>: ".$request->input('remarks').'<br>',
            'date_rerouted' => date('Y-m-d H:i:s'),
        ]);
        
        return redirect()->back()->with('success', 'Requested to reroute an incoming file.');
    }

    public function disapproveReroute(Request $request, $incoming_id, $reroute_id)
    {
        $validate = $request->validate([
            'remarks' => 'required|string',
        ]);

        $remarks = "<strong>".auth()->user()->username.'</strong> disapproved request for reroute.'."<br>".'<strong>Reason</strong>: '. $request->input('remarks');

        $incoming = Incoming::findOrFail($incoming_id);
        $incoming->status = 1;
        $incoming->update();

        $reroute = Reroute::findOrFail($reroute_id);
        $reroute->status = 1;
        $reroute->remarks .= $remarks;
        $reroute->update();

        return redirect()->back()->with('success', 'Re-route request was disapproved.');
    }

    public function approveReroute()
    {
        
    }
}
