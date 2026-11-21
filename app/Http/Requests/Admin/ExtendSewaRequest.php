<?php

namespace App\Http\Requests\Admin;

use App\Models\SewaGarasi;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExtendSewaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tipe_perpanjangan' => ['required', Rule::in([SewaGarasi::TIPE_HARIAN, SewaGarasi::TIPE_BULANAN])],
            'durasi' => ['required', 'integer', 'min:1'], // Admin bebas tanpa batas maksimal
            'bukti_bayar' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }
}
