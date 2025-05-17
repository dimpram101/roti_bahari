<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller {
    public function index(Request $request) {
        $users = User::all();

        return view('dashboard.user.index', [
            'users' => $users,
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,user',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $imageName = str_replace(' ', '_', $request->name) . '_' . date('Ymd_His') . '.' . $extension;
            $imagePath = $request->file('image')->storeAs('images/user', $imageName, 'public');
            $imageName = $imagePath;
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'image' => $imageName,
        ])->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:admin,user',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $extension = $request->file('image')->getClientOriginalExtension();
            $imageName = str_replace(' ', '_', $request->name) . '_' . date('Ymd_His') . '.' . $extension;
            $imagePath = $request->file('image')->storeAs('images/user', $imageName, 'public');
            $validatedData['image'] = $imagePath;
        }

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);
        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(Request $request, $id) {
        $user = User::findOrFail($id);

        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
