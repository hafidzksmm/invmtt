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
     * Update username, role, & (opsional) password milik user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'username' => 'required|string|min:3|max:255|unique:users,username,' . $user->id,
            'password' => ['nullable', 'confirmed', Password::min(7)],
            'role'     => 'sometimes|required|in:admin,superadmin,user',
        ], [
            'username.required'  => 'Username wajib diisi.',
            'username.unique'    => 'Username sudah digunakan, silakan pilih username lain.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required'      => 'Role wajib dipilih.',
            'role.in'            => 'Role tidak valid.',
        ]);

        $user->username = $validated['username'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        if (array_key_exists('role', $validated)) {
            $user->role = $validated['role'];
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Hapus user.
     * Superadmin: bebas hapus siapa saja tanpa kecuali (termasuk diri sendiri
     * & superadmin terakhir). Role lain tetap mengikuti restriksi lama.
     */
    public function destroy(Request $request, User $user)
    {
        $actor = $request->user();

        if ($actor && $actor->role === 'superadmin') {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
        }

        if ($actor && $actor->id === $user->id) {
            return redirect()->route('users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        if ($user->role === 'superadmin' && User::where('role', 'superadmin')->count() <= 1) {
            return redirect()->route('users.index')->with('error', 'Tidak dapat menghapus superadmin terakhir.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    /**
     * ✅ BARU: Ubah password milik akun yang sedang login sendiri
     * (dipakai oleh dropdown avatar di dashboard).
     */
/**
     * ✅ Ubah password milik akun yang sedang login sendiri
     * (dipakai oleh dropdown avatar di dashboard).
     * Setelah berhasil, user otomatis di-logout & dilempar ke halaman login
     * demi keamanan (memastikan sesi lama tidak lagi valid).
     */
    public function changePassword(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'new_password'     => ['required', 'confirmed', Password::min(7)],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'new_password.required'     => 'Password baru wajib diisi.',
            'new_password.confirmed'    => 'Konfirmasi password baru tidak cocok.',
        ]);

        // Pastikan password lama benar
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Password saat ini yang Anda masukkan salah.'])
                ->withInput();
        }

        $user->password = Hash::make($validated['new_password']);
        $user->save();

        // 🔐 Logout paksa demi keamanan setelah password berhasil diubah
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('sign-in')->with('success', 'Password berhasil diubah. Silakan login kembali dengan password baru Anda.');
    }
    }