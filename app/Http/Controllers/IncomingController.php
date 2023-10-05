<?php

namespace App\Http\Controllers;

use App\Models\Incoming;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Files;
use Exception;
use Illuminate\Support\Facades\Storage;

class IncomingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pending = Incoming::where('status', 0)->where('department_id', Auth::user()->department_id)->count();
        $received = Incoming::where('status', 1)->where('department_id', Auth::user()->department_id)->count();
        $incomings = Incoming::with(['files.user', 'reroutes'])->where('department_id', Auth::user()->department_id)->where('status', '!=', 2)->orderBy('status', 'asc')->get();  
        return view('incoming.index')->with([
            'incomings' => $incomings,
            'pending' => $pending,
            'received' => $received
        ]);
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
    public function show(Incoming $incoming)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Incoming $incoming)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Incoming $incoming)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incoming $incoming)
    {
        //
    }

    public function fileReceived($id)
    {
            $incoming = Incoming::findOrFail($id);

            $incoming->received_by = Auth::user()->id;
            $incoming->status = 1;
            $incoming->received_date = date('Y-m-d H:i:s');
            $incoming->update();

            session()->flash('success', 'You have accepted a file.');
    
            return redirect()->back();
       
    }
}
