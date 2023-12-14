<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Like;

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

    /**
     * お気に入り一覧
     */
    public function like(Request $request)
    {
        // クエリビルダ
        $query = Item::query()->latest();
    
        // ログインしているユーザーのIDを取得
        $userId = Auth::id();
    
        // キーワード検索処理
        $keyword = $request->input('keyword');
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('author', 'LIKE', "%{$keyword}%")
                    ->orWhere('category', 'LIKE', "%{$keyword}%");
            });
        }
    
        // 商品検索処理
        $items = $query->whereHas('likes', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->paginate(14);
    
        return view('item.like', compact('keyword', 'items'));
    }


    
    // 管理者用ページ

    /**
     * 商品一覧（管理）
     */
    public function list(Request $request)
    {
        // セレクトボックスで選択した値
        $select = $request->sort_by;
    
        // セレクトボックスの値に応じてソート
        switch ($select) {
            case '1':
                //「指定なし」はID順
                $items = Item::withCount('likes')->latest()->paginate(7);
                break;
            case '2':
                // 「登録順」でソート
                $items = Item::withCount('likes')->oldest()->paginate(7);
                break;
            case '3':
                // 「お気に入り数が多い順」でソート
                $items = Item::withCount('likes')->orderBy('likes_count', 'desc')->paginate(7);
                break;
            case '4':
                // 「お気に入り数が少ない順」でソート
                $items = Item::withCount('likes')->orderBy('likes_count', 'asc')->paginate(7);
                break;
            default :
                // デフォルトはID順
                $items = Item::withCount('likes')->latest()->paginate(7);
                break;
        }
    
        $items->appends(['sort_by' => $select]); // 並べ替えの情報を追加する

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
        $items = $query->paginate(7);
    
        return view('item.list', compact('items', 'select', 'keyword'));
    }
    

    /**
     * 商品登録
     */
    public function add(Request $request)
    {
        $categories = [
            "文芸書",
            "人文書",
            "専門書",
            "実用書",
            "ビジネス・経済・経営",
            "児童書・絵本",
            "学習参考書",
            "マンガ・コミックス"
        ];
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            $validated = $request->validate(
                [
                    'title' => 'required|max:100',
                    'author' => 'required|max:100',
                    'category' => 'required|max:100',
                    'detail' => 'nullable|max:900',
                    'img_name' => 'nullable|file|mimes:jpeg,png,jpg,gif,bmp,svg|max:50'
                ],
                [
                    'title.required' => 'タイトルを入力してください。',
                    'title.max' => 'タイトルは100文字以内で入力してください。',
                    'author.required' => '作者名を入力してください。',
                    'author.max' => '作者名は100文字以内で入力してください。',
                    'category.required' => 'カテゴリーを入力してください。',
                    'category.max' => 'カテゴリーは100文字以内で入力してください。',
                    'detail.max' => '詳細は900文字以内で入力してください。',
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
                return redirect()->route('item/list')->with('message','商品情報が登録されました。');
            }
        
            return view('item.add' ,compact('categories'));
    }

    /**
     * 商品編集
     */
    public function edit(Request $request, $id)
    {
        $item = Item::find($id);
        $categories = [
            "文芸書",
            "人文書",
            "専門書",
            "実用書",
            "ビジネス・経済・経営",
            "児童書・絵本",
            "学習参考書",
            "マンガ・コミックス"
        ];
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            $validated = $request->validate(
                [
                    'title' => 'required|max:100',
                    'author' => 'required|max:100',
                    'category' => 'required|max:100',
                    'detail' => 'nullable|max:900',
                    'img_name' => 'nullable|file|mimes:jpeg,png,jpg,gif,bmp,svg|max:50'
                ],
                [
                    'title.required' => 'タイトルを入力してください。',
                    'title.max' => 'タイトルは100文字以内で入力してください。',
                    'author.required' => '作者名を入力してください。',
                    'author.max' => '作者名は100文字以内で入力してください。',
                    'category.required' => 'カテゴリーを入力してください。',
                    'category.max' => 'カテゴリーは100文字以内で入力してください。',
                    'detail.max' => '詳細は900文字以内で入力してください。',
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
            return redirect()->route('item/list')->with('message','商品情報が更新されました。');
        }
        return view('item.edit', compact('item', 'categories'));
    }

    /**
     * 商品削除処理
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        $item->delete();
        return redirect()->back()->with('message','商品情報が削除されました。');;
    }

    /**
     * 商品詳細画面
     */
    public function itemsinfo($id){
        $info = Item::find($id);

    // ユーザーがいいねしているか確認
    $like = Like::where('item_id', $info->id)->where('user_id', auth()->id())->first();

    // 前の商品のIDを取得
    $previousItemId = Item::where('id', '<', $info->id)->max('id');

    // 次の商品のIDを取得
    $nextItemId = Item::where('id', '>', $info->id)->min('id');

    // 前の商品のURL
    $previousItemUrl = ($previousItemId) ? route('itemsinfo', ['id' => $previousItemId]) : '';

    // 次の商品のURL
    $nextItemUrl = ($nextItemId) ? route('itemsinfo', ['id' => $nextItemId]) : '';

    return view('item.itemsinfo', compact('info', 'like', 'previousItemUrl', 'nextItemUrl'));
    }

    /**
     * カテゴリー毎の商品一覧ページ
     */
    public function showByCategory($category, Request $request)
    {
        $keyword = $request->input('keyword'); // リクエストからキーワードを取得
    
        // カテゴリーに基づいて商品を取得する処理を書く
        $query = Item::where('category', $category);
    
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%$keyword%")
                    ->orWhere('author', 'like', "%$keyword%");
            });
        }
    
        $items = $query->latest('created_at')->paginate(14);
    
        // 取得した商品をビューに渡して表示する
        return view('item.index', compact('keyword', 'items', 'category'));
    }
    
    

    public function showByCategoryList($category, Request $request)
    {
        $select = $request->sort_by;
        $keyword = $request->keyword;
    
        $query = Item::where('category', $category)->withCount('likes');
    
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%$keyword%")
                    ->orWhere('author', 'like', "%$keyword%");
            });
        }
    
        switch ($select) {
            case '1':
                //「指定なし」はID順
                $items = $query->latest()->paginate(7);
                break;
            case '2':
                // 「登録順」でソート
                $items = $query->oldest()->paginate(7);
                break;
            case '3':
                // 「お気に入り数が多い順」でソート
                $items = $query->orderBy('likes_count', 'desc')->paginate(7);
                break;
            case '4':
                // 「お気に入り数が少ない順」でソート
                $items = $query->orderBy('likes_count', 'asc')->paginate(7);
                break;
            default:
                // デフォルトはID順
                $items = $query->latest()->paginate(7);
                break;
        }
    
        $items->appends(['sort_by' => $select, 'keyword' => $keyword]);
    
        return view('item.list', compact('items', 'category', 'select', 'keyword'));
    }
    
    public function itemsinfoByCategory($category, $id){
        $info = Item::where('id', $id)
            ->where('category', $category)
            ->firstOrFail();
    
        // ユーザーがいいねしているか確認
        $like = Like::where('item_id', $info->id)
            ->where('user_id', auth()->id())
            ->first();
    
        // 前の商品のIDを取得
        $previousItemId = Item::where('id', '<', $info->id)
            ->where('category', $category)
            ->max('id');
    
        // 次の商品のIDを取得
        $nextItemId = Item::where('id', '>', $info->id)
            ->where('category', $category)
            ->min('id');
    
        // 前の商品のURL
        $previousItemUrl = ($previousItemId) ? route('itemsinfo.by.category', ['category' => $category, 'id' => $previousItemId]) : '';
    
        // 次の商品のURL
        $nextItemUrl = ($nextItemId) ? route('itemsinfo.by.category', ['category' => $category, 'id' => $nextItemId]) : '';
    
        return view('item.itemsinfo', compact('info', 'like', 'previousItemUrl', 'nextItemUrl', 'category'));
    }
    
    public function itemsinfoByLike($id){
        // 指定された商品IDに紐づくお気に入り情報を取得
        $like = Like::where('item_id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        
        // 商品情報を取得
        $info = Item::findOrFail($like->item_id);
        
        // ユーザーのお気に入りリストから商品IDのリストを取得
        $userLikes = Like::where('user_id', auth()->id())
            ->pluck('item_id')
            ->toArray();
        
        // ユーザーのお気に入りリストから現在の商品のインデックスを取得
        $currentIndex = array_search($info->id, $userLikes);
        
        // 前の商品のIDを取得
        $previousItemId = null;
        if ($currentIndex !== false && $currentIndex > 0) {
            $previousItemId = $userLikes[$currentIndex - 1];
        }
    
        // 次の商品のIDを取得
        $nextItemId = null;
        if ($currentIndex !== false && $currentIndex < count($userLikes) - 1) {
            $nextItemId = $userLikes[$currentIndex + 1];
        }
    
        // 前の商品のURL
        $previousItemUrl = ($previousItemId) ? route('itemsinfo.by.like', ['id' => $previousItemId]) : '';
        
        // 次の商品のURL
        $nextItemUrl = ($nextItemId) ? route('itemsinfo.by.like', ['id' => $nextItemId]) : '';

        $category = 'お気に入り';
    
        return view('item.itemsinfo', compact('info', 'like', 'previousItemUrl', 'nextItemUrl', 'category'));
    }
    
    
    
}
