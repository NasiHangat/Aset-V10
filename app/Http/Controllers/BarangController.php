<?php

namespace App\Http\Controllers;

use App\Exports\AsetListExport;
use App\Models\Materials;
use App\Models\locations;
use App\Models\employee;
use App\Models\Category;
use App\Models\users;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AsetImport;
use Carbon\Exceptions\InvalidFormatException as ExceptionsInvalidFormatException;
use Exception;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Validation\ValidationException;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception as ReaderException;
use PhpOffice\PhpSpreadsheet\Reader\InvalidFormatException;

class BarangController extends Controller
{
    public function index()
    {
        $locations = DB::table('locations')->get();
        $categories = DB::table('categories')->get();
        $employees = DB::table('employees')->get();
        $items = DB::table('materials')->get();
        $tahun = DB::table('materials')->get();



        return view('asetTetap.index', compact('items', 'locations', 'employees', 'categories', 'tahun'));
    }

    public function create()
    {
        $locations = DB::table('locations')->get();
        $categories = DB::table('categories')->get();
        $employees = DB::table('employees')->get();
        // Retrieve unique values from the "office" column
        $gedungOptions = DB::table('locations')->distinct('office')->pluck('office');

        // Retrieve unique values from the "floor" column
        $lantaiOptions = DB::table('locations')->distinct('floor')->pluck('floor');

        return view('asetTetap.create', [
            'locations' => $locations,
            'employees' => $employees,
            'categories' => $categories,
            'gedungOptions' => $gedungOptions,
            'lantaiOptions' => $lantaiOptions,
        ]);
    }

    public function store(Request $request)
    {
        $office = $request->input('gedung');
        $floor = $request->input('lantai');
        $room = $request->input('ruangan');
        // dd($office, $floor, $room);
        $locationId = DB::table('locations')
            ->where('office', $office)
            ->where('floor', $floor)
            ->where('room', $room)
            ->value('id');

        $material = new Materials();
        // $material->id = int::uuid();
        $material->code = $request->input('kode_barang');
        $material->nup = $request->input('nup');
        $material->name = $request->input('nama_barang');
        $material->name_fix = $request->input('merk');
        $material->no_seri = $request->input('no_seri');
        $material->category = $request->input('category');
        $material->nilai = $request->input('nilai');
        $material->status = 'Tidak Dipakai';
        $material->years = $request->input('tahun');
        $material->bulan = $request->input('bulan') ?? date('n');
        // $material->quantity = $request->input('quantity');
        $material->satuan = $request->input('satuan');
        $material->store_location = $locationId;
        $material->life_time = $request->input('expiry_date');
        $material->specification = $request->input('spek');
        $material->condition = $request->input('kondisi');
        $material->supervisor = $request->input('supervisor');
        if ($request->hasFile('dokumentasi')) {
            $image = $request->file('dokumentasi');
            $filename = $image->getClientOriginalName();
            $destination = public_path('uploads');
            $image->move($destination, $filename);
            $material->documentation = $filename;
        }
        $material->description = $request->input('keterangan');
        $material->type = $request->input('type');
        $dikalibrasi = $request->input('dikalibrasi') !== null && $request->input('dikalibrasi') === '1' ? 1 : 0;
        $material->dikalibrasi = $dikalibrasi;
        $material->kalibrasi_by = $request->input('kalibrasi_by');
        $material->last_kalibrasi = $request->input('last_kalibrasi');
        $material->schadule_kalibrasi = $request->input('schedule_kalibrasi');
        $material->save();

        return redirect('/asetTetap');
    }

    public function edit($id)
    {
        $item = Materials::find($id);
        $employees = DB::table('employees')->get();
        $locations = DB::table('locations')->get();
        $locations = DB::table('locations')->get();
        $categories = DB::table('categories')->get();

        $prevLocation = DB::table('locations')->where('id', $item->store_location)->first();

        // Retrieve unique values from the "office" column
        $gedungOptions = DB::table('locations')->distinct('office')->pluck('office');

        // Retrieve unique values from the "floor" column
        $lantaiOptions = DB::table('locations')->distinct('floor')->pluck('floor');

        return view('asetTetap.edit', [
            'item' => $item,
            'locations' => $locations,
            'employees' => $employees,
            'gedungOptions' => $gedungOptions,
            'lantaiOptions' => $lantaiOptions,
            'prevLocation' => $prevLocation,
            'categories' => $categories,
        ]);
    }

public function update(Request $request, $id)
            
{
    $office = $request->input('gedung');
    $floor  = $request->input('lantai');
    $room   = $request->input('ruangan');

    $locationId = DB::table('locations')
        ->where('office', $office)
        ->where('floor', $floor)
        ->where('room', $room)
        ->value('id');

    $material = Materials::findOrFail($id);

    $material->code              = $request->input('code');        
    $material->nup               = $request->input('nup');
    $material->name              = $request->input('name');
    $material->name_fix          = $request->input('name_fix');
    $material->no_seri           = $request->input('no_seri');
    $material->category          = $request->input('category');
    $material->nilai             = $request->input('nilai');
    $material->years             = $request->input('years');
    $material->satuan            = $request->input('satuan');
    $material->store_location    = $locationId;
    $material->status            = $request->input('status');
    $material->life_time         = $request->input('life_time');
    $material->specification     = $request->input('specification');
    $material->condition         = $request->input('condition');
    $material->supervisor        = $request->input('supervisor');
    $material->description       = $request->input('description');
    $material->type              = $request->input('type');

    if ($request->hasFile('documentation')) {
        $image = $request->file('documentation');
        $filename = time() . '_' . $image->getClientOriginalName(); 
        $destination = public_path('uploads');
        $image->move($destination, $filename);
        $material->documentation = $filename;
    }

    $material->dikalibrasi       = $request->has('dikalibrasi') ? 1 : 0;
    $material->kalibrasi_by      = $request->input('kalibrasi_by');
    $material->last_kalibrasi    = $request->input('last_kalibrasi');
    $material->schadule_kalibrasi = $request->input('schadule_kalibrasi');

    $material->save();

    return redirect('/asetTetap')->with('success', 'Data aset berhasil diperbarui');

    }


    public function destroy($id)
    {
        $material = Materials::findOrFail($id);
        $filename = $material->documentation;

        // Delete the image file if it exists
        if (!empty($filename)) {
            $destination = public_path('uploads/' . $filename);
            if (file_exists($destination)) {
                unlink($destination);
            }
        }

        // Delete the Materials record
        $material->delete();

        return response()->json(['message' => 'Data deleted successfully']);
    }


    public function multiDelete(Request $request)
    {
        // Delete the selected items
        foreach ($request->id_aset as $id) {
            $material = Materials::findOrFail($id);
            $filename = $material->documentation;

            // Delete the image file if it exists
            if (!empty($filename)) {
                $destination = public_path('uploads/' . $filename);
                if (file_exists($destination)) {
                    unlink($destination);
                }
            }

            // Delete the Materials record
            $material->delete();
        }

        return redirect()->route('asetTetap.index')->with('success', 'Data deleted successfully');
    }



    // public function show(Request $request)
    // {
    //     $ids = $request->query('ids');
    //     $selectedIds = json_decode($ids, true);

    //     return view('asetTetap.qrcode')->with('selectedIds', $selectedIds);;
    // }


    // check Code
    // public function checkCodeExists(Request $request)
    // {
    //     $kodeBarang = $request->input('kode_barang');
    //     $oldKodeBarang = $request->input('old_kode_barang');

    //     if ($oldKodeBarang) {
    //         // Edit form - check if the code already exists in the database and has different values than the old value
    //         $exists = Materials::where('code', $kodeBarang)
    //             ->where('code', '!=', $oldKodeBarang)
    //             ->exists();
    //     } else {
    //         // Add form - check if the code already exists in the database
    //         $exists = Materials::where('code', $kodeBarang)->exists();
    //     }

    //     if ($exists) {
    //         return response()->json(['message' => 'Code already exists or has different values'], 400);
    //     }

    //     return response()->json(['message' => 'Code is valid'], 200);
    // }

    // =========== check nup
    public function checkNupExists(Request $request)
{
    $nup = $request->input('nup');
    $code = $request->input('code');
    $oldNup = $request->input('old_nup');

    if ($oldNup) {
        // Edit form - check if the NUP already exists in the database and has different values than the old value
        if($nup !== $oldNup){
            $exists = Materials::where('nup', $nup)
                // ->where('nup', '!=', $oldNup)
                ->where('code', $code)
                ->exists();
        }
    } else {
        // Add form - check if the NUP already exists in the database
        $exists = Materials::where('nup', $nup)
            ->where('code', $code)
            ->exists();
    }

    if ($exists) {
        return response()->json(['message' => 'NUP with code '. $code . 'already exists or has different values'], 400);
    }

    return response()->json(['message' => 'NUP is valid'], 200);
}



    public function checkNoSeriExists(Request $request)
    {
        $noSeri = $request->input('no_seri');
        $oldNoSeri = $request->input('old_no_seri');

        if ($oldNoSeri) {
            // Edit form - check if the code already exists in the database and has different values than the old value
            $exists = Materials::where('no_seri', $noSeri)
                ->where('no_seri', '!=', $oldNoSeri)
                ->exists();
        } else {
            // Add form - check if the code already exists in the database
            $exists = Materials::where('no_seri', $noSeri)->exists();
        }

        if ($exists) {
            return response()->json(['message' => 'No Seri already exists or has different values'], 400);
        }

        return response()->json(['message' => 'No Seri valid'], 200);
    }


    public function search(Request $request)
    {
        $locations = DB::table('locations')->get();
        $categories = DB::table('categories')->get();
        $employees = DB::table('employees')->get();
        $tahun = DB::table('materials')->get();
        $query = $request->input('query');


        $items = Materials::where('code', 'LIKE', '%' . $query . '%')
            ->orWhere('nup', 'LIKE', '%' . $query . '%')
            ->orWhere('name', 'LIKE', '%' . $query . '%')
            ->orWhere('name_fix', 'LIKE', '%' . $query . '%')
            ->orWhere('years', 'LIKE', '%' . $query . '%')
            ->get();

        return view('asetTetap.index', compact('items', 'locations', 'employees', 'categories', 'tahun'));
    }

    public function filter(Request $request)
    {
        $locations = DB::table('locations')->get();
        $categories = DB::table('categories')->get();
        $employees = DB::table('employees')->get();
        $tahun = DB::table('materials')->get();

        $query = DB::table('materials');

        $type = $request->input('type');
        if ($type !== 'all') {
            $query->where('type', $type);
        }

        $category = $request->input('category');
        if ($category !== 'all') {
            $query->where('category', $category);
        }

        $years_from = $request->input('years_from');
        if ($years_from !== 'dari') {
            $query->where('years', '>=', $years_from);
        }

        $years_till = $request->input('years_till');
        if ($years_till !== 'sampai') {
            $query->where('years', '<=', $years_till);
        }

        $office = $request->input('gedung');
        $floor = $request->input('lantai');
        $room = $request->input('ruangan');

        if ($office || $floor || $room) {
            $query->whereIn('store_location', function ($query) use ($office, $floor, $room) {
                $query->select('id')
                    ->from('locations')
                    ->where('office', $office);

                if ($floor) {
                    $query->where('floor', $floor);
                }

                if ($room) {
                    $query->where('room', $room);
                }
            });
        }

        $condition = $request->input('condition');
        if ($condition !== 'all') {
            $query->where('condition', $condition);
        }

        $supervisor = $request->input('supervisor');
        if ($supervisor !== 'all') {
            $query->where('supervisor', $supervisor);
        }

        $calibrated = $request->input('calibrate');
        if ($calibrated !== 'all') {
            $query->where('dikalibrasi', $calibrated);
        }

        $items = $query->get();

        return view('asetTetap.index', compact('items', 'locations', 'employees', 'categories', 'tahun'));
    }

    public function import()
    {
        return view('asetTetap.import-file');
    }

    public function importStore(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xls,xlsx',
    ]);

    try {
        $file = $request->file('file');

        // Load the Excel file using PhpSpreadsheet
        $spreadsheet = IOFactory::load($file);

        // Get the first worksheet
        $worksheet = $spreadsheet->getActiveSheet();

        // Get the value of the first cell in the first row
        $cellValue = $worksheet->getCellByColumnAndRow(1, 1)->getValue();

        // Check if the header value matches the expected header
        $expectedHeader = 'DATA MASTER BMN BALAI SAINS BANGUNAN'; // Replace with your expected header

        if ($cellValue !== $expectedHeader) {
            throw ValidationException::withMessages([
                'file' => 'Invalid Excel layout. The header must be: ' . $expectedHeader,
            ]);
        }
        // If the header is valid, proceed with the import
        Excel::import(new AsetImport, $file);

        return back()->withStatus('Import Berhasil');
    } catch (ValidationException $e) {
        // Handle the validation exception, which occurs when the header is not as expected
        return back()->withErrors($e->validator->errors());
    } catch (ReaderException $e) {
        // Handle the PhpOffice\PhpSpreadsheet\Reader\Exception, which occurs if there's an issue with loading the Excel file
        return back()->withErrors(['file' => 'Error loading the Excel file. Please check the file and try again.']);
    } catch (ExceptionsInvalidFormatException $e) {
        // Handle the PhpOffice\PhpSpreadsheet\Reader\InvalidFormatException, which occurs if the file format is not valid
        return back()->withErrors(['file' => 'Invalid file format. Please upload a valid Excel file.']);
    } catch (Exception $e) {
        error_log("Error processing Excel file: " . $e->getMessage() . " in " . $e->getFile() . " at line " . $e->getLine());

    // Provide a more informative user-friendly message
    return back()->withErrors(['file' => 'There was a problem processing the Excel file: ' . $e->getMessage() . '. Please double-check the file and try again. If the issue persists, please contact support.']);
    }




}


    public function export(Request $request)
    {
        $selectedAsets = $request->input('id_aset', []);
        return Excel::download(new AsetExportInternal($selectedAsets), 'DataAset.xlsx');
    }
}
