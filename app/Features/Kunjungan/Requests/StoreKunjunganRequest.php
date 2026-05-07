<?php

namespace App\Features\Kunjungan\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKunjunganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pasien_id' => ['nullable', 'exists:pasiens,id'],
            'nama_pasien' => ['required_without:pasien_id', 'nullable', 'string', 'max:255'],
            'tanggal_lahir' => ['nullable', 'date', 'before_or_equal:today'],
            'jenis_kelamin' => ['required_without:pasien_id', 'nullable', 'in:L,P'],
            'nomor_hp' => ['nullable', 'string', 'max:30'],
            'alamat' => ['nullable', 'string'],
            'tanggal_kunjungan' => ['required', 'date'],
            'poli_id' => ['required', 'exists:polis,id'],
            'dokter_id' => ['required', 'exists:dokters,id'],
            'jenis_pembayaran' => ['required', 'in:umum,bpjs,asuransi'],
        ];
    }

    public function attributes(): array
    {
        return [
            'poli_id' => 'poli tujuan',
            'dokter_id' => 'dokter',
            'pasien_id' => 'pasien terdaftar',
        ];
    }
}
