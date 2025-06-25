<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JatahCuti extends Model
{

     use HasFactory;

    protected $table = 'jatah_cuti';

    protected $fillable = [
        'user_id',
        'total_cuti',
        'sisa_cuti',
    ];
    
        public function user() 
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
