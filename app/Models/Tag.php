<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tag';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'status'];

    public function scopeActive($query)
    {

        return $query->whereStatus('1');
    }

    public function posts()
    {

        return $this->belongsToMany(Post::class);
    }

    
}
