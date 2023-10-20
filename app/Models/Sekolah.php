<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    protected $table ='sekolah';
    use HasFactory;

    protected $fillable = [
        'namasekolah',
        'alamat',
        'latitude',
        'longitude',
    ];

}