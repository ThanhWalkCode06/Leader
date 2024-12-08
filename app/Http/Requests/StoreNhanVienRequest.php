<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNhanVienRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ma_nhan_vien' => 'required|max:255',
            'ten_nhan_vien' => 'required',
            'hinh_anh' => 'required|image',
            'ngay_vao_lam' => 'required',
            'luong' => 'required|numeric|min:1',
            'phong_ban_id' => 'required',

        ];
    }
}
