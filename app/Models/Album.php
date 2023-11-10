<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $fillable = ['author_id', 'title', 'cover', 'release_date'];
    protected $appends = ['kind'];


    //*** RELATIONS ***//
    /**
     * Author relation
     */
    public function author()
    {
        return $this->belongsTo(Author::class)->select('id', 'name');
    }

    /**
     * Tracks relation
     */
    public function tracks()
    {
        return $this->hasMany(Track::class)->select('id', 'album_id', 'title', 'duration')->orderBy('id')->with('album');
    }


    //*** ACCESSORS ***//
    /**
     * Set Media type.
     */
    protected function kind(): Attribute
    {
        return new Attribute(
            get: fn () => 'album',
        );
    }
}
