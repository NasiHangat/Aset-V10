<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
    <body>
        <div class="container">
            <table class="table table-bordered">
                {{-- @php
                    $no = 1;
                    $count = 11;
                    $halaman = 1;
                    $sum = 0;
                    $previousCode = null;
                    $previousName = null;
                    $baik = 0;
                    $ringan = 0;
                    $berat = 0;
                    @endphp --}}
              @include('asetTetap.excelHeader')
              @foreach ($asets as $aset)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td style="text-align: center;">{{ $aset->code }}</td>
                    <td style="text-align: center;">{{ $aset->nup }}</td>
                    <td style="text-align: center;">{{ $aset->name }}</td>
                    <td style="text-align: center;">{{ $aset->name_fix }}</td>
                    <td style="text-align: center;">Rp{{ number_format($aset->nilai, 0, ',', '.') }}</td>
                    {{-- <td style="text-align: center;">{{ $aset->nilai }}</td> --}}
                    <td style="text-align: center;">{{ $aset->years }}</td>
                    <td style="text-align: center;">
                        @foreach ($locations as $location)
                            @if ($location->id == $aset->store_location)
                                @if ($location->floor == 0 && $location->room == 0)
                                    {{ $location->office }}
                                @else
                                    {{ $location->office }} - Lt {{ $location->floor }} - R {{ $location->room }}
                                @endif
                            @endif
                        @endforeach
                    </td>
                    <td style="text-align: center;">{{ $aset->condition }}</td>
                    <td style="text-align: center;">
                        @foreach ($employees as $employe)
                            @if ($employe->id == $aset->supervisor)
                                {{ $employe->name }}
                            @endif
                        @endforeach
                    </td>
                    <td style="text-align: center;">{{ $aset->documentation }}</td>
                    <td style="text-align: center;">{{ $aset->description }}</td>
                    <td style="text-align: center;">{{ $aset->bulan }}</td>
              @endforeach
            </table>
          </div>
    </body>
</html>
