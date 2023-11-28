<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 商品一覧
     */
    public function index()
    {
        // 商品一覧取得
        $items = Item::all();

        return view('item.index', compact('items'));
    }

    /**
     * 商品登録
     */
    public function add(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            $validated = $request->validate(
                [
                    'title' => 'required|max:100',
                    'author' => 'required|max:100',
                    'category' => 'required|max:100',
                    'detail' => 'nullable',
                    'img_name' => 'nullable|file|mimes:jpeg,png,jpg,gif,bmp,svg|max:50'
                ],
                [
                    'title.required' => 'タイトルを入力してください。',
                    'title.max' => 'タイトルは100文字以内で入力してください。',
                    'author.required' => '作者名を入力してください。',
                    'author.max' => '作者名は100文字以内で入力してください。',
                    'category.required' => 'カテゴリーを入力してください。',
                    'category.max' => 'カテゴリーは100文字以内で入力してください。',
                    'img_name.mimes' => '画像形式ファイルをアップロードしてください.',
                    'img_name.max' => '画像ファイルは50キロバイト以下のファイルを選択してください。'
                ]);
        
                // 画像ファイルを処理する
                $imageData = null;
                if ($request->hasFile('img_name')) {
                    $image = $request->file('img_name');
                    $imageData ='data:image/png;base64,'.base64_encode(file_get_contents($image->path()));
                } 
                Item::create([
                    'title' => $validated['title'],
                    'author' => $validated['author'],
                    'category' => $validated['category'],
                    'detail' => $validated['detail'],
                    'img_name' => $imageData
                ]);

            return redirect('/items');
        }

        return view('item.add');
    }
}
