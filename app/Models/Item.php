<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'items_table';

    protected $fillable = [
        'user_id',
        'title',
        'author',
        'category',
        'detail',
        'img_name',
    ];
    
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function likes() {
        return $this->hasMany(Like::class, 'item_id');
    }

    // Itemモデルにお気に入り数をカウントするリレーションを追加
    public function likesCount()
    {
        return $this->likes()->count();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];
}
