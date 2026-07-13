<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class TrainingCertificate extends Model
{
    use LogsActivity;

    protected $table = 'training_certificates';

    protected $fillable = [
        'provider_id',
        'title',
        'holder_name',
        'issued_date',
        'expired_date',
        'file_path',
        'note',
    ];

    public function provider()
    {
        return $this->belongsTo(TrainingProvider::class, 'provider_id');
    }
}
