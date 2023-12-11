<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    /**
     * 会員一覧
     */
    public function list()
    {
        // 会員一覧取得
        $users = User::all();

        return view('user.list', compact('users'));
    }

    /**
     * 会員一覧から会員情報編集
     */
    public function edit(Request $request, $id)
    {
        $user= User::find($id);
        // POSTリクエストのとき
        if ($request->isMethod('put')) {
            $validated = $request->validate(
                [
                    'name'=>'required|max:100',
                    'name_kana'=>'required|max:100|katakana',
                    'gender' => 'required|in:未回答,男,女',
                    'birthday' => 'required',
                    'phone'=>'required|digits:11',
                    'email'=>'required|email:filter,dns|unique:users,email,'. $id . '',
                    'isAdmin'=>'required|numeric'
                ],
                [
                    'name.required' => '名前を入力してください。',
                    'name.max' => '名前は100文字以内で入力してください。',
                    'name_kana.required' => 'フリガナを入力してください。',
                    'name_kana.max' => 'フリガナは100文字以内で入力してください。',
                    'name_kana.katakana' => 'フリガナを全角カタカナで入力してください。',
                    'birthday.required' => '誕生日を入力してください。',
                    'phone.required' => '電話番号を入力してください。',
                    'phone.digits' => '電話番号は11桁の整数のみで入力してください。',
                    'email.required' => 'メールアドレスを入力してください。',
                    'email.email' => '有効なメールアドレスを入力してください。',
                    'email.unique' => '入力されたメールアドレスは既に使用されています。',
                    'isAdmin.required' => '権限を選択してください。'
                ]);

                $user= User::find($id);

                $user->update([
                    'name' => $validated['name'],
                    'name_kana' => $validated['name_kana'],
                    'gender' => $validated['gender'],
                    'birthday' => $validated['birthday'],
                    'phone' => $validated['phone'],
                    'email' => $validated['email'],
                    'isAdmin' => $request->input('isAdmin'), // ドロップダウンリストからの値を取得
                ]);

                return redirect('users');
            }

            return view('user.edit', compact('user'));
    }

    /**
     * 会員削除処理
     */
    public function destroy($id)
    {
        $item = User::find($id);
        $item->delete();
        return redirect()->back();
    }

    public function profile()
    {
        // ログインユーザーの情報を取得
        $user = Auth::user();

        // ビューにログインユーザーの情報を渡す
        return view('user.profile', compact('user'));

    }

    /**
     * プロフィールから会員情報編集
     */
    public function profile_edit(Request $request, $id)
    {
        $user= User::find($id);
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            $validated = $request->validate(
                [
                    'name'=>'required|max:100',
                    'name_kana'=>'required|max:100|katakana',
                    'gender' => 'required|in:未回答,男,女',
                    'birthday' => 'required',
                    'phone'=>'required|digits:11',
                    'email'=>'required|email:filter,dns|unique:users,email,'. $id . '',
                ],
                [
                    'name.required' => '名前を入力してください。',
                    'name.max' => '名前は100文字以内で入力してください。',
                    'name_kana.required' => 'フリガナを入力してください。',
                    'name_kana.max' => 'フリガナは100文字以内で入力してください。',
                    'name_kana.katakana' => 'フリガナを全角カタカナで入力してください。',
                    'birthday.required' => '誕生日を入力してください。',
                    'phone.required' => '電話番号を入力してください。',
                    'phone.digits' => '電話番号は11桁の整数のみで入力してください。',
                    'email.required' => 'メールアドレスを入力してください。',
                    'email.email' => '有効なメールアドレスを入力してください。',
                    'email.unique' => '入力されたメールアドレスは既に使用されています。',
                ]);

                $user= User::find($id);

                $user->update([
                    'name' => $validated['name'],
                    'name_kana' => $validated['name_kana'],
                    'gender' => $validated['gender'],
                    'birthday' => $validated['birthday'],
                    'phone' => $validated['phone'],
                    'email' => $validated['email'],
                ]);

                return redirect()->route('user/profile');
            }

            return view('user.profile_edit', compact('user'));
    }

}
