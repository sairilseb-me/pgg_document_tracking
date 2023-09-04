<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $users = new User();    
        $roles = new Role();
        $departments = new Department(); 
        return view('users.index')->with(['users' => $users->getUsersWithRoleAndDepartment(), 'roles' => $roles->getRoles(), 'departments' => $departments->getDepartments()]);
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
    public function store(UserRequest $request, User $user)
    {
        $user->addNewUser($request->all());

        return redirect()->back()->with('success', 'Successfully created a new User.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id, Request $request)
    {
        
        $request->integer('role');
        $request->integer('department');

        $validated = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string',
            'role' => 'required|numeric',
            'department' => 'required|numeric'
        ]);

        $user = User::findOrFail($id);

        $user->updateUser($validated);

        return redirect()->back()->with('success', 'Successfully update user data.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
