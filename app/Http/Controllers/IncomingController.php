<?php

namespace App\Http\Controllers;

use App\Models\Incoming;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Files;

class IncomingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incomings = Incoming::with('files.user')->where('department_id', Auth::user()->department_id)->get();     
        return view('incoming.index')->with('incomings', $incomings);
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
}
