<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */

public function index()
{
    $users = User::with('roles')->get(); // agar relasi role ikut di-load
    return view('admin.user.index', compact('users'));
}


    /**
     * Show the form for creating a new resource.
**/

public function create()
{
    $roles = Role::all();
    $units = [
        'Prodi D3 Kebidanan',
        'Prodi S1Farmasi',
        'Prodi S1 Gizi',
        'Tendik',
    ];
    return view('admin.user.create', compact('roles', 'units'));
}
public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'tanggal_lahir' => 'nullable|date',
        'unit' => 'nullable|string',
        'password' => 'required|string|min:6',
        'roles' => 'required|array'
    ]);

    $data['password'] = Hash::make($data['password']);

    $user = User::create($data);
    $user->syncRoles($request->roles);

    return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan.');
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
public function edit(User $user)
{
    $roles = Role::all();
    $units = [
        'Prodi D3 Kebidanan',
        'Prodi S1Farmasi',
        'Prodi S1 Gizi',
        'Tendik',
    ];
    return view('admin.user.edit', compact('user', 'roles', 'units'));
}


    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, User $user)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'tanggal_lahir' => 'nullable|date',
        'unit' => 'nullable|string',
        'password' => 'nullable|string|min:6',
        'roles' => 'required|array'
    ]);

    if (!empty($data['password'])) {
        $data['password'] = Hash::make($data['password']);
    } else {
        unset($data['password']);
    }

    $user->update($data);
    $user->syncRoles($request->roles);

    return redirect()->route('admin.user.index')->with('success', 'User berhasil diupdate.');
}


public function resetPassword(User $user)
{
    $newPassword = Str::random(10); // Misalnya 10 karakter random

    $user->password = Hash::make($newPassword);
    $user->save();

    return back()->with('success', "Anda telah merubah Password {$user->name} dan password barunya adalah <strong>{$newPassword}</strong>");
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
{
    $user = User::findOrFail($id);

    // Hapus survey (jika foreign key-nya sudah ON DELETE CASCADE maka relasi ikut kehapus)
    $user->delete();

    return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus.');
    }
}
}