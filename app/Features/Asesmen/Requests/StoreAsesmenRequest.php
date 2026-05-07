<?php

namespace App\Features\Asesmen\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAsesmenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'keluhan_utama' => ['required', 'string'],
            'tekanan_darah' => ['nullable', 'string', 'max:30'],
            'suhu_tubuh' => ['nullable', 'numeric', 'between:30,45'],
            'berat_badan' => ['nullable', 'numeric', 'between:1,300'],
            'diagnosis_awal' => ['required', 'string'],
            'tindakan_terapi' => ['nullable', 'string'],
            'catatan_dokter' => ['nullable', 'string'],
        ];
    }
}
