@extends('layouts.app')

@section('content')
    <div id="location-data" data-locations="{{ json_encode($locations) }}"></div>

    <main id="main" class="main">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h4 fw-bold">Edit Aset</h1>
        </div>

        <div class="row d-flex justify-content-center">
            <div class="card">
                <div class="card mt-4">
                    <div class="card-header">
                        <div class="row" style="margin-top: -18px; margin-bottom: -18px">
                            <div class="col-md-6">
                                <h5 class="card-title">Form Edit Aset</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <form class="row g-3 needs-validation" action="{{ route('asetTetap.update', $item->id) }}" method="POST"
                        enctype="multipart/form-data" novalidate>
                        @csrf
                        @method('PUT')

                        <!-- Baris 1: Kode, NUP, No Seri -->
                        <div class="col-md-4">
                            <label for="code" class="col-form-label fw-bold">Kode <span class="text-danger">*</span></label>
                            <input type="text" id="code" name="code" class="form-control" value="{{ old('code', $item->code) }}" required>
                            @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="nup" class="col-form-label fw-bold">NUP <span class="text-danger">*</span></label>
                            <input type="text" id="nup" name="nup" class="form-control" value="{{ old('nup', $item->nup) }}" required>
                            @error('nup') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="no_seri" class="col-form-label fw-bold">No Seri</label>
                            <input type="text" id="no_seri" name="no_seri" class="form-control" value="{{ old('no_seri', $item->no_seri) }}">
                        </div>

                        <!-- Baris 2: Nama Barang & Nama Fix -->
                        <div class="col-12">
                            <label for="name" class="col-form-label fw-bold">Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $item->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-12">
                            <label for="name_fix" class="col-form-label fw-bold">Nama Fix / Merk / Uraian</label>
                            <input type="text" id="name_fix" name="name_fix" class="form-control" value="{{ old('name_fix', $item->name_fix) }}">
                        </div>

                        <!-- Baris 3: Nilai, Tahun, Quantity, Satuan, Umur -->
                        <div class="col-md-3">
                            <label for="nilai" class="col-form-label fw-bold">Nilai (Rp)</label>
                            <input type="number" id="nilai" name="nilai" class="form-control" value="{{ old('nilai', $item->nilai) }}" step="1">
                        </div>
                        <div class="col-md-3">
                            <label for="years" class="col-form-label fw-bold">Tahun</label>
                            <input type="number" id="years" name="years" class="form-control" value="{{ old('years', $item->years) }}">
                        </div>
                        <div class="col-md-2">
                            <label for="quantity" class="col-form-label fw-bold">Qty</label>
                            <input type="number" id="quantity" name="quantity" class="form-control" value="{{ old('quantity', $item->quantity ?? 1) }}" min="1">
                        </div>
                        <div class="col-md-2">
                            <label for="satuan" class="col-form-label fw-bold">Satuan</label>
                            <input type="text" id="satuan" name="satuan" class="form-control" value="{{ old('satuan', $item->satuan) }}">
                        </div>
                        <div class="col-md-2">
                            <label for="life_time" class="col-form-label fw-bold">Umur (Thn)</label>
                            <input type="number" id="life_time" name="life_time" class="form-control" value="{{ old('life_time', $item->life_time) }}">
                        </div>

                        <!-- Baris 4: Kondisi, Kategori, Status, Tipe -->
                        <div class="col-md-3">
                            <label for="condition" class="col-form-label fw-bold">Kondisi</label>
                            <select id="condition" name="condition" class="form-select">
                                <option value="Baik" {{ old('condition', $item->condition) == 'Baik' ? 'selected' : '' }}>Baik</option>
                                <option value="Rusak Ringan" {{ old('condition', $item->condition) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                <option value="Rusak Berat" {{ old('condition', $item->condition) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="category" class="col-form-label fw-bold">Kategori</label>
                            <select id="category" name="category" class="form-select">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category', $item->category) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="col-form-label fw-bold">Status</label>
                            <select id="status" name="status" class="form-select">
                                <option value="Dipakai" {{ old('status', $item->status) == 'Dipakai' ? 'selected' : '' }}>Dipakai</option>
                                <option value="Tidak Dipakai" {{ old('status', $item->status) == 'Tidak Dipakai' ? 'selected' : '' }}>Tidak Dipakai</option>
                                <option value="Maintenance" {{ old('status', $item->status) == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                <option value="Diserahkan" {{ old('status', $item->status) == 'Diserahkan' ? 'selected' : '' }}>Diserahkan</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="col-form-label fw-bold">Tipe Aset</label>
                            <div class="mt-2">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type" id="type_tetap" value="Tetap" {{ old('type', $item->type) == 'Tetap' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="type_tetap">Tetap</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type" id="type_bergerak" value="Bergerak" {{ old('type', $item->type) == 'Bergerak' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="type_bergerak">Bergerak</label>
                                </div>
                            </div>
                        </div>

                        <!-- Lokasi -->
                        <div class="col-md-4">
                            <label for="gedung" class="col-form-label fw-bold">Gedung</label>
                            <select id="gedung" name="gedung" class="form-select">
                                <option value="">-- Pilih Gedung --</option>
                                @foreach ($gedungOptions as $gedung)
                                    <option value="{{ $gedung }}">{{ $gedung }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="lantai" class="col-form-label fw-bold">Lantai</label>
                            <select id="lantai" name="lantai" class="form-select"></select>
                        </div>
                        <div class="col-md-4">
                            <label for="ruangan" class="col-form-label fw-bold">Ruangan</label>
                            <select id="ruangan" name="ruangan" class="form-select"></select>
                        </div>

                        <!-- Kalibrasi (jika aset memerlukan) -->
                        <div class="col-md-4">
                            <label for="last_kalibrasi" class="col-form-label fw-bold">Kalibrasi Terakhir</label>
                            <input type="date" id="last_kalibrasi" name="last_kalibrasi" class="form-control" value="{{ old('last_kalibrasi', $item->last_kalibrasi ? $item->last_kalibrasi->format('Y-m-d') : '') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="schadule_kalibrasi" class="col-form-label fw-bold">Jadwal Kalibrasi</label>
                            <input type="date" id="schadule_kalibrasi" name="schadule_kalibrasi" class="form-control" value="{{ old('schadule_kalibrasi', $item->schadule_kalibrasi ? $item->schadule_kalibrasi->format('Y-m-d') : '') }}">
                        </div>

                        <!-- Dokumentasi / Foto -->
                        <div class="col-12">
                            <label for="documentation" class="col-form-label fw-bold">Dokumentasi / Foto</label>
                            <input type="file" id="documentation" name="documentation" class="form-control" accept="image/*,.pdf">
                            @if ($item->documentation)
                                <small class="text-muted">File saat ini: <a href="{{ asset('uploads/' . $item->documentation) }}" target="_blank">Lihat file</a></small>
                            @endif
                        </div>

                        <!-- Spesifikasi & Deskripsi -->
                        <div class="col-12">
                            <label for="specification" class="col-form-label fw-bold">Spesifikasi</label>
                            <textarea id="specification" name="specification" class="form-control" rows="3">{{ old('specification', $item->specification) }}</textarea>
                        </div>
                        <div class="col-12">
                            <label for="description" class="col-form-label fw-bold">Deskripsi / Catatan Tambahan</label>
                            <textarea id="description" name="description" class="form-control" rows="3">{{ old('description', $item->description) }}</textarea>
                        </div>

                        <!-- Tombol -->
                        <div class="col-md-12 text-center mt-4">
                            <button type="submit" class="btn btn-primary px-5 py-2">Simpan Perubahan</button>
                            <a href="{{ route('asetTetap.index') }}" class="btn btn-secondary px-5 py-2 ms-2">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <script>
        var locations = {!! json_encode($locations) !!};
        var previousGedung = "{{ $prevLocation->office ?? '' }}";
        var previousLantai = "{{ $prevLocation->floor ?? '' }}";
        var previousRuangan = "{{ $prevLocation->room ?? '' }}";

        var gedungSelect = document.getElementById("gedung");
        var lantaiSelect = document.getElementById("lantai");
        var ruanganSelect = document.getElementById("ruangan");

        function populateLantaiOptions() {
            var selectedGedung = gedungSelect.value;
            lantaiSelect.innerHTML = '<option value="">-- Pilih Lantai --</option>';
            var filteredLantai = [...new Set(locations.filter(l => l.office === selectedGedung).map(l => l.floor))];
            filteredLantai.forEach(l => {
                var opt = new Option(l || '-', l);
                if (l == previousLantai) opt.selected = true;
                lantaiSelect.add(opt);
            });
            populateRuanganOptions();
        }

        function populateRuanganOptions() {
            var selectedGedung = gedungSelect.value;
            var selectedLantai = lantaiSelect.value;
            ruanganSelect.innerHTML = '<option value="">-- Pilih Ruangan --</option>';
            var filteredRuangan = locations.filter(l => l.office === selectedGedung && l.floor == selectedLantai).map(l => l.room);
            filteredRuangan.forEach(r => {
                var opt = new Option(r || '-', r);
                if (r == previousRuangan) opt.selected = true;
                ruanganSelect.add(opt);
            });
        }

        gedungSelect.addEventListener("change", populateLantaiOptions);
        lantaiSelect.addEventListener("change", populateRuanganOptions);

        window.onload = function() {
            if (previousGedung) {
                gedungSelect.value = previousGedung;
                populateLantaiOptions();
            }
        };
    </script>
@endsection