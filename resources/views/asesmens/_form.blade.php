<section class="panel form-section">
    <div class="patient-strip">
        <strong>{{ $kunjungan->pasien->nama_pasien }}</strong>
        <span>{{ $kunjungan->kode_kunjungan }} - {{ $kunjungan->poli->nama_poli }} - {{ $kunjungan->dokter->nama_dokter }}</span>
    </div>

    <label>Keluhan Utama
        <textarea name="keluhan_utama" rows="4" required>{{ old('keluhan_utama', $asesmen->keluhan_utama ?? '') }}</textarea>
    </label>
    <div class="three-col">
        <label>Tekanan Darah
            <input name="tekanan_darah" placeholder="120/80" value="{{ old('tekanan_darah', $asesmen->tekanan_darah ?? '') }}">
        </label>
        <label>Suhu Tubuh
            <input type="number" step="0.1" name="suhu_tubuh" value="{{ old('suhu_tubuh', $asesmen->suhu_tubuh ?? '') }}">
        </label>
        <label>Berat Badan
            <input type="number" step="0.01" name="berat_badan" value="{{ old('berat_badan', $asesmen->berat_badan ?? '') }}">
        </label>
    </div>
    <label>Diagnosis Awal
        <textarea name="diagnosis_awal" rows="4" required>{{ old('diagnosis_awal', $asesmen->diagnosis_awal ?? '') }}</textarea>
    </label>
    <label>Tindakan/Terapi
        <textarea name="tindakan_terapi" rows="3">{{ old('tindakan_terapi', $asesmen->tindakan_terapi ?? '') }}</textarea>
    </label>
    <label>Catatan Dokter
        <textarea name="catatan_dokter" rows="3">{{ old('catatan_dokter', $asesmen->catatan_dokter ?? '') }}</textarea>
    </label>
</section>

<div class="form-actions">
    <a class="button ghost" href="{{ route('kunjungans.show', $kunjungan) }}">Batal</a>
    <button class="button primary" type="submit">{{ $submit }}</button>
</div>
