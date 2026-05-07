<?php

namespace App\Features\MasterData\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePoliRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_poli' => [
                'required',
                'string',
                'max:255',
                Rule::unique('polis', 'nama_poli')->ignore($this->route('poli')?->id),
            ],
            'deskripsi' => ['nullable', 'string'],
        ];
    }
}
