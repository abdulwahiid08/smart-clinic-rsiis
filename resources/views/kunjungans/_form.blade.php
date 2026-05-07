@php
    $pasien = $kunjungan->pasien ?? null;
@endphp

<div class="form-grid">
    <section class="panel form-section">
        <h2>Data Pasien</h2>
        @if (($pasiens ?? collect())->isNotEmpty() && ! $kunjungan->exists)
            <label>Gunakan Pasien Terdaftar
                <select name="pasien_id">
                    <option value="">Input pasien baru</option>
                    @foreach ($pasiens as $registeredPatient)
                        <option value="{{ $registeredPatient->id }}" @selected(old('pasien_id') === $registeredPatient->id)>
                            {{ $registeredPatient->kode_pasien }} - {{ $registeredPatient->nama_pasien }}
                        </option>
                    @endforeach
                </select>
            </label>
            <p class="field-note">Pilih pasien lama untuk membuat kunjungan baru tanpa menduplikasi data pasien.</p>
        @endif
        <label>Nama Pasien
            <input name="nama_pasien" value="{{ old('nama_pasien', $pasien->nama_pasien ?? '') }}">
        </label>
        <div class="two-col">
            <label>Tanggal Lahir
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', optional($pasien?->tanggal_lahir)->format('Y-m-d')) }}">
            </label>
            <label>Jenis Kelamin
                <select name="jenis_kelamin">
                    <option value="">Pilih</option>
                    <option value="L" @selected(old('jenis_kelamin', $pasien->jenis_kelamin ?? '') === 'L')>Laki-laki</option>
                    <option value="P" @selected(old('jenis_kelamin', $pasien->jenis_kelamin ?? '') === 'P')>Perempuan</option>
                </select>
            </label>
        </div>
        <label>No HP
            <input name="nomor_hp" value="{{ old('nomor_hp', $pasien->nomor_hp ?? '') }}">
        </label>
        <label>Alamat
            <textarea name="alamat" rows="4">{{ old('alamat', $pasien->alamat ?? '') }}</textarea>
        </label>
    </section>

    <section class="panel form-section">
        <h2>Data Kunjungan</h2>
        <label>Tanggal Kunjungan
            <input type="date" name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan', optional($kunjungan->tanggal_kunjungan ?? today())->format('Y-m-d')) }}" required>
        </label>
        <label>Poli Tujuan
            <select name="poli_id" required>
                <option value="">Pilih poli</option>
                @foreach ($polis as $poli)
                    <option value="{{ $poli->id }}" @selected(old('poli_id', $kunjungan->poli_id ?? '') === $poli->id)>{{ $poli->nama_poli }}</option>
                @endforeach
            </select>
        </label>
        <label>Dokter
            <select name="dokter_id" required>
                <option value="">Pilih dokter</option>
                @foreach ($dokters as $dokter)
                    <option value="{{ $dokter->id }}" @selected(old('dokter_id', $kunjungan->dokter_id ?? '') === $dokter->id)>
                        {{ $dokter->nama_dokter }} - {{ $dokter->poli->nama_poli }}
                    </option>
                @endforeach
            </select>
        </label>
        <label>Jenis Pembayaran
            <select name="jenis_pembayaran" required>
                @foreach (['umum' => 'Umum', 'bpjs' => 'BPJS', 'asuransi' => 'Asuransi'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('jenis_pembayaran', $kunjungan->jenis_pembayaran ?? 'umum') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </label>
    </section>
</div>

<div class="form-actions">
    <a class="button ghost" href="{{ route('kunjungans.index') }}">Batal</a>
    <button class="button primary" type="submit">{{ $submit }}</button>
</div>
