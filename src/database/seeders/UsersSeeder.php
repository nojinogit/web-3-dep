<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $param = [
        'id' => '1',
        'name' => 'admin',
        'email' => 'admin@aol.com',
        'email_verified_at' => now(),
        'password' => bcrypt('123456789'),
        'role' => '100',
        'point' => '100',
        'postcode' => '111-1111',
        'address' => 'アメリカ',
        'bank' => 'みずほ銀行',
        'bank_branch' => 'いろは支店',
        'bank_type' => '普通',
        'bank_number' => '1234567',
        'created_at' => now(),
        ];DB::table('users')->insert($param);

        $param = [
        'id' => '2',
        'name' => 'guest1',
        'email' => 'guest1@aol.com',
        'email_verified_at' => now(),
        'password' => bcrypt('123456789'),
        'created_at' => now(),
        ];DB::table('users')->insert($param);

        $param = [
        'id' => '3',
        'name' => 'guest2',
        'email' => 'guest2@aol.com',
        'email_verified_at' => now(),
        'password' => bcrypt('123456789'),
        'created_at' => now(),
        ];DB::table('users')->insert($param);

        $param = [
        'id' => '4',
        'name' => 'guest3',
        'email' => 'guest3@aol.com',
        'email_verified_at' => now(),
        'password' => bcrypt('123456789'),
        'created_at' => now(),
        ];DB::table('users')->insert($param);

        $param = [
        'id' => '5',
        'name' => 'guest4',
        'email' => 'guest4@aol.com',
        'email_verified_at' => now(),
        'password' => bcrypt('123456789'),
        'created_at' => now(),
        ];DB::table('users')->insert($param);

        $param = [
        'id' => '6',
        'name' => 'guest5',
        'email' => 'guest5@aol.com',
        'email_verified_at' => now(),
        'password' => bcrypt('123456789'),
        'created_at' => now(),
        ];DB::table('users')->insert($param);
    }
}
