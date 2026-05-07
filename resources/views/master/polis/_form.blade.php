<section class="panel form-section">
    <label>Nama Poli
        <input name="nama_poli" value="{{ old('nama_poli', $poli->nama_poli ?? '') }}" required>
    </label>
    <label>Deskripsi
        <textarea name="deskripsi" rows="4">{{ old('deskripsi', $poli->deskripsi ?? '') }}</textarea>
    </label>
</section>

<div class="form-actions">
    <a class="button ghost" href="{{ route('master.polis.index') }}">Batal</a>
    <button class="button primary" type="submit">{{ $submit }}</button>
</div>
