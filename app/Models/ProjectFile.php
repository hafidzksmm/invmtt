<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectFile extends Model
{
    protected $table = 'project_files';

    public $timestamps = false; // karena cuma pakai created_at

    protected $fillable = [
        'do_id',
        'type',
        'file_path',
        'note'
    ];

    public function do()
    {
        return $this->belongsTo(DoModel::class, 'do_id');
    }
}
