<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'cover'];

    //*** RELATIONS ***//
    /**
     * User relation
     */
    public function user()
    {
        return $this->belongsTo(User::class)->select('id', 'name');
    }


    /**
     * Track relation
     */
    public function tracks()
    {
        return $this->belongsToMany(Track::class)->select('id', 'album_id', 'title', 'duration')->with('album');
    }
}
