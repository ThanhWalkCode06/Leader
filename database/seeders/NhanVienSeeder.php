<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NhanVienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=0; $i<5; $i++){
            DB::table('nhan_viens')->insert([
                'ma_nhan_vien'=>"Ma_nhan_vien $i",
                'ten_nhan_vien'=>"nhan_vien $i",
                'hinh_anh'=>"upload/img/$i",
                'ngay_vao_lam'=>now(),
                'luong'=>"$i"

            ]);
            }
    }
}
