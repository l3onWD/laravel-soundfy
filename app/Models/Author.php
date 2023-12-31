<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = ['name'];


    //*** RELATIONS ***//
    /**
     * Album relation
     */
    public function albums()
    {
        return $this->hasMany(Album::class);
    }
}
