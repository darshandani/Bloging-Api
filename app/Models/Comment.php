<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['user_id','post_id', 'comment', 'slug', 'status', 'commented_by', 'commented_at'];

    public function scopeActive($query)
    {

        return $query->whereStatus('1');
    }

    public function post()
    {

        return $this->hasMany(Post::class);
    }
}
