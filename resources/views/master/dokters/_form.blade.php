<section class="panel form-section">
    <label>Poli
        <select name="poli_id" required>
            <option value="">Pilih poli</option>
            @foreach ($polis as $poli)
                <option value="{{ $poli->id }}" @selected(old('poli_id', $dokter->poli_id ?? '') === $poli->id)>{{ $poli->nama_poli }}</option>
            @endforeach
        </select>
    </label>
    <label>Nama Dokter
        <input name="nama_dokter" value="{{ old('nama_dokter', $dokter->nama_dokter ?? '') }}" required>
    </label>
    <label>Spesialis
        <input name="spesialis" value="{{ old('spesialis', $dokter->spesialis ?? '') }}">
    </label>
</section>

<div class="form-actions">
    <a class="button ghost" href="{{ route('master.dokters.index') }}">Batal</a>
    <button class="button primary" type="submit">{{ $submit }}</button>
</div>
