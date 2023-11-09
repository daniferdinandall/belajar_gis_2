<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Polyline extends Model
{
    protected $table ='table_polyline';
    use HasFactory;

    protected $fillable = [
        'sekolah_id',
        'latitude',
        'longitude',
    ];
}
