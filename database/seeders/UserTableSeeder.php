<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'gender' => '未回答', // ジェンダーに応じて適切な値を設定
            'name_kana' => 'アドミン', // 仮の値
            'birthday' => '2023-01-01', // 仮の値
            'phone' => '01234567890', // 仮の値
            'email' => 'admin@example.com',
            'password' => Hash::make('12345678'), // パスワードをハッシュ化
            'isAdmin' => 1,
        ]);
    }
}
