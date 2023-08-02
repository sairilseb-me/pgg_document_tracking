<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Models\Files;
use Illuminate\Http\Request;

use function PHPSTORM_META\map;

class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $files = Files::with('user')->get();
        return view('files.index')->with('files', $files);
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
    public function store(FileRequest $request)
    {
        
        $format = '';
        if($request->file('file')) {
            $file = $request->file('file');
            $filename = time().'-'.$file->getClientOriginalName();
            $path = $file->storeAs('public/files', $filename);
            $format = $file->getClientOriginalExtension();
        }

        
        $date = date('Ymd');
        $count = Files::where('document_id', 'LIKE', "%$date%")->count();
        
        $id = $count == 0 ? 'go'.'-'.$date.'-'.'1' : 'go'.'-'.$date.'-'. $count + 1;
        
        $document = Files::create([
            'document_id' => $id,
            'user_id' => $request->input('user-id'),
            'filename' => $request->input('filename'),
            'format' => $format,
            'description' => $request->input('description'),
            'file_path' => $path
        ]);


        if($document) return redirect()->back()->with('success', 'Successfully uploaded a file.');
        return redirect()->back()->withErrors(['errors' => 'Failed to upload file.']);

    }

    /**
     * Display the specified resource.
     */
    public function show(files $files)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(files $files)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, files $files)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(files $files)
    {
        //
    }
}
