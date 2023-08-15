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
        'user_id' => '2',
        'name' => 'ノートパソコン',
        'path' => 'storage/sample/ノートパソコン.jpg',
        'brand' => 'HP',
        'condition' => '可',
        'explanation' => '１年前購入です',
        'price' => '50000',
        'created_at' => now(),
    ];DB::table('items')->insert($param);
    $param = [
        'id' => '6',
        'user_id' => '2',
        'name' => 'テレビ',
        'path' => 'storage/sample/液晶テレビ.jpg',
        'brand' => 'SONY',
        'condition' => '良',
        'explanation' => '2年前購入です',
        'price' => '60000',
        'created_at' => now(),
    ];DB::table('items')->insert($param);
    $param = [
        'id' => '7',
        'user_id' => '2',
        'name' => '電球',
        'path' => 'storage/sample/電球.jpg',
        'brand' => 'toshiba',
        'condition' => '新品',
        'explanation' => '新品です',
        'price' => '200',
        'created_at' => now(),
    ];DB::table('items')->insert($param);
    $param = [
        'id' => '8',
        'user_id' => '3',
        'name' => 'スマートフォン',
        'path' => 'storage/sample/スマートフォン.jpg',
        'brand' => 'toshiba',
        'condition' => 'とても良い',
        'explanation' => '１か月前購入',
        'price' => '50000',
        'created_at' => now(),
    ];DB::table('items')->insert($param);
    $param = [
        'id' => '9',
        'user_id' => '3',
        'name' => 'エアコン',
        'path' => 'storage/sample/エアコン.jpg',
        'brand' => 'toshiba',
        'condition' => '可',
        'explanation' => '３年前購入、取付は自力でお願いします。',
        'price' => '10000',
        'created_at' => now(),
    ];DB::table('items')->insert($param);
    $param = [
        'id' => '10',
        'user_id' => '4',
        'name' => '硬球',
        'path' => 'storage/sample/硬球.jpg',
        'brand' => 'mizuno',
        'condition' => '新品',
        'explanation' => '新品です',
        'price' => '300',
        'created_at' => now(),
    ];DB::table('items')->insert($param);

    }
}
