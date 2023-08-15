<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $param = [
        'id' => '1',
        'item_id' => '1',
        'category' => '洗濯機',
        'created_at' => now(),
    ];DB::table('categories')->insert($param);
    $param = [
        'id' => '2',
        'item_id' => '1',
        'category' => '家電',
        'created_at' => now(),
    ];DB::table('categories')->insert($param);
    $param = [
        'id' => '3',
        'item_id' => '2',
        'category' => 'ビール',
        'created_at' => now(),
    ];DB::table('categories')->insert($param);
    $param = [
        'id' => '4',
        'item_id' => '2',
        'category' => 'お酒',
        'created_at' => now(),
    ];DB::table('categories')->insert($param);
    $param = [
        'id' => '5',
        'item_id' => '3',
        'category' => 'coach',
        'created_at' => now(),
    ];DB::table('categories')->insert($param);
    $param = [
        'id' => '6',
        'item_id' => '3',
        'category' => 'バック',
        'created_at' => now(),
    ];DB::table('categories')->insert($param);
    $param = [
        'id' => '7',
        'item_id' => '4',
        'category' => '宝石',
        'created_at' => now(),
    ];DB::table('categories')->insert($param);
    $param = [
        'id' => '8',
        'item_id' => '4',
        'category' => '高額商品',
        'created_at' => now(),
    ];DB::table('categories')->insert($param);
    $param = [
        'id' => '9',
        'item_id' => '5',
        'category' => 'windows11',
        'created_at' => now(),
    ];DB::table('categories')->insert($param);
    $param = [
        'id' => '10',
        'item_id' => '5',
        'category' => 'HP',
        'created_at' => now(),
    ];DB::table('categories')->insert($param);
    $param = [
        'id' => '11',
        'item_id' => '5',
        'category' => 'パソコン',
        'created_at' => now(),
    ];DB::table('categories')->insert($param);
    $param = [
        'id' => '12',
        'item_id' => '5',
        'category' => '安い',
        'created_at' => now(),
    ];DB::table('categories')->insert($param);
    $param = [
        'id' => '13',
        'item_id' => '6',
        'category' => '安い',
        'created_at' => now(),
    ];DB::table('categories')->insert($param);
    $param = [
        'id' => '14',
        'item_id' => '6',
        'category' => '家電',
        'created_at' => now(),
    ];DB::table('categories')->insert($param);
    $param = [
        'id' => '15',
        'item_id' => '6',
        'category' => 'テレビ',
        'created_at' => now(),
    ];DB::table('categories')->insert($param);
    $param = [
        'id' => '16',
        'item_id' => '7',
        'category' => '安い',
        'created_at' => now(),
    ];DB::table('categories')->insert($param);
    $param = [
        'id' => '17',
        'item_id' => '7',
        'category' => '家電',
        'created_at' => now(),
    ];DB::table('categories')->insert($param);
    $param = [
        'id' => '18',
        'item_id' => '8',
        'category' => '安い',
        'created_at' => now(),
    ];DB::table('categories')->insert($param);
    $param = [
        'id' => '19',
        'item_id' => '8',
        'category' => '家電',
        'created_at' => now(),
    ];DB::table('categories')->insert($param);
    $param = [
        'id' => '20',
        'item_id' => '8',
        'category' => 'スマートフォン',
        'created_at' => now(),
    ];DB::table('categories')->insert($param);
    $param = [
        'id' => '21',
        'item_id' => '9',
        'category' => '安い',
        'created_at' => now(),
    ];DB::table('categories')->insert($param);
    $param = [
        'id' => '22',
        'item_id' => '9',
        'category' => '家電',
        'created_at' => now(),
    ];DB::table('categories')->insert($param);
    $param = [
        'id' => '23',
        'item_id' => '9',
        'category' => 'エアコン',
        'created_at' => now(),
    ];DB::table('categories')->insert($param);
    $param = [
        'id' => '24',
        'item_id' => '10',
        'category' => '安い',
        'created_at' => now(),
    ];DB::table('categories')->insert($param);
    $param = [
        'id' => '25',
        'item_id' => '10',
        'category' => '新品',
        'created_at' => now(),
    ];DB::table('categories')->insert($param);

    }
}
