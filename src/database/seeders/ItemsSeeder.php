<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $param = [
        'id' => '1',
        'user_id' => '1',
        'name' => 'ドラム式洗濯機',
        'path' => 'storage/sample/ドラム式洗濯機.jpg',
        'brand' => 'toshiba',
        'condition' => '良好',
        'explanation' => '購入後3か月です',
        'price' => '30000',
        'created_at' => now(),
    ];DB::table('items')->insert($param);
    $param = [
        'id' => '2',
        'user_id' => '1',
        'name' => 'ビール',
        'path' => 'storage/sample/ビール.jpg',
        'brand' => 'アサヒ',
        'condition' => '新品',
        'explanation' => '350ml×24',
        'price' => '3000',
        'created_at' => now(),
    ];DB::table('items')->insert($param);
    $param = [
        'id' => '3',
        'user_id' => '1',
        'name' => 'バック',
        'path' => 'storage/sample/ブランドバック.jpg',
        'brand' => 'coach',
        'condition' => '美品',
        'explanation' => '購入後1か月です',
        'price' => '100000',
        'created_at' => now(),
    ];DB::table('items')->insert($param);
    $param = [
        'id' => '4',
        'user_id' => '1',
        'name' => 'ダイア',
        'path' => 'storage/sample/ダイアモンド.jpg',
        'brand' => 'なし',
        'condition' => '超備品',
        'explanation' => '宝物です',
        'price' => '100000',
        'created_at' => now(),
    ];DB::table('items')->insert($param);
    $param = [
        'id' => '5',
        'user_id' => '1',
        'name' => 'ノートパソコン',
        'path' => 'storage/sample/ノートパソコン.jpg',
        'brand' => 'HP',
        'condition' => '可',
        'explanation' => '１年前購入です',
        'price' => '50000',
        'created_at' => now(),
    ];DB::table('items')->insert($param);
    }
}
