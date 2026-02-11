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
                                <h5 class="card-title">Form Edit Aset</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {{--<form class="row g-3" form action="/asetTetap/{{ $item->id }}" method="POST"--}}
                    <form class="row g-3" form action="{{ route('asetTetap.update',$item->id) }}" method="POST"
                        enctype="multipart/form-data" id="your-form-id" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        <div class="col-6">
                            <label for="kode_barang" class=" col-form-label fw-bold">Kode Barang <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <input type="text" id="kode_barang" name="kode_barang" class="form-control"
                                    value="{{ old('code', $item->code ?? '') }}">
                                {{-- <div id="kode_barang_feedback" class="invalid-feedback"></div> --}}
                                <div id="kode_barang_error" class="invalid-feedback"></div>
                                <div id="kode_barang_success" class="valid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="nup" class="col-form-label fw-bold">NUP <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <input type="text" id="nup" name="nup" class="form-control"
                                    value="{{ old('nup', $item->nup ?? '') }}">
                                <div id="nup_error" class="invalid-feedback"></div>
                                <div id="nup_success" class="valid-feedback"></div>
                                <div id="item-data" data-nup="{{ $item->nup ?? '' }}"></div>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <label for="nama_barang" class=" col-form-label fw-bold">Nama Barang <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <input type="text" id="nama_barang" name="nama_barang" class="form-control"
                                    value="{{ old('name', $item->name ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="" class=" col-form-label fw-bold">Type Aset <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <label>
                                    <input type="radio" name="type" id="type" value="Tetap" required
                                        {{ $item->type === 'Tetap' ? 'checked' : '' }}>
                                    Tetap
                                </label>
                            </div>
                            <div>
                                <label>
                                    <input type="radio" name="type" id="type" value="Bergerak" required
                                        {{ $item->type === 'Bergerak' ? 'checked' : '' }}>
                                    Bergerak
                                </label>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="merk" class="col-form-label fw-bold">Merk / Uraian Barang <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <input type="text" id="koreksi_nama" name="koreksi_nama" class="form-control"
                                    value="{{ old('name_fix', $item->name_fix ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="no_seri" class="col-form-label fw-bold">No Seri <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <input type="text" id="no_seri" name="no_seri" class="form-control"
                                    value="{{ old('no_seri', $item->no_seri ?? '') }}">
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
                                    <input type="text" class="form-control" id="amount_display"
                                        value="{{ old('nilai', number_format($item->nilai, 0, ',', '.') ?? '') }}">

                                    <input type="hidden" id="nilai" name="nilai" class="form-control"
                                        value="{{ old('nilai', $item->nilai) }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="tahun" class="col-form-label fw-bold">Tahun <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <input type="text" id="tahun" name="tahun" class="form-control"
                                    pattern="[0-9]*" inputmode="numeric" min="1900" max="2100" required
                                    value="{{ old('years', $item->years ?? '') }}">
                                <div id="tahun_error" class="invalid-feedback">Please enter a valid numeric value.</div>
                                <div id="tahun_success" class="valid-feedback">Looks good!</div>
                            </div>
                        </div>
                        {{-- <div class="col-md-2">
                            <label for="quantity" class="col-form-label fw-bold">Kuantitas <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <input type="number" id="quantity" name="quantity" class="form-control"
                                    value="{{ $item->quantity }}" required>
                            </div>
                        </div> --}}
                        <div class="col-md-2">
                            <label for="satuan" class="col-form-label fw-bold">Satuan <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <input type="text" id="satuan" name="satuan" class="form-control"
                                    value="{{ $item->satuan }}" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="status" class="col-form-label fw-bold">Status <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <select id="status" name="status" class="form-control">
                                    <option value="Tidak Dipakai" {{ $item->status == "Tidak Dipakai" ? 'selected' : '' }}>Tidak Dipakai</option>
                                    <option value="Maintenance" {{ $item->status == "Maintenance" ? 'selected' : '' }}>Maintenance</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="spek" class="col-form-label fw-bold">Spesifikasi <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <textarea id="spek" name="spek" class="form-control">{!! old('spek', $item->specification ?? '') !!}</textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="gedung" class="col-form-label fw-bold">Lokasi <span
                                    class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- Gedung select field -->
                                    <select id="gedung" name="gedung" class="form-control">
                                        @if (!empty($prevLocation))
                                            <option value="{{ $prevLocation->office }}" selected>{{ $prevLocation->office }}
                                        @endif
                                        </option>
                                        @foreach ($gedungOptions as $gedung)
                                            <option value="{{ $gedung }}">{{ $gedung }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select id="lantai" name="lantai" class="form-control">
                                        @if (!empty($prevLocation))
                                            <option value="{{ $prevLocation->floor }}" selected>{{ $prevLocation->floor }}
                                        @endif
                                        </option>
                                        @foreach ($lantaiOptions as $lantai)
                                            <option value="{{ $lantai }}">{{ $lantai }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select id="ruangan" name="ruangan" class="form-control">
                                        @if (!empty($prevLocation))
                                            <option value="{{ $prevLocation->room }}" selected>{{ $prevLocation->room }}
                                    @endif

                                        </option>
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
                                        <option value="{{ $category->id }}"
                                            {{ $category->id == $item->category ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="kondisi" class="col-form-label fw-bold">Kondisi <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <select id="kondisi" name="kondisi" class="form-control"
                                    value="{{ old('condition', $item->condition ?? '') }}">
                                    <option value="Baik">Baik</option>
                                    <option value="Rusak Ringan">Rusak</option>
                                    <option value="Rusak Berat">Rusak Berat</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="supervisor" class="col-form-label fw-bold">Penanggung Jawab <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <select id="supervisor" name="supervisor" class="form-control">
                                    @foreach ($employees as $employee)
                                        @if ($employee->id == $item->supervisor)
                                            <option value="{{ $employee->id }}">{{ $employee->name }} </option>
                                        @endif
                                    @endforeach
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="dokumentasi" class="col-form-label fw-bold">Dokumentasi (2MB)</label>
                            <div class="">
                                @if (isset($item->documentation))
                                    <img src="{{ asset('uploads/' . $item->documentation) }}" alt=""
                                        style="max-width: 100px; max-height: 100px;">
                                @endif
                                <input type="file" id="dokumentasi" name="dokumentasi" class="form-control">
                                <span id="file_error" class="text-danger"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="life_time" class="col-form-label fw-bold">Life Time</label>
                            <div class="">
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" id="life_time" name="life_time" class="form-check-input"
                                        onchange="toggleDateInput(this)" <?php echo $item->life_time !== null ? 'checked' : ''; ?>>
                                </div>
                                <div class="form-group form-check-inline" id="dateInputContainer" style="display: none;">
                                    <input type="date" id="expiry_date" name="expiry_date" class="form-control"
                                        value="{{ old('expiry_date', $item->life_time) }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="dikalibrasi" class="col-form-label fw-bold">Dikalibrasi</label>
                            <div class="">
                                <input type="checkbox" id="kalibrasi_check" name="dikalibrasi" value="1"
                                    onchange="toggleKalibrasiFields(this)" {{ $item->dikalibrasi == 1 ? 'checked' : '' }}>
                            </div>
                            <div class="form-group" id="kalibrasiFields" style="display: none;">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group fw-bold">
                                            <label for="kalibrasi_by">Dikalibrasi oleh</label>
                                            <input type="text" class="form-control" name="kalibrasi_by"
                                                value="{{ $item->kalibrasi_by }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group fw-bold">
                                            <label for="last_kalibrasi">Terakhir Kalibrasi</label>
                                            <input type="number" class="form-control" name="last_kalibrasi"
                                                min="1900" max="2100"
                                                value="{{ $item->last_kalibrasi }}"oninput="updateScheduleKalibrasi(this)">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group fw-bold">
                                            <label for="schedule_kalibrasi">Jadwal Kalibrasi</label>
                                            <input type="number" class="form-control" name="schedule_kalibrasi"
                                                min="1900" max="2100" value="{{ $item->schadule_kalibrasi }}">
                                        </div>
                                    </div>
                                    <div id="kalibrasiWarning" class="text-danger" style="display: none;">Silakan isi
                                        semua
                                        field
                                        kalibrasi.</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="keterangan" class="col-form-label fw-bold">Keterangan <span
                                    class="text-danger">*</span></label>
                            <div class="">
                                <textarea id="keterangan" name="keterangan" class="form-control">{!! old('description', $item->description ?? '') !!}</textarea>
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

    <script src="{{ asset('js/editaset.js') }}"></script>
    <script>
        //=================== LIFE TIME =================================
        //====================================================
        // show date picker if checked
        function toggleDateInput(checkbox) {
            var dateInputContainer = document.getElementById('dateInputContainer');
            dateInputContainer.style.display = checkbox.checked ? 'block' : 'none';
        }

        // Check if $item->life_time is not null and update checkbox state
        var lifeTimeCheckbox = document.getElementById('life_time');
        if (lifeTimeCheckbox && <?php echo $item->life_time !== null ? 'true' : 'false'; ?>) {
            lifeTimeCheckbox.checked = true;
            toggleDateInput(lifeTimeCheckbox);
        }

        //===================== END OF LIFE TIME ===============================
        //====================================================

        //================== SELECT LOCATIONS ==================================
//====================================================
var locationsDataElement = document.getElementById('location-data');
var locations = JSON.parse(locationsDataElement.getAttribute('data-locations'));
// Get the select fields
var gedungSelect = document.getElementById("gedung");
var lantaiSelect = document.getElementById("lantai");
var ruanganSelect = document.getElementById("ruangan");

// Store the previous values
var previousGedung = "{{ $prevLocation ? $prevLocation->office : '' }}";
var previousLantai = "{{ $prevLocation ? $prevLocation->floor : '' }}";
var previousRuangan = "{{ $prevLocation ? $prevLocation->room : '' }}";

// Define the locations data
var locations = {!! $locations !!};

// Function to populate "Lantai" options
function populateLantaiOptions() {
    // Clear previous options
    lantaiSelect.innerHTML = '<option value="" disabled selected>Pilih Lantai</option>';
    ruanganSelect.innerHTML = '<option value="" disabled selected>Pilih Ruangan</option>';

    // Filter and populate "Lantai" options
    var selectedGedung = gedungSelect.value;
    var selectedLantaiOptions = locations.filter(function(location) {
        return location.office === selectedGedung;
    }).map(function(location) {
        return location.floor;
    }).filter(function(value, index, self) {
        return self.indexOf(value) === index;
    });

    selectedLantaiOptions.forEach(function(option) {
        var optionElement = document.createElement("option");
        optionElement.value = option;
        optionElement.textContent = option;
        lantaiSelect.appendChild(optionElement);
    });

    // Set the selected option based on the previous value
    if (selectedLantaiOptions.includes(previousLantai)) {
        lantaiSelect.value = previousLantai;
        populateRuanganOptions();
    }
}

// Function to populate "Ruangan" options
function populateRuanganOptions() {
    // Clear previous options
    ruanganSelect.innerHTML = '<option value="" disabled selected>Pilih Ruangan</option>';

    // Filter and populate "Ruangan" options
    var selectedGedung = gedungSelect.value;
    var selectedLantai = lantaiSelect.value;
    var selectedRuanganOptions = locations.filter(function(location) {
        return location.office === selectedGedung && location.floor === selectedLantai;
    }).map(function(location) {
        return location.room;
    }).filter(function(value, index, self) {
        return self.indexOf(value) === index;
    });

    selectedRuanganOptions.forEach(function(option) {
        var optionElement = document.createElement("option");
        optionElement.value = option;
        optionElement.textContent = option;
        ruanganSelect.appendChild(optionElement);
    });

    // Set the selected option based on the previous value
    if (selectedRuanganOptions.includes(previousRuangan)) {
        ruanganSelect.value = previousRuangan;
    }
}

// Function to check if the previous "Ruangan" value is available for the selected "Gedung" and "Lantai" combination
function isRuanganAvailable(selectedGedung, selectedLantai) {
    return locations.some(function(location) {
        return location.office === selectedGedung && location.floor === selectedLantai && location.room === previousRuangan;
    });
}

// Event listener for "Gedung" select field change
gedungSelect.addEventListener("change", function() {
    // Enable "Lantai" select field
    lantaiSelect.disabled = false;

    populateLantaiOptions();
});

// Event listener for "Lantai" select field change
lantaiSelect.addEventListener("change", function() {
    // Enable "Ruangan" select field
    ruanganSelect.disabled = false;

    populateRuanganOptions();
});

// Trigger "change" event for "Gedung" select field when page loads
window.addEventListener("load", function() {
    // Set the selected option based on the previous value
    gedungSelect.value = previousGedung;

    // Trigger the change event manually
    gedungSelect.dispatchEvent(new Event("change"));
});

//================== END SELECT LOCATIONS ==================================
//====================================================

    </script>
@endsection
