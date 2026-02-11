@extends('layouts.app')

@section('content')
    <div id="location-data" data-locations="{{ json_encode($locations) }}"></div>
    <main id="main" class="main">

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h4 fw-bold">Aset</h1>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="card">
                <div class="card mt-4">
                    <div class="card-header">
                        <div class="row" style="margin-top: -18px; margin-bottom: -18px">
                            <div class="col-md-6">
                                <h5 class="card-title">Form Aset</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form class="row g-3" form action="{{ route('asetTetap.store') }}" method="POST" enctype="multipart/form-data"
                        id="your-form-id">
                        @csrf
                        <div class="col-6">
                            <label for="kode_barang" class=" col-form-label fw-bold">Kode Barang <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <input type="text" id="kode_barang" name="kode_barang" class="form-control" required>
                                {{-- <div id="kode_barang_feedback" class="invalid-feedback"></div> --}}
                                <div id="kode_barang_error" class="invalid-feedback"></div>
                                <div id="kode_barang_success" class="valid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="nup" class="col-form-label fw-bold">NUP <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <input type="text" id="nup" name="nup" class="form-control" required>
                                <div id="nup_error" class="invalid-feedback"></div>
                                <div id="nup_success" class="valid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <label for="nama_barang" class=" col-form-label fw-bold">Nama Barang <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <input type="text" id="nama_barang" name="nama_barang" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-2" id="type-aset">
                            <label for="" class=" col-form-label fw-bold">Type Aset <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <label>
                                    <input type="radio" name="type" id="type_tetap" value="Tetap" required>
                                    Tetap
                                </label>
                            </div>
                            <div>
                                <label>
                                    <input type="radio" name="type" id="type_bergerak" value="Bergerak" required>
                                    Bergerak
                                </label>
                            </div>
                            <div id="type-aset-error" class="invalid-feedback" style="display: none;">
                                Please select a Type Aset.
                            </div>

                        </div>
                        <div class="col-md-6">
                            <label for="merk" class="col-form-label fw-bold">Merk / Uraian Barang <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <input type="text" id="merk" name="merk" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="no_seri" class="col-form-label fw-bold">No Seri <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <input type="text" id="no_seri" name="no_seri" class="form-control" required>
                                <div id="no_seri_error" class="invalid-feedback"></div>
                                <div id="no_seri_success" class="valid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="nilai" class="col-form-label fw-bold">Nilai <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text" class="form-control" id="amount_display" required>
                                    <input type="hidden" id="nilai" name="nilai" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="tahun" class="col-form-label fw-bold">Tahun <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <input type="text" id="tahun" name="tahun" class="form-control"
                                    pattern="[0-9]*" inputmode="numeric" min="1900" max="2100" required>
                                <div id="tahun_error" class="invalid-feedback">Please enter a valid numeric value.</div>
                                <div id="tahun_success" class="valid-feedback">Looks good!</div>
                            </div>
                        </div>
                        {{-- <div class="col-md-2">
                            <label for="quantity" class="col-form-label fw-bold">Kuantitas <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <input type="number" id="quantity" name="quantity" class="form-control" required>
                            </div>
                        </div> --}}
                        <div class="col-md-2">
                            <label for="satuan" class="col-form-label fw-bold">Satuan <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <input type="text" id="satuan" name="satuan" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="spek" class="col-form-label fw-bold">Spesifikasi <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <textarea id="spek" name="spek" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="gedung" class="col-form-label fw-bold">Lokasi <span
                                    class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- Gedung select field -->
                                    <select id="gedung" name="gedung" class="form-control" required>
                                        <option value="">Pilih Gedung</option>
                                        @foreach ($gedungOptions as $gedung)
                                            <option value="{{ $gedung }}">{{ $gedung }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <!-- Lantai select field -->
                                    <select id="lantai" name="lantai" class="form-control" disabled required>
                                        <option value="">Pilih Lantai</option>
                                        @foreach ($lantaiOptions as $lantai)
                                            <option value="{{ $lantai }}">{{ $lantai }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class=" col-md-4">
                                    <!-- Ruangan select field -->
                                    <select id="ruangan" name="ruangan" class="form-control" disabled required>
                                        <option value="">Pilih Ruangan</option>
                                        <!-- Options will be populated dynamically based on the selected "gedung" and "lantai" -->
                                    </select>
                                </div>
                                <div id="lokasi_error" class="invalid-feedback">
                                    Silakan pilih lokasi yang valid.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="category" class="col-form-label fw-bold">Kategori <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <select id="category" name="category" class="form-control" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="kondisi" class="col-form-label fw-bold">Kondisi <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <select id="kondisi" name="kondisi" class="form-control" required>
                                    <option value="Baik">Baik</option>
                                    <option value="Rusak Ringan">Rusak Ringan</option>
                                    <option value="Rusak Berat">Rusak Berat</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="supervisor" class="col-form-label fw-bold">Penanggung Jawab <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <select id="supervisor" name="supervisor" class="form-control" required>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="dokumentasi" class="col-form-label fw-bold">Dokumentasi (2MB)</label>
                            <div class="">
                                <input type="file" id="dokumentasi" name="dokumentasi" class="form-control">
                                <span id="file_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="life_time" class="col-form-label fw-bold">Life Time</label>
                            <div class="">
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" id="life_time" name="life_time" class="form-check-input"
                                        onchange="toggleDateInput(this)">
                                </div>
                                <div class="form-group form-check-inline" id="dateInputContainer" style="display: none;">
                                    <input type="date" id="expiry_date" name="expiry_date" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="dikalibrasi" class="col-form-label fw-bold">Dikalibrasi</label>
                            <div class="">
                                <input type="checkbox" name="dikalibrasi" value="1"
                                    onchange="toggleKalibrasiFields(this)">
                            </div>
                            <div class="form-group" id="kalibrasiFields" style="display: none;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group fw-bold">
                                            <label for="kalibrasi_by">Dikalibrasi oleh</label>
                                            <input type="text" class="form-control" name="kalibrasi_by">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group fw-bold">
                                            <label for="last_kalibrasi">Terakhir Kalibrasi</label>
                                            <input type="number" class="form-control" name="last_kalibrasi" min="1900"
                                                max="2100" oninput="updateScheduleKalibrasi(this)">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group fw-bold">
                                            <label for="schedule_kalibrasi">Jadwal Kalibrasi</label>
                                            <input type="number" class="form-control" name="schedule_kalibrasi"
                                                min="1900" max="2102">
                                        </div>
                                    </div>
                                    <div id="kalibrasiWarning" class="text-danger" style="display: none;">Silakan isi semua
                                        field
                                        kalibrasi.</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="keterangan" class="col-form-label fw-bold">Keterangan <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <textarea id="keterangan" name="keterangan" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="javascript:history.go(-1)" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                    <!-- End Default Table Example -->
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('js/createaset.js') }}"></script>
@endsection
