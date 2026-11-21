<?php

namespace App\Http\Requests\Penyewa;

use App\Models\Garasi;
use App\Models\Kendaraan;
use App\Models\SewaGarasi;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSewaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isListrikDiGarasiListrik = $this->tipe_kendaraan === Kendaraan::TIPE_MOBIL_LISTRIK
            && $this->tipe_garasi === Garasi::TIPE_MOBIL_LISTRIK;

        return [
            // Detail Kendaraan
            'tipe_kendaraan' => ['required', Rule::in([
                Kendaraan::TIPE_SEPEDA,
                Kendaraan::TIPE_SEPEDA_MOTOR,
                Kendaraan::TIPE_MOBIL,
                Kendaraan::TIPE_MOBIL_LISTRIK,
            ])],
            'plat_nomor' => [
                'nullable',
                Rule::requiredIf($this->tipe_kendaraan !== Kendaraan::TIPE_SEPEDA),
                'string',
                'max:15',
            ],
            'merek_kendaraan' => ['required', 'string', 'max:30'],
            'model_merek' => ['required', 'string', 'max:30'],
            'kapasitas_baterai' => [
                'nullable',
                Rule::requiredIf($this->tipe_kendaraan === Kendaraan::TIPE_MOBIL_LISTRIK),
                'numeric',
                'gt:0',
            ],

            // Detail Sewa & Garasi
            'tipe_sewa' => ['required', Rule::in([SewaGarasi::TIPE_HARIAN, SewaGarasi::TIPE_BULANAN])],
            'tanggal_mulai' => ['required', 'date', 'after_or_equal:today'],
            'jumlah_hari' => [
                'nullable',
                Rule::requiredIf($this->tipe_sewa === SewaGarasi::TIPE_HARIAN),
                'integer',
                'min:1',
            ],
            'tipe_garasi' => ['required', Rule::in(array_keys(Garasi::PREFIX_MAP))],
            'garasi_id' => ['required', 'exists:garasi,garasi_id'],
            'sisa_baterai_awal' => [
                'nullable',
                Rule::requiredIf($isListrikDiGarasiListrik),
                'numeric',
                'min:0',
                'max:100',
            ],

            // Bukti Bayar
            'bukti_bayar' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }
}
