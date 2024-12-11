<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
{
    return [
        'name' => 'required|string',
        'jenis' => 'required|string',
        'merk' => 'required|string',
        'deskripsi' => 'required|string',
        'nominal' => 'required',
        'stok' => 'required',
        'gambar' => 'required|image|mimes:jpg,jpeg,png,svg,webp',
    ];
}
}
