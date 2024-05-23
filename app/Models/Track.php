<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory;

    protected $fillable = [
        'release_id',
        'user_id',
        'track_path',
        'track_name',
        'track_duration',
        'track_version',
        'lyrics_language',
        'explicit_content',
        'track_primary_artist',
        'track_featuring_artist',
        'track_remixer',
        'song_writer',
        'track_producer',
        'composer_name',
        'track_lyrics_name',
        'track_label_name',
        'isrc',
        'track_performers',
        'pname',
        'cname',
        'ownership_for_soound_rec',
        'original_release_date',
        'sales_date',
        'country_of_rec',
        'nationality'
    ];
    
  
    // Define the release relationship
    public function release()
    {
        return $this->belongsTo(Release::class);
    }
}
