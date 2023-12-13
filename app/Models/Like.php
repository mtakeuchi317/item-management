<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $table = 'likes_table';

    protected $fillable = ['user_id', 'item_id'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function like() {
        return $this->belongsTo('App\Models\Like');
    }
}
