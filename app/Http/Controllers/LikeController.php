<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Item $item, Request $request) {
        $like = new Like();
        $like->item_id = $item->id;
        $like->user_id = Auth::user()->id;
        $like->save();
    
        return redirect()->back();
    }
    
    public function unlike(Item $item, Request $request) {
        $user = Auth::user()->id;
        $like = Like::where('item_id', $item->id)->where('user_id', $user)->first();
    
        if ($like) {
            $like->delete();
        }
    
        return redirect()->back();
    }
    
}
