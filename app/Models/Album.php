<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $fillable = ['author_id', 'title', 'cover', 'release_date'];


    //*** RELATIONS ***//
    /**
     * Author relation
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Tracks relation
     */
    public function tracks()
    {
        return $this->hasMany(Track::class);
    }
}
