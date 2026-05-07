<?php

namespace App\Features\Kunjungan\Requests;

class UpdateKunjunganRequest extends StoreKunjunganRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        unset($rules['pasien_id']);

        $rules['nama_pasien'] = ['required', 'string', 'max:255'];
        $rules['jenis_kelamin'] = ['required', 'in:L,P'];

        return $rules;
    }
}
