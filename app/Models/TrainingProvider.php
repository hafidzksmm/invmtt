<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class TrainingProvider extends Model
{
    use LogsActivity;

    protected $table = 'training_providers';

    protected $fillable = [
        'name',
        'logo_path',
        'position',
    ];

    public function certificates()
    {
        return $this->hasMany(TrainingCertificate::class, 'provider_id')
            ->orderByDesc('created_at');
    }
}
