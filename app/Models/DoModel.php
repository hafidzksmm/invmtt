<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoModel extends Model
{
    protected $table = 'do';

    protected $fillable = [
        'project',
        'vendor',
        'year',
        'tanggal_do',
        'nomor_do',
        'tanggal_bast',
        'position'
    ];



    public function files()
    {
        return $this->hasMany(ProjectFile::class, 'do_id');
    }
}
