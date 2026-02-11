@extends('layouts.app')
@section('content')

<style>
    .input-group .search-input {
        border-right: none;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .input-group .search-btn {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
</style>

<div id="location-data" data-locations="{{ json_encode($locations) }}"></div>

<main id="main" class="main">
    <div class="card mt-4">
        <div class="card-header">
            <div class="col-md-12 mb-3">
                <div class="row justify-content-center"> <!-- Add 'justify-content-center' class to center-align the row -->
                    <div class="col-md-6 text-center"> <!-- Replace 'text-right' with 'text-center' to center-align the form -->
                        <form action="{{ route('asetTetap.search') }}" method="POST" class="form-inline">
                            @csrf
                            <div class="input-group">
                                <input type="text" name="query" class="form-control" placeholder="Search" aria-label="Search" value="{{ request()->input('query') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary search-btn" type="submit"><i class="bi bi-search"></i></button>
                                    <a href="#" class="btn btn-outline-primary filter-btn" id="filterButton"><i class="bi bi-filter"></i></a>
                                    <a href="#!" data-bs-toggle="modal" data-bs-target="#ModalAdd" style="float: right;">
                                        <button type="button" class="btn btn-outline-primary"><i class="bi bi-qr-code"></i></button>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div id="filterFields" style="display: {{ request()->is('asetTetap/filter') ? ' block' : 'none' }};" class="form-inline mt-2">
                <div class="card-body">
                    @include('asetTetap.filter')
                </div>    {{-- end of card body --}}
            </div>
        </div>
    </div>


    {{--card--}}
    <div class="card mt-4">
        <div class="card mt-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="h4 fw-bold">DATA ASET</h3>
                    </div>
                    <div class="col-md-6 text-end">
                        <a href="{{ route('asetTetap.create') }}">
                            <button type="button" class="btn btn-success"><i class="bi bi-plus-square-fill" style="font-size: 14px"></i> Add</button>
                        </a>
                        <a href="{{ route('asetTetap.import') }}">
                            <button type="button" class="btn btn-success"><i class="bi bi-upload" style="font-size: 14px"></i> Import</button>
                        </a>


                        <button onclick="exportAset('{{ route('asetTetap.export') }}')" class="btn btn-primary btn-xs btn-flat"><i class="bi bi-download"></i> Export</button>
                        <button onclick="multiDelete('{{ route('asetTetap.multiDelete') }}')" class="btn btn-danger btn-xs btn-flat"><i class="bi bi-trash"></i> Hapus</button>
                        <button onclick="generateQRCodes('{{ route('generate_qrcodes') }}')" class="btn btn-info btn-xs btn-flat"><i class="bi bi-qr-code"></i> Cetak QrCode</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body mt-4">
            <div class="table-responsive" style="height: 500px; overflow-y: auto;">
                <!-- Default Table -->
                <form action="" method="post" class="form-produk">
                    @csrf
                    <table class="table table-bordered">
                        <thead style="position: sticky; top: 0; background-color: #f4f8fb;">
                            <tr>
                                <th width="5%">
                                    <input type="checkbox" name="select_all" id="select_all">
                                </th>
                                <th scope="col">No</th>
                                <th scope="col">Kode Barang</th>
                                <th scope="col">NUP</th>
                                <th scope="col">Merk</th>
                                <th scope="col">Koreksi Nama</th>
                                <th scope="col">Nilai</th>
                                {{-- <th scope="col">Kuantitas</th> --}}
                                <th scope="col">Tahun</th>
                                <th scope="col">Lokasi</th>
                                <th scope="col">Kondisi</th>
                                <th scope="col">Penanggung Jawab</th>
                                <th scope="col">Dokumentasi</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Kalibrasi oleh</th>
                                <th scope="col">Terakhir Kalibrasi</th>
                                <th scope="col">Jadwal Kalibrasi</th>
                                <th scope="col">Jenis Aset</th>
                                <th scope="col">Input pada</th>
                                <th scope="col">Status</th>
                                <th scope="col">Teregistrasi</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody style="background-color: #f4f8fb">
                            @php
                                $no =1 ;
                            @endphp
                            @foreach ($items as $item)
                                @if ($item->status !== "Diserahkan")

                                <tr data-item-id="{{ $item->id }}">
                                    <td>
                                        <input type="checkbox" name="id_aset[]" value="{{ $item->id }}">
                                    </td>
                                    <td>{{ $no }}</td>
                                    <td>{{ $item->code }}</td>
                                    <td>{{ $item->nup }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->name_fix }}</td>
                                    <td>{{ number_format($item->nilai, 0, ',', '.') }}</td>
                                    <td>{{ $item->years }}</td>
                                    <td>
                                        @foreach ($locations as $location)
                                            @if ($location->id == $item->store_location)
                                                @if ($location->floor == 0 && $location->room == 0)
                                                    {{ $location->office }}
                                                @else
                                                    {{ $location->office }} - Lt {{ $location->floor }} - R {{ $location->room }}
                                                @endif
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="badge text-wrap" style="width: 6rem; background-color: {{ $item->condition === 'Baik' ? '#59beda' : ($item->condition === 'Rusak Ringan' ? '#FFA726' : '#f05050') }};
                                            ; color: #ffffff">
                                            {{ $item->condition }}
                                        </div>
                                    </td>
                                    <td>
                                        @foreach ($employees as $employe)
                                            @if ($employe->id == $item->supervisor)
                                                {{ $employe->name }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @if ($item->documentation)
                                            <a href="{{ asset('uploads/' . $item->documentation) }}" download>
                                                <img src="{{ asset('uploads/' . $item->documentation) }}" alt="" style="max-width: 100px; max-height: 100px;">
                                            </a>
                                            {{-- <img src="uploads/{{ $item->documentation }}" alt="" style="max-width: 100px; max-height: 100px;"> --}}
                                        @endif
                                    </td>
                                    <td>{{ $item->description }}</td>

                                    {{-- <td>{{ $item->quantity }}</td> --}}
                                    {{-- <td>{{ $item->specification }}</td> --}}
                                    {{-- <td>
                                        @foreach ($categories as $category)
                                            @if ($category->id == $item->category)
                                                {{ $category->name }}
                                            @endif
                                        @endforeach
                                    </td> --}}
                                    <td>{{ $item->kalibrasi_by }}</td>
                                    <td>{{ $item->last_kalibrasi }}</td>
                                    <td>{{ $item->schadule_kalibrasi }}</td>
                                    <td>
                                        <div class="badge text-wrap" style="width: 6rem; background-color: {{ $item->type === 'Bergerak' ? '#0a3622' : '#479f76' }};
                                            ;
                                            ; color: #ffffff">
                                            {{ $item->type }}
                                        </div>
                                    </td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>{{ $item->registered }}</td>
                                    <td>
                                        <div class="d-inline-flex">
                                            {{--<a href="/asetTetap/{{ $item->id }}/edit" class="badge bg-warning text-dark" style="text-decoration: none;"><i class="bi bi-pencil"></i></a>--}}
                                            <a href="{{ route('asetTetap.edit', $item->id) }}" class="badge bg-warning text-dark" style="text-decoration: none;"><i class="bi bi-pencil"></i></a>
                                            <button type="button" class="badge bg-danger ml-2 delete-button" style="text-decoration: none;" data-item-id="{{ $item->id }}"><i class="bi bi-trash"></i></button>
                                        </div>
                                    </td>


                                </tr>

                                @php
                                    $no++;
                                @endphp
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </form>
            <!-- End Default Table Example -->

            {{-- Pagination --}}
            {{-- <div class="d-flex justify-content-center">
                {{ $items->links() }}
            </div> --}}
            {{-- End Pagination --}}
            </div>
        </div>
    </div>
    {{--endcard--}}
</div>
</main>

@include('asetTetap.scane')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/indexaset.js') }}"></script>
{{-- <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script> --}}
<script>



    // ================= scanning

    // ================== end scanning

        function generateQRCodes(url) {
            var csrfToken = document.querySelector('input[name="_token"]').value;
            if ($('input:checked').length < 1) {
                alert('Pilih data yang akan dicetak');
                return;
            }
            // else if ($('input:checked').length < 3) {
            //     alert('Pilih minimal 3 data untuk dicetak');
            //     return;
            // }
             else {
                $('.form-produk')
                    .attr('target', '_blank')
                    .attr('action', url)
                    .submit();
            }
        }

        function multiDelete(url) {
            var csrfToken = document.querySelector('input[name="_token"]').value;
            if ($('input:checked').length < 1) {
                alert('Pilih data yang akan dihapus');
                return;
            } else {
                alert('Yakin ingin menghapus ?');
                $('.form-produk')
                    .attr('action', url)
                    .submit();
            }
        }

        function exportAset(url) {
            var csrfToken = document.querySelector('input[name="_token"]').value;
            if ($('input:checked').length < 1) {
                alert('Pilih data yang akan diexport');
                return;
            } else {
                $('.form-produk')
                    .attr('action', url)
                    .submit();
            }
        }

     // JavaScript
    $(document).ready(function() {
        var csrfToken = document.querySelector('input[name="_token"]').value;

        $('.delete-button').on('click', function() {
            var itemId = $(this).data('item-id');

            Swal.fire({
                title: 'Confirmation',
                text: 'Are you sure you want to delete this item?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/asetTetap/' + itemId,
                        type: 'DELETE',
                        data: {
                            _token: csrfToken // Make sure csrfToken is defined and accessible in this context
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Success',
                                text: '{{ session('success') }}',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location.href = "{{ route('asetTetap.index') }}";
                            });
                        },
                        error: function(xhr, status, error) {
                            // Handle error if needed
                            console.error(error);
                        }
                    });
                }
            });
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        // Get the "select all" checkbox element
        var selectAllCheckbox = document.getElementById('select_all');

        // Get all the individual checkboxes
        var checkboxes = document.querySelectorAll('input[name="id_aset[]"]');

        // Add an event listener to the "select all" checkbox
        selectAllCheckbox.addEventListener('change', function() {
            // Iterate over each checkbox
            checkboxes.forEach(function(checkbox) {
                // Set the checked property of each checkbox to match the "select all" checkbox
                checkbox.checked = selectAllCheckbox.checked;
            });
        });

        // Add an event listener to each individual checkbox
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                // If any checkbox is unchecked, uncheck the "select all" checkbox
                if (!checkbox.checked) {
                    selectAllCheckbox.checked = false;
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {

        document.addEventListener('DOMContentLoaded', function() {
            // Get the "select all" checkbox element
            var selectAllCheckbox = document.getElementById('select_all');

            // Get all the individual checkboxes
            var checkboxes = document.querySelectorAll('input[name="id_aset"]');

            // Add an event listener to the "select all" checkbox
            selectAllCheckbox.addEventListener('change', function() {
                // Iterate over each checkbox
                checkboxes.forEach(function(checkbox) {
                    // Set the checked property of each checkbox to match the "select all" checkbox
                    checkbox.checked = selectAllCheckbox.checked;
                });
            });
        });

        //============ delete
        const deleteButtons = document.querySelectorAll('.delete-button');

        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                const formId = this.getAttribute('data-form-id');

                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Anda yakin ingin menghapus data ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(formId).submit();
                    }
                });
            });
        });
    });

    // =============== lokasi
    // Get the select elements
    var gedungSelect = document.getElementById('gedung');
    var lantaiSelect = document.getElementById('lantai');
    var ruanganSelect = document.getElementById('ruangan');

    // Add event listeners to the select elements
    gedungSelect.addEventListener('change', populateLantaiSelect);
    lantaiSelect.addEventListener('change', populateRuanganSelect);

    // Function to populate the lantai select element based on the selected gedung
    function populateLantaiSelect() {
    var selectedGedung = gedungSelect.value;

    // Clear previous options
    lantaiSelect.innerHTML = '<option value="">Lantai</option>';


    // Populate lantai options based on the selected gedung
    var lantaiOptions = getUniqueOptionsByOffice(selectedGedung, 'floor');
    lantaiOptions.forEach(function(option) {
        var optionElement = document.createElement('option');
        optionElement.value = option;
        optionElement.textContent = option;
        lantaiSelect.appendChild(optionElement);
    });


    // Reset and disable the ruangan select element
    ruanganSelect.innerHTML = '<option value="">Ruangan</option>';
    ruanganSelect.disabled = true;
    }

    // Function to populate the ruangan select element based on the selected lantai
    function populateRuanganSelect() {
    var selectedLantai = lantaiSelect.value;
    var selectedGedung = gedungSelect.value;

    // Clear previous options
    ruanganSelect.innerHTML = '<option value="">Ruangan</option>';

    // Populate ruangan options based on the selected lantai
    var ruanganOptions = getUniqueOptionsByFloor(selectedGedung, selectedLantai, 'room');
    ruanganOptions.forEach(function(option) {
        var optionElement = document.createElement('option');
        optionElement.value = option;
        optionElement.textContent = option;
        ruanganSelect.appendChild(optionElement);
    });

    }

    // Helper function to get unique options from the $locations array based on the given property
    function getUniqueOptionsByOffice(gedung, property) {
    var options = [];
        <?php foreach($locations as $location) { ?>
            if ("<?php echo $location->office; ?>" === gedung && options.indexOf("<?php echo $location->floor; ?>") === -1) {
            options.push("<?php echo $location->floor; ?>");
            }
        <?php } ?>
        return options;
    }

    // Helper function to get unique options from the $locations array based on the given property
    function getUniqueOptionsByFloor(gedung, lantai, property) {
        var options = [];
        <?php foreach($locations as $location) { ?>
            if ("<?php echo $location->floor; ?>" === lantai && "<?php echo $location->office; ?>" === gedung && options.indexOf("<?php echo $location->room; ?>") === -1) {
            options.push("<?php echo $location->room; ?>");
            }
        <?php } ?>
        return options;
    }

</script>



@endsection
