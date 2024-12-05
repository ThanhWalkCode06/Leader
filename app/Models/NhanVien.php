<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NhanVien extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ma_nhan_vien',
        'ten_nhan_vien',
        'hinh_anh
        ngay_vao_lam',
        'luong',
    ];
}