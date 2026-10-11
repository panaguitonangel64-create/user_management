<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Read: Display all users and their assigned roles
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Create: Show add user form
    public function create()
    {
        if (Auth::user()?->role !== 'Administrator') {
            abort(403, 'Unauthorized Access: Only administrators can manage users.');
        }

        return view('users.create');
    }

    // Create: Store new user
    public function store(Request $request)
    {
        if (Auth::user()?->role !== 'Administrator') {
            abort(403, 'Unauthorized Access: Only administrators can manage users.');
        }

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|string',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    // Update: Show edit user form
    public function edit(User $user)
    {
        if (Auth::user()?->role !== 'Administrator') {
            abort(403, 'Unauthorized Access: Only administrators can manage users.');
        }

        return view('users.edit', compact('user'));
    }

    // Update: Save edited user details
    public function update(Request $request, User $user)
    {
        if (Auth::user()?->role !== 'Administrator') {
            abort(403, 'Unauthorized Access: Only administrators can manage users.');
        }

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|string',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // Delete: Remove user from system
    public function destroy(User $user)
    {
        if (Auth::user()?->role !== 'Administrator') {
            abort(403, 'Unauthorized Access: Only administrators can manage users.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}