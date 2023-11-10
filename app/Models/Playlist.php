<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Playlist extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'cover'];
    protected $appends = ['kind'];

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
        // $uid = Str::orderedUuid();
        return $this->belongsToMany(Track::class)
            ->select('id', 'album_id', 'title', 'duration')
            ->orderBy('id')
            ->with('album');
    }


    //*** ACCESSORS ***//
    /**
     * Set Media type.
     */
    protected function kind(): Attribute
    {
        return new Attribute(
            get: fn () => 'playlist',
        );
    }
}
