<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    /**
     * 🔥 Pasang trait ini di model manapun (mis. Asetjual, DoModel, dll)
     * dan otomatis setiap create/update/delete akan tercatat di tabel activity_logs,
     * lengkap dengan siapa user yang melakukannya.
     *
     * Cara pakai di model:
     *
     *   use App\Traits\LogsActivity;
     *
     *   class Asetjual extends Model
     *   {
     *       use LogsActivity;
     *       ...
     *   }
     *
     * Opsional: definisikan method getActivityDescription() di model
     * untuk custom teks ringkasan, kalau tidak ada akan dibuat otomatis.
     */
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            $model->recordActivity('created', null, $model->getAttributes());
        });

        static::updated(function ($model) {
            // hanya field yang benar-benar berubah yang disimpan
            $changes = $model->getChanges();

            // abaikan kalau cuma updated_at yang berubah (tidak ada perubahan substantif)
            unset($changes['updated_at']);
            if (empty($changes)) {
                return;
            }

            $original = array_intersect_key($model->getOriginal(), $changes);

            $model->recordActivity('updated', $original, $changes);
        });

        static::deleted(function ($model) {
            $model->recordActivity('deleted', $model->getAttributes(), null);
        });
    }

    /**
     * Simpan satu baris log aktivitas.
     */
    public function recordActivity(string $action, ?array $oldValues, ?array $newValues)
    {
        $user = Auth::user();

        ActivityLog::create([
            'user_id'     => $user->id ?? null,
            'user_name'   => $user->name ?? 'System',
            'user_role'   => $user->role ?? null,
            'action'      => $action,
            'model_type'  => class_basename($this),
            'model_id'    => $this->getKey(),
            'description' => $this->getActivityDescription($action),
            'old_values'  => $oldValues,
            'new_values'  => $newValues,
            'ip_address'  => request()->ip(),
            'created_at'  => now(),
        ]);
    }

    /**
     * Teks ringkasan default. Override method ini di model
     * kalau mau teks yang lebih spesifik/manusiawi.
     */
    public function getActivityDescription(string $action): string
    {
        $label = match ($action) {
            'created' => 'Menambahkan',
            'updated' => 'Mengubah',
            'deleted' => 'Menghapus',
            default   => ucfirst($action),
        };

        $identifier = $this->nama_barang
            ?? $this->project
            ?? $this->name
            ?? ('#' . $this->getKey());

        return "{$label} data " . class_basename($this) . ": {$identifier}";
    }
}
