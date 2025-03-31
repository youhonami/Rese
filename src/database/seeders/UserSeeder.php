<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 管理者アカウント
        User::create([
            'name' => '管理者',
            'email' => 'aaa@aaa.co.jp',
            'password' => Hash::make('aaaaaaaaaa'),
            'role' => 'admin',
        ]);

        // 一般ユーザー1：みたらしだんご
        User::create([
            'name' => 'みたらしだんご',
            'email' => 'qqq@qqq.co.jp',
            'password' => Hash::make('zzzzzzzzzz'),
            'role' => 'user',
        ]);

        // 一般ユーザー2：おはぎ
        User::create([
            'name' => 'おはぎ',
            'email' => 'www@www.co.jp',
            'password' => Hash::make('zzzzzzzzzz'),
            'role' => 'user',
        ]);

        // 一般ユーザー3：きなこもち
        User::create([
            'name' => 'きなこもち',
            'email' => 'eee@eee.co.jp',
            'password' => Hash::make('zzzzzzzzzz'),
            'role' => 'user',
        ]);

        User::create([
            'name' => '仙人',
            'email' => 'sennin@rese.jp',
            'password' => Hash::make('ssssssssss'),
            'role' => 'representative',
        ]);

        User::create([
            'name' => '牛助',
            'email' => 'ushisuke@rese.jp',
            'password' => Hash::make('ssssssssss'),
            'role' => 'representative',
        ]);

        User::create([
            'name' => '戦慄',
            'email' => 'senritsu@rese.jp',
            'password' => Hash::make('ssssssssss'),
            'role' => 'representative',
        ]);

        User::create([
            'name' => 'ルーク',
            'email' => 'luke@rese.jp',
            'password' => Hash::make('ssssssssss'),
            'role' => 'representative',
        ]);

        User::create([
            'name' => '志摩屋',
            'email' => 'shimaya@rese.jp',
            'password' => Hash::make('ssssssssss'),
            'role' => 'representative',
        ]);

        User::create([
            'name' => '香',
            'email' => 'kaori@rese.jp',
            'password' => Hash::make('ssssssssss'),
            'role' => 'representative',
        ]);

        User::create([
            'name' => 'JJ',
            'email' => 'jj@rese.jp',
            'password' => Hash::make('ssssssssss'),
            'role' => 'representative',
        ]);

        User::create([
            'name' => 'らーめん極み',
            'email' => 'kiwami@rese.jp',
            'password' => Hash::make('ssssssssss'),
            'role' => 'representative',
        ]);

        User::create([
            'name' => '鳥雨',
            'email' => 'toriame@rese.jp',
            'password' => Hash::make('ssssssssss'),
            'role' => 'representative',
        ]);

        User::create([
            'name' => '築地色合',
            'email' => 'iroai@rese.jp',
            'password' => Hash::make('ssssssssss'),
            'role' => 'representative',
        ]);

        User::create([
            'name' => '晴海',
            'email' => 'harumi@rese.jp',
            'password' => Hash::make('ssssssssss'),
            'role' => 'representative',
        ]);

        User::create([
            'name' => '三子',
            'email' => 'miko@rese.jp',
            'password' => Hash::make('ssssssssss'),
            'role' => 'representative',
        ]);

        User::create([
            'name' => '八戒',
            'email' => 'hakkai@rese.jp',
            'password' => Hash::make('ssssssssss'),
            'role' => 'representative',
        ]);

        User::create([
            'name' => '福助',
            'email' => 'fukusuke@rese.jp',
            'password' => Hash::make('ssssssssss'),
            'role' => 'representative',
        ]);

        User::create([
            'name' => 'ラー北',
            'email' => 'rakit@rese.jp',
            'password' => Hash::make('ssssssssss'),
            'role' => 'representative',
        ]);

        User::create([
            'name' => '翔',
            'email' => 'sho@rese.jp',
            'password' => Hash::make('ssssssssss'),
            'role' => 'representative',
        ]);

        User::create([
            'name' => '経緯',
            'email' => 'kei@rese.jp',
            'password' => Hash::make('ssssssssss'),
            'role' => 'representative',
        ]);

        User::create([
            'name' => '漆',
            'email' => 'urushi@rese.jp',
            'password' => Hash::make('ssssssssss'),
            'role' => 'representative',
        ]);

        User::create([
            'name' => 'THE TOOL',
            'email' => 'tool@rese.jp',
            'password' => Hash::make('ssssssssss'),
            'role' => 'representative',
        ]);

        User::create([
            'name' => '木船',
            'email' => 'kifune@rese.jp',
            'password' => Hash::make('ssssssssss'),
            'role' => 'representative',
        ]);
    }
}
