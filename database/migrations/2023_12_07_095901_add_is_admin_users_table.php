<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 整数型のカラムを追加し、デフォルト値を設定する例
            $table->integer('isAdmin')->default(2); // 2はユーザーを表すデフォルト値です
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // カラムを削除する場合のロールバック処理を定義する例
            $table->dropColumn('isAdmin');
        });
    }
};
