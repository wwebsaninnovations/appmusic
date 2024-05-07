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
        'track_version',
        'lyrics_language',
        'explicit_content',
        'track_primary_artist',
        'track_featuring_artist',
        'track_remixer',
        'track_writer',
        'track_producer',
        'composer',
        'track_lyrics_name',
        'track_label_name',
        'isrc',
        'track_performers',
        'publisher_rights',
        'ownership_for_soound_rec',
    ];
}
