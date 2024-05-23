<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Release extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
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
        'pname',
        'original_release_date',
        'sales_date',
        'thumbnail_path',
        'note',
        'status'
    ];

     // Define the tracks relationship
     public function tracks()
     {
         return $this->hasMany(Track::class);
     }

}
