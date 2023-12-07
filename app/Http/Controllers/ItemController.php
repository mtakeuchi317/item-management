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

    //ユーザー用ページ
    /**
     * 商品一覧
     */
    public function index(Request $request)
    {
        // 検索フォームで入力された値を取得する
        $keyword = $request->input('keyword');

        // クエリビルダ
        $query = Item::query()->latest();

        if(!empty($keyword)){
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                ->orWhere('author', 'LIKE', "%{$keyword}%")
                ->orWhere('category', 'LIKE', "%{$keyword}%");
            });
        }
        $items = $query->paginate(14);
        return view('item.index', compact('keyword', 'items'));
        
    }

    
    // 管理者用ページ

    /**
     * 商品一覧（管理）
     */
    public function list()
    {
        // 商品一覧取得
        $items = Item::all();

        return view('item.list', compact('items'));
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
        
                if ($request->hasFile('img_name')) {
                    $image = $request->file('img_name');
                    $imageData = 'data:image/png;base64,' . base64_encode(file_get_contents($image->path()));
                } else {
                    $imageData = null;
                }
        
                // データの再確認
                $data = [
                    'title' => $validated['title'],
                    'author' => $validated['author'],
                    'category' => $validated['category'],
                    'detail' => $validated['detail'],
                    'img_name' => $imageData
                ];
        
                // データを作成してリダイレクト
                Item::create($data);
                return redirect()->route('item/list');
            }
        
            return view('item.add');
    }

    /**
     * 商品編集
     */
    public function edit(Request $request, $id)
    {
        $item = Item::find($id);
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
        
                $item = Item::find($id);

                // 画像ファイルを処理する
                $deleteImage = $request->has('delete_image'); // チェックボックスの状態を取得

                if ($deleteImage) {
                    // 画像を削除する場合
                    $item->update([
                        'title' => $validated['title'],
                        'author' => $validated['author'],
                        'category' => $validated['category'],
                        'detail' => $validated['detail'],
                        'img_name' => null // 画像を削除するために null で更新
                    ]);
                } elseif ($request->hasFile('img_name')) {
                    // 新しい画像がアップロードされた場合
                    $image = $request->file('img_name');
                    $imageData = 'data:image/png;base64,'.base64_encode(file_get_contents($image->path()));

                    $item->update([
                        'title' => $validated['title'],
                        'author' => $validated['author'],
                        'category' => $validated['category'],
                        'detail' => $validated['detail'],
                        'img_name' => $imageData
                    ]);
                } else {
                    // 画像の変更がない場合は通常の情報更新を行う
                    $item->update([
                        'title' => $validated['title'],
                        'author' => $validated['author'],
                        'category' => $validated['category'],
                        'detail' => $validated['detail'],
                    ]);
                }
            return redirect()->route('item/list');
        }
        return view('item.edit', compact('item'));
    }

    /**
     * 商品削除処理
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        $item->delete();
        return redirect()->back();
    }

    /**
     * 商品詳細画面
     */
    public function itemsinfo($id){
        $info = Item::find($id);

        // 前の商品のIDを取得
        $previousItemId = Item::where('id', '<', $info->id)->max('id');

        // 次の商品のIDを取得
        $nextItemId = Item::where('id', '>', $info->id)->min('id');

        // 前の商品のURL
        $previousItemUrl = ($previousItemId) ? route('itemsinfo', ['id' => $previousItemId]) : '';

        // 次の商品のURL
        $nextItemUrl = ($nextItemId) ? route('itemsinfo', ['id' => $nextItemId]) : '';

        return view('item.itemsinfo',  compact('info', 'previousItemUrl', 'nextItemUrl'));
    }

    /**
     * カテゴリー毎の商品一覧ページ
     */
    public function showByCategory($category)
    {
        $keyword = null; // $keyword を定義する

        // カテゴリーに基づいて商品を取得する処理を書く
        $items = Item::where('category', $category)->paginate(14);
    
        // 取得した商品をビューに渡して表示する
        return view('item.index', compact('keyword', 'items'));
    }

    public function showByCategoryList($category)
    {
        // カテゴリーに基づいて商品を取得する処理を書く
        $items = Item::where('category', $category)->get();

        // 取得した商品を別のビューに渡して表示する（例：item.list.list）
        return view('item.list', compact('items'));
    }

}
