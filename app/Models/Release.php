<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    use HasFactory;
    protected $fillable = [
        'format',
        'release_name',
        'release_version',
        'release_code',
        'upc',
        'meta_language',
        'primary_artist',
        'featuring_artist',
        'remixer',
        'producer',
        'genre',
        'sub_genre',
        'cname',
        'thumbnail_path',
        'user_id',
        'note',
        'status'
    ];
}
