# ROLE-BASED ACCESS CONTROL GUIDE

## 📋 User Roles yang Tersedia:
- **Admin**: Bisa CRUD (Create, Read, Update, Delete) semua data
- **User**: Hanya bisa Read/View saja, tidak bisa CRUD

## 🔑 Demo Credentials:
```
ADMIN:
- Username: admin
- Password: admin123

USER:
- Username: user
- Password: user123
```

## 🛡️ Implementation Summary:

### 1. Routes Protection ✅
Semua CRUD routes sudah di-protect dengan middleware `admin`:
- POST (Create) → requires admin
- PUT (Update) → requires admin
- DELETE (Delete) → requires admin
- GET (Read/View) → available untuk semua authenticated users

### 2. Middleware ✅
- Middleware: `App\Http\Middleware\CheckAdminRole`
- Alias: `admin`
- Location: `app/Http/Middleware/CheckAdminRole.php`

### 3. Helper Functions ✅
Available di semua views:
```php
isAdmin()           // return true jika user adalah admin
isUser()            // return true jika user adalah regular user
getUserRole()       // return role string (admin/user)
```

### 4. Update Views untuk Hide/Show Buttons

#### Di Blade Template, gunakan:

```blade
<!-- HIDE BUTTONS FOR NON-ADMIN USERS -->
@if(isAdmin())
    <!-- Add/Create Button -->
    <button onclick="showAddModal()" class="btn btn-primary">
        <svg>...</svg> Tambah Data
    </button>
@endif

<!-- EDIT & DELETE BUTTONS IN TABLE ROW -->
<td>
    @if(isAdmin())
        <button onclick="editItem({{ $item->id }})" class="btn-edit">Edit</button>
        <button onclick="deleteItem({{ $item->id }})" class="btn-delete">Hapus</button>
    @else
        <span class="text-muted">Tidak ada akses edit</span>
    @endif
</td>

<!-- IMPORT BUTTON -->
@if(isAdmin())
    <div class="import-section">
        <input type="file" id="fileImport" accept=".xlsx,.xls">
        <button onclick="importData()">Import</button>
    </div>
@endif
```

### 5. Files yang Perlu Di-Update:

Tambahkan `@if(isAdmin())` wrapper ke sekitar tombol berikut di setiap blade file:

#### [resources/views/aset.blade.php](resources/views/aset.blade.php)
- Tombol "Tambah Aset Baru"
- Tombol Edit (di setiap row)
- Tombol Delete (di setiap row)
- Section Import/Export (edit bagian Show Import saja)

#### [resources/views/proyek.blade.php](resources/views/proyek.blade.php)
- Tombol "Tambah Project"
- Tombol Edit (di setiap row)
- Tombol Delete (di setiap row)
- Section Import

#### [resources/views/ws.blade.php](resources/views/ws.blade.php)
- Tombol "Tambah Inventori"
- Tombol Edit (di setiap row)
- Tombol Delete (di setiap row)
- Section Import

#### [resources/views/do/index.blade.php](resources/views/do/index.blade.php)
- Tombol "Tambah DO"
- Tombol Edit
- Tombol Delete
- Upload File button

### 6. Authentication Check

Jika user belum login atau bukan admin, dan mencoba akses CRUD routes, akan dipaksa redirect dengan pesan error:
```
"Anda tidak memiliki akses untuk melakukan operasi ini. Hanya admin yang bisa CRUD."
```

## 🔒 Security Notes:
- Route protection sudah ada di backend (middleware)
- UI buttons hanya decorative - security sebenarnya di routes
- Jika user berani modify HTML dan kirim request CRUD tanpa admin role, tetap akan ditolak middleware
- Password sudah di-hash dengan Laravel Hashing

## 📝 Testing:

1. **Login sebagai Admin:**
   - Lihat semua CRUD buttons (Tambah, Edit, Delete)
   - Bisa melakukan semua operasi

2. **Login sebagai User:**
   - Tidak lihat tombol CRUD
   - Jika coba akses URL CRUD secara langsung, akan redirect dengan error message

## ⚙️ Customize Demo Credentials:

Edit [database/seeders/CreateDemoUsers.php](database/seeders/CreateDemoUsers.php):
```php
User::updateOrCreate(
    ['username' => 'custom_username'],
    [
        'password' => Hash::make('custom_password'),
        'role' => 'admin', // atau 'user'
    ]
);
```

Kemudian jalankan:
```bash
php artisan db:seed --class=CreateDemoUsers
```

---

**Selamat! Role-based access control sudah siap digunakan!** 🎉
