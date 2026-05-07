<?php

namespace App\Features\MasterData\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDokterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'poli_id' => ['required', 'exists:polis,id'],
            'nama_dokter' => ['required', 'string', 'max:255'],
            'spesialis' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'poli_id' => 'poli',
        ];
    }
}
