<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','slug','status'];

    public function scopeActive($query){

        return $query->whereStatus('1');
    }

    public function post(){

        return $this->hasMany(Post::class);
    }

}
