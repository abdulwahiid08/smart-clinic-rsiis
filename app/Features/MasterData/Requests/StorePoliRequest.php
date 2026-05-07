<?php

namespace App\Features\MasterData\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePoliRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_poli' => ['required', 'string', 'max:255', 'unique:polis,nama_poli'],
            'deskripsi' => ['nullable', 'string'],
        ];
    }
}
