<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    use HasFactory;

    protected $fillable = ['album_id', 'title', 'file_name', 'duration'];
    protected $appends = ['kind'];
    protected $hidden = ['pivot'];


    //*** RELATIONS ***//
    /**
     * Album relation
     */
    public function album()
    {
        return $this->belongsTo(Album::class)->select('id', 'author_id', 'title', 'cover', 'release_date')->with('author');
    }


    /**
     * Playlist relation
     */
    public function playlists()
    {
        return $this->belongsToMany(Playlist::class);
    }


    //*** ACCESSORS ***//
    /**
     * Set Media type.
     */
    protected function kind(): Attribute
    {
        return new Attribute(
            get: fn () => 'track',
        );
    }
}
