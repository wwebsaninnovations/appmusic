<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;
    protected $guarded =[];


    public function release()
    {
        return $this->belongsToMany(Release::class, 'platform_release');
    }

}


