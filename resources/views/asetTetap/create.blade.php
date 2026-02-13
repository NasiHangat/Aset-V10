@extends('layouts.app')

@section('content')
    <div id="location-data" data-locations="{{ json_encode($locations) }}"></div>

    <main id="main" class="main">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h4 fw-bold">Aset</h1>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="card shadow-sm">
                <div class="card mt-4">
                    <div class="card-header">
                        <div class="row" style="margin-top: -18px; margin-bottom: -18px">
                            <div class="col-md-6">
                                <h5 class="card-title">Form Tambah Aset</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form class="row g-3 needs-validation" action="{{ route('asetTetap.store') }}" method="POST"
                        enctype="multipart/form-data" id="your-form-id" novalidate>
                        @csrf
                        
                        <div class="col-6">
                            <label for="kode_barang" class="col-form-label fw-bold">Kode Barang <span class="text-danger">*</span></label>
                            <input type="text" id="kode_barang" name="kode_barang" class="form-control" placeholder="Contoh: 3050104..." required>
                        </div>
                        <div class="col-6">
                            <label for="nup" class="col-form-label fw-bold">NUP <span class="text-danger">*</span></label>
                            <input type="number" id="nup" name="nup" class="form-control" placeholder="No Urut Pendaftaran" required>
                        </div>

                        <div class="col-12">
                            <label for="nama_barang" class="col-form-label fw-bold">Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" id="nama_barang" name="nama_barang" class="form-control" placeholder="Masukkan nama barang" required>
                        </div>

                        <div class="col-6">
                            <label for="merk" class="col-form-label fw-bold">Merk/ Uraian Barang <span class="text-danger">*</span></label>
                            <input type="text" id="merk" name="merk" class="form-control" placeholder="Contoh: Asus, Honda, dll" required>
                        </div>
                        <div class="col-6">
                            <label for="no_seri" class="col-form-label fw-bold">No Seri</label>
                            <input type="text" id="no_seri" name="no_seri" class="form-control" placeholder="Serial Number">
                        </div>

                        <div class="col-6">
                            <label for="category" class="col-form-label fw-bold">Kategori</label>
                            <select id="category" name="category" class="form-select" required>
                                <option value="" selected disabled>Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="kondisi" class="col-form-label fw-bold">Kondisi</label>
                            <select id="kondisi" name="kondisi" class="form-select" required>
                                <option value="Baik">Baik</option>
                                <option value="Rusak Ringan">Rusak Ringan</option>
                                <option value="Rusak Berat">Rusak Berat</option>
                            </select>
                        </div>

                        <div class="col-6">
                            <label for="calibrate" class="col-form-label fw-bold">Kalibrasi</label>
                            <select id="calibrate" name="calibrate" class="form-select">
                                <option value="0">Tidak Perlu Kalibrasi</option>
                                <option value="1">Perlu Kalibrasi</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="lifetime" class="col-form-label fw-bold">Life Time (Tahun)</label>
                            <input type="number" id="lifetime" name="lifetime" class="form-control" placeholder="Masa pakai aset">
                        </div>

                        <div class="col-12">
                            <label for="spek" class="col-form-label fw-bold">Spesifikasi</label>
                            <textarea id="spek" name="spek" class="form-control" rows="2" placeholder="Detail spesifikasi barang"></textarea>
                        </div>

                        <div class="col-6">
                            <label class="form-label fw-bold">Type Aset</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="type_tetap" value="Tetap" checked>
                                    <label class="form-check-label" for="type_tetap">Tetap</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="type_bergerak" value="Bergerak">
                                    <label class="form-check-label" for="type_bergerak">Bergerak</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="nilai" class="col-form-label fw-bold">Nilai (Rp)</label>
                            <input type="number" id="nilai" name="nilai" class="form-control" placeholder="0">
                        </div>

                        <div class="col-4">
                            <label for="tahun" class="col-form-label fw-bold">Tahun Perolehan</label>
                            <input type="number" id="tahun" name="tahun" class="form-control" value="{{ date('Y') }}">
                        </div>
                        <div class="col-4">
                            <label for="satuan" class="col-form-label fw-bold">Satuan</label>
                            <input type="text" id="satuan" name="satuan" class="form-control" placeholder="Unit/Pcs/Set">
                        </div>
                        <div class="col-4">
                            <label for="status" class="col-form-label fw-bold">Status</label>
                            <select id="status" name="status" class="form-select">
                                <option value="Tidak Dipakai" selected>Tidak Dipakai</option>
                                <option value="Dipakai">Dipakai</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                        </div>

                        <div class="col-4">
                            <label for="gedung" class="col-form-label fw-bold">Gedung</label>
                            <select id="gedung" name="gedung" class="form-select" required>
                                <option value="" disabled selected>Pilih Gedung</option>
                                @foreach ($gedungOptions as $gedung)
                                    <option value="{{ $gedung }}">{{ $gedung }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="lantai" class="col-form-label fw-bold">Lantai</label>
                            <select id="lantai" name="lantai" class="form-select" disabled required>
                                <option value="" disabled selected>Pilih Lantai</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="ruangan" class="col-form-label fw-bold">Ruangan</label>
                            <select id="ruangan" name="ruangan" class="form-select" disabled required>
                                <option value="" disabled selected>Pilih Ruangan</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="supervisor" class="col-form-label fw-bold">Penanggung Jawab</label>
                            <select id="supervisor" name="supervisor" class="form-select" required>
                                <option value="" disabled selected>Pilih Penanggung Jawab</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6">
                            <label for="dokumentasi" class="col-form-label fw-bold">Dokumentasi (Foto)</label>
                            <input type="file" id="dokumentasi" name="dokumentasi" class="form-control" accept="image/*">
                        </div>
                        <div class="col-6">
                            <label for="keterangan" class="col-form-label fw-bold">Keterangan <span class="text-danger">*</span></label>
                            <textarea id="keterangan" name="keterangan" class="form-control" rows="2" required></textarea>
                        </div>

                        <div class="col-12 mt-4 text-center">
                            <button type="submit" class="btn btn-primary px-5">Simpan Aset</button>
                            <a href="{{ route('asetTetap.index') }}" class="btn btn-secondary px-5">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Logika Dropdown Dinamis (Gedung -> Lantai -> Ruangan)
        var locations = {!! json_encode($locations) !!};
        var gedungSelect = document.getElementById("gedung");
        var lantaiSelect = document.getElementById("lantai");
        var ruanganSelect = document.getElementById("ruangan");

        gedungSelect.addEventListener("change", function() {
            var selectedGedung = this.value;
            lantaiSelect.innerHTML = '<option value="" disabled selected>Pilih Lantai</option>';
            ruanganSelect.innerHTML = '<option value="" disabled selected>Pilih Ruangan</option>';
            ruanganSelect.disabled = true;

            var filteredLantai = [...new Set(locations.filter(l => l.office === selectedGedung).map(l => l.floor))];
            filteredLantai.forEach(l => {
                lantaiSelect.add(new Option(l, l));
            });
            lantaiSelect.disabled = false;
        });

        lantaiSelect.addEventListener("change", function() {
            var selectedGedung = gedungSelect.value;
            var selectedLantai = this.value;
            ruanganSelect.innerHTML = '<option value="" disabled selected>Pilih Ruangan</option>';

            var filteredRuangan = locations.filter(l => l.office === selectedGedung && l.floor == selectedLantai).map(l => l.room);
            filteredRuangan.forEach(r => {
                ruanganSelect.add(new Option(r, r));
            });
            ruanganSelect.disabled = false;
        });
    </script>
@endsection