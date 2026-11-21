<?php

namespace App\Http\Requests\Admin;

use App\Models\Garasi;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGarasiBatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tipe_garasi' => ['required', Rule::in(array_keys(Garasi::PREFIX_MAP))],
            'jumlah' => ['required', 'integer', 'min:1', 'max:' . Garasi::MAX_UNIT_PER_TIPE],
            'harga_sewa' => ['required', 'numeric', 'min:0'],
            'harga_per_kwh' => [
                'nullable',
                'required_if:tipe_garasi,' . Garasi::TIPE_MOBIL_LISTRIK,
                'numeric',
                'min:0',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'harga_per_kwh.required_if' => 'Harga isi listrik per kWh wajib diisi untuk garasi mobil listrik.',
        ];
    }
}
