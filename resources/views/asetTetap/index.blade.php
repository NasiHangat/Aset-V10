@extends('layouts.app')
@section('content')

<style>
    /* Styling Khusus untuk Tampilan Compact */
    .table-custom {
        font-size: 0.825rem;
    }
    .table-custom th {
        background-color: #f6f9ff;
        color: #012970;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        padding: 10px 8px;
        white-space: nowrap;
    }
    .table-custom td {
        vertical-align: middle;
        padding: 8px 8px;
    }
    
    /* Title Styling */
    .page-title-custom {
        font-family: "Nunito", sans-serif;
        font-weight: 800;
        color: #012970;
        font-size: 1.35rem;
        letter-spacing: -0.3px;
        margin-bottom: 0;
    }

    .search-input { font-size: 0.9rem; border-right: none; }
    .search-btn { border-left: none; background-color: white; color: #4154f1; border-color: #ced4da; }
    .search-btn:hover { background-color: #f6f9ff; }
    .btn-action-group .btn { padding: 0.25rem 0.6rem; font-size: 0.8rem; }
</style>

<div id="location-data" data-locations="{{ json_encode($locations) }}"></div>

<main id="main" class="main" style="padding-top: 50px;"> 

    <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
        <div>
            <h1 class="page-title-custom">DATA ASET</h1>
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb mb-0" style="font-size: 0.8rem;">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active">Aset Tetap</li>
                </ol>
            </nav>
        </div>
    </div>

    <section class="section">
        <div class="card border-0 shadow-sm" style="border-radius: 8px;">
            <div class="card-body p-3">
                
                <div class="row g-2 mb-3 align-items-center">
                    <div class="col-lg-4 col-md-6">
                        <form action="{{ route('asetTetap.search') }}" method="POST">
                            @csrf
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                                <input type="text" name="query" class="form-control border-start-0 ps-0" placeholder="Cari Kode, NUP, atau Nama..." value="{{ request()->input('query') }}">
                                <a href="#" class="btn btn-outline-secondary" id="filterButton" title="Filter Lanjutan"><i class="bi bi-funnel"></i></a>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-8 col-md-6 text-md-end text-start">
                        <div class="btn-action-group">
                            <a href="{{ route('asetTetap.create') }}" class="btn btn-success btn-sm me-1 shadow-sm">
                                <i class="bi bi-plus-lg"></i> Tambah
                            </a>
                            <a href="{{ route('asetTetap.import') }}" class="btn btn-success btn-sm me-1">
                                <i class="bi bi-file-earmark-arrow-down"></i> Import
                            </a>
                            
                            <div class="d-inline-block border-start "></div>

                            <button onclick="exportAset('{{ route('asetTetap.export') }}')" class="btn btn-primary btn-sm me-1" title="Export Excel">
                                <i class="bi bi-file-earmark-arrow-up"></i> Export
                            </button>
                            <button onclick="generateQRCodes('{{ route('generate_qrcodes') }}')" class="btn btn-info btn-sm me-1" title="Cetak QR">
                                <i class="bi bi-qr-code"></i> QR
                            </button>
                            <button onclick="multiDelete('{{ route('asetTetap.multiDelete') }}')" class="btn btn-danger btn-sm" title="Hapus Masal">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                </div>

                <div id="filterFields" style="display: {{ request()->is('asetTetap/filter') ? ' block' : 'none' }};" class="mb-3 bg-light p-3 rounded">
                    @include('asetTetap.filter')
                </div>

                <div class="table-responsive" style="max-height: 650px; overflow-y: auto;">
                    <form action="" method="post" class="form-produk">
                        @csrf
                        <table class="table table-sm table-hover table-bordered table-custom mb-0">
                            <thead style="position: sticky; top: 0; z-index: 10;">
                                <tr>
                                    <th class="text-center" style="width: 40px;">
                                        <input type="checkbox" id="select_all">
                                    </th>
                                    <th class="text-center">No</th>
                                    <th>Kode</th>
                                    <th>NUP</th>
                                    <th>Nama Barang</th>
                                    <th>Nama Fix</th>
                                    <th>No Seri</th>
                                    <th class="text-center">Tahun</th>
                                    <th>Nilai (Rp)</th>
                                    <th class="text-center">Kondisi</th>
                                    <th>Kategori</th>
                                    <th>Lokasi</th>
                                    <th>Penanggung Jawab</th>
                                    <th>Kalibrasi Terakhir</th>
                                    <th>Jadwal Kal.</th>
                                    <th>Status</th>
                                    <th>Tipe</th>
                                    <th>Qty</th>
                                    <th>Satuan</th>
                                    <th>Umur (Thn)</th>
                                    <th class="text-center" style="min-width: 80px;">Dokumentasi</th>
                                    <th class="text-center" style="min-width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($items as $item)
                                    @if ($item->status !== "Diserahkan")
                                        <tr data-item-id="{{ $item->id }}">
                                            <td class="text-center">
                                                <input class="form-check-input" type="checkbox" name="id_aset[]" value="{{ $item->id }}" style="transform: scale(0.8);">
                                            </td>
                                            <td class="text-center">{{ $no }}</td>

                                            <!-- Kode -->
                                            <td><span class="fw-bold text-primary">{{ $item->code ?? '-' }}</span></td>

                                            <!-- NUP -->
                                            <td>{{ $item->nup ?? '-' }}</td>

                                            <!-- Nama Barang (utama) -->
                                            <td>
                                                <div class="fw-bold text-dark">{{ Str::limit($item->name ?? '-', 30) }}</div>
                                            </td>

                                            <!-- Nama Fix (detail kecil di bawah) -->
                                            <td>
                                                <div class="text-muted small" style="font-size: 0.75rem;">
                                                    {{ Str::limit($item->name_fix ?? '-', 25) }}
                                                </div>
                                            </td>

                                            <td>{{ $item->no_seri ?? '-' }}</td>

                                            <td class="text-center">{{ $item->years ?? $item->tahun ?? '-' }}</td>

                                            <td class="text-end">{{ number_format($item->nilai ?? 0, 0, ',', '.') }}</td>

                                            <td class="text-center">
                                                @php
                                                    $cond = $item->condition ?? 'Baik';
                                                    $color = match($cond) {
                                                        'Baik' => 'success',
                                                        'Rusak Ringan' => 'warning',
                                                        default => 'danger',
                                                    };
                                                    $label = $cond === 'Rusak Ringan' ? 'R. Ringan' : ($cond === 'Rusak Berat' ? 'R. Berat' : $cond);
                                                @endphp
                                                <span class="badge rounded-pill bg-{{ $color }} text-white" style="font-size: 0.7rem;">
                                                    {{ $label }}
                                                </span>
                                            </td>

                                            <td>{{ $item->category ?? '-' }}</td>

                                            <td>
                                                @foreach ($locations as $location)
                                                    @if ($location->id == $item->store_location)
                                                        <div style="line-height: 1.1;">
                                                            {{ $location->office ?? '-' }}
                                                            @if($location->floor || $location->room)
                                                                <div class="text-muted small" style="font-size: 0.75rem;">
                                                                    Lt {{ $location->floor }} - R {{ $location->room }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </td>

                                            <td>
                                                @foreach ($employees as $employee)
                                                    @if ($employee->id == $item->supervisor)
                                                        {{ Str::limit($employee->name ?? '-', 20) }}
                                                    @endif
                                                @endforeach
                                            </td>

                                            <td class="text-center small">
                                                {{ $item->last_kalibrasi ? \Carbon\Carbon::parse($item->last_kalibrasi)->format('d M Y') : '-' }}
                                            </td>

                                            <td class="text-center small">
                                                {{ $item->schadule_kalibrasi ? \Carbon\Carbon::parse($item->schadule_kalibrasi)->format('d M Y') : '-' }}
                                            </td>

                                            <td class="text-center">
                                                <span class="badge bg-light text-dark border" style="font-size: 0.7rem;">
                                                    {{ $item->status ?? '-' }}
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <span class="badge bg-secondary text-white" style="font-size: 0.7rem;">
                                                    {{ $item->type ?? '-' }}
                                                </span>
                                            </td>

                                            <td class="text-center">{{ $item->quantity ?? 1 }}</td>
                                            <td class="text-center">{{ $item->satuan ?? '-' }}</td>
                                            <td class="text-center">{{ $item->life_time ?? '-' }}</td>

                                            <!-- DOKUMENTASI: Tampilkan ikon foto jika ada file -->
                                            <td class="text-center">
                                                @if ($item->documentation && file_exists(public_path('uploads/' . $item->documentation)))
                                                    <a href="{{ asset('uploads/' . $item->documentation) }}" target="_blank" title="Lihat Foto/Dokumen">
                                                        <i class="bi bi-image-fill text-primary fs-5"></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>

                                            <!-- AKSI -->
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('asetTetap.edit', $item->id) }}" class="btn btn-light text-warning p-1" title="Edit">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-light text-danger delete-button p-1" data-item-id="{{ $item->id }}" title="Hapus">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @php $no++; @endphp
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </section>

</main>

@include('asetTetap.scane')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/indexaset.js') }}"></script>

<script>
    // --- Logic Lokasi ---
    var gedungSelect = document.getElementById('gedung');
    var lantaiSelect = document.getElementById('lantai');
    var ruanganSelect = document.getElementById('ruangan');

    if(gedungSelect && lantaiSelect && ruanganSelect){
        gedungSelect.addEventListener('change', populateLantaiSelect);
        lantaiSelect.addEventListener('change', populateRuanganSelect);
    }

    function populateLantaiSelect() {
        var selectedGedung = gedungSelect.value;
        lantaiSelect.innerHTML = '<option value="">Lantai</option>';
        var lantaiOptions = getUniqueOptionsByOffice(selectedGedung, 'floor');
        lantaiOptions.forEach(function(option) {
            var opt = document.createElement('option');
            opt.value = option; opt.textContent = option;
            lantaiSelect.appendChild(opt);
        });
        ruanganSelect.innerHTML = '<option value="">Ruangan</option>';
        ruanganSelect.disabled = true;
    }

    function populateRuanganSelect() {
        var selectedLantai = lantaiSelect.value;
        var selectedGedung = gedungSelect.value;
        ruanganSelect.innerHTML = '<option value="">Ruangan</option>';
        var ruanganOptions = getUniqueOptionsByFloor(selectedGedung, selectedLantai, 'room');
        ruanganOptions.forEach(function(option) {
            var opt = document.createElement('option');
            opt.value = option; opt.textContent = option;
            ruanganSelect.appendChild(opt);
        });
    }

    function getUniqueOptionsByOffice(gedung, property) {
        var options = [];
        <?php foreach($locations as $location) { ?>
            if ("<?php echo $location->office; ?>" === gedung && options.indexOf("<?php echo $location->floor; ?>") === -1) {
                options.push("<?php echo $location->floor; ?>");
            }
        <?php } ?>
        return options;
    }

    function getUniqueOptionsByFloor(gedung, lantai, property) {
        var options = [];
        <?php foreach($locations as $location) { ?>
            if ("<?php echo $location->floor; ?>" === lantai && "<?php echo $location->office; ?>" === gedung && options.indexOf("<?php echo $location->room; ?>") === -1) {
                options.push("<?php echo $location->room; ?>");
            }
        <?php } ?>
        return options;
    }

    // --- Logic Tombol Global ---
    function generateQRCodes(url) {
        if ($('input[name="id_aset[]"]:checked').length < 1) {
            Swal.fire('Pilih Data', 'Centang minimal satu aset untuk mencetak QR.', 'info');
            return;
        }
        $('.form-produk').attr('target', '_blank').attr('action', url).submit();
    }

    function multiDelete(url) {
        if ($('input[name="id_aset[]"]:checked').length < 1) {
            Swal.fire('Pilih Data', 'Centang data yang ingin dihapus.', 'info');
            return;
        }
        Swal.fire({
            title: 'Hapus Terpilih?',
            text: "Data yang dicentang akan dihapus permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('.form-produk').attr('action', url).submit();
            }
        })
    }

    function exportAset(url) {
        $('.form-produk').attr('action', url).submit();
    }

    // --- JQUERY UTAMA (Bagian Penting untuk Tombol Hapus) ---
    $(document).ready(function() {
        var csrfToken = document.querySelector('input[name="_token"]').value;

        // PERBAIKAN: Gunakan $(document).on(...) agar tombol tetap bisa diklik meskipun tabel berubah/pagination
        $(document).on('click', '.delete-button', function(e) {
            e.preventDefault(); 
            var itemId = $(this).data('item-id');
            
            Swal.fire({
                title: 'Hapus Item?',
                text: "Data ini tidak bisa dikembalikan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/asetTetap/' + itemId,
                        type: 'DELETE',
                        data: { _token: csrfToken },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus',
                                showConfirmButton: false,
                                timer: 1000
                            }).then(() => { location.reload(); });
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                            Swal.fire('Error', 'Gagal menghapus data. Cek Console.', 'error');
                        }
                    });
                }
            });
        });

        $('#select_all').change(function() {
            $('input[name="id_aset[]"]').prop('checked', this.checked);
        });

        $('input[name="id_aset[]"]').change(function() {
            if ($('input[name="id_aset[]"]:checked').length == $('input[name="id_aset[]"]').length) {
                $('#select_all').prop('checked', true);
            } else {
                $('#select_all').prop('checked', false);
            }
        });

        $('#filterButton').click(function(e) {
            e.preventDefault();
            $('#filterFields').slideToggle();
        });
    });
</script>

@endsection