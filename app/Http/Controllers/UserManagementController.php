<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserManagementController extends Controller
{
    /**
     * Daftar semua user (hanya bisa diakses superadmin — lihat routes/web.php).
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Tampilkan form register user baru.
     */
    public function create()
    {
        return view('users.register');
    }

    /**
     * Simpan user baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|min:3|max:255|unique:users,username',
            'name'     => 'required|string|max:255',
            'password' => ['required', 'confirmed', Password::min(7)],
            'role'     => 'required|in:admin,superadmin,user',
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique'   => 'Username sudah digunakan, silakan pilih username lain.',
            'name.required'     => 'Nama wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required'     => 'Role wajib dipilih.',
            'role.in'           => 'Role tidak valid.',
        ]);

        User::create([
            'username' => $validated['username'],
            'name'     => $validated['name'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        return redirect()->route('users.index')->with('success', 'User baru berhasil didaftarkan.');
    }

    /**
     * Update username & (opsional) password milik user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => 'required|string|min:3|max:255|unique:users,username,' . $user->id,
            'password' => ['nullable', 'confirmed', Password::min(7)],
        ], [
            'username.required'  => 'Username wajib diisi.',
            'username.unique'    => 'Username sudah digunakan, silakan pilih username lain.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user->username = $validated['username'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Hapus user.
     */
    public function destroy(Request $request, User $user)
    {
        if ($request->user() && $request->user()->id === $user->id) {
            return redirect()->route('users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($user->role === 'superadmin' && User::where('role', 'superadmin')->count() <= 1) {
            return redirect()->route('users.index')->with('error', 'Tidak dapat menghapus superadmin terakhir.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
