<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

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
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ]);

        $roles = $data['roles'];
        unset($data['roles']);

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        $user->syncRoles($roles);

        ActivityLog::record('create', 'user', $user, [], [
            'name' => $user->name,
            'email' => $user->email,
            'tanggal_lahir' => $user->tanggal_lahir,
            'unit' => $user->unit,
            'roles' => $roles,
        ]);

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
            'email' => 'required|email|unique:users,email,'.$user->id,
            'tanggal_lahir' => 'nullable|date',
            'unit' => 'nullable|string',
            'password' => 'nullable|string|min:6',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ]);

        $before = [
            'name' => $user->name,
            'email' => $user->email,
            'tanggal_lahir' => $user->tanggal_lahir,
            'unit' => $user->unit,
            'roles' => $user->roles->pluck('name')->values()->all(),
        ];

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $roles = $data['roles'];
        unset($data['roles']);

        $user->update($data);
        $user->syncRoles($roles);

        ActivityLog::record('update', 'user', $user, $before, [
            'name' => $user->name,
            'email' => $user->email,
            'tanggal_lahir' => $user->tanggal_lahir,
            'unit' => $user->unit,
            'roles' => $roles,
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diupdate.');
    }

    public function resetPassword(User $user)
    {
        $newPassword = Str::random(10); // Misalnya 10 karakter random

        $user->password = Hash::make($newPassword);
        $user->save();

        ActivityLog::record('reset-password', 'user', $user, [], [
            'name' => $user->name,
            'email' => $user->email,
        ]);

        return back()
            ->with('success', "Password {$user->name} berhasil direset.")
            ->with('new_password', $newPassword);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $user = User::findOrFail($id);

        ActivityLog::record('delete', 'user', $user, [
            'name' => $user->name,
            'email' => $user->email,
            'unit' => $user->unit,
            'roles' => $user->roles->pluck('name')->values()->all(),
        ]);

        // Hapus survey (jika foreign key-nya sudah ON DELETE CASCADE maka relasi ikut kehapus)
        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus.');

    }
}
