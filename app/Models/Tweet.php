<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;

    // アプリケーション側でcreateなどできない値を記述する
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    // 降順で全情報を取得する
    public static function getAllOrderByUpdated_at()
    {
        return self::orderBy('updated_at', 'desc')->get();
    }

    // ユーザーテーブルと連携させる関数
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
