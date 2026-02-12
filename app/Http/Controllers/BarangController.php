<?php

namespace App\Http\Controllers;

// --- 1. IMPORT LIBRARY (Jangan Dihapus) ---
use App\Models\Materials;
use App\Models\locations;
use App\Models\employee;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\AsetImport;
use Illuminate\Validation\ValidationException;
use Exception;

// Library Excel Wajib
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
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
        
        $gedungOptions = DB::table('locations')->distinct('office')->pluck('office');
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
        
        $locationId = DB::table('locations')
            ->where('office', $office)
            ->where('floor', $floor)
            ->where('room', $room)
            ->value('id');

        $material = new Materials();
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
        $categories = DB::table('categories')->get();

        $prevLocation = DB::table('locations')->where('id', $item->store_location)->first();

        $gedungOptions = DB::table('locations')->distinct('office')->pluck('office');
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
        $floor = $request->input('lantai');
        $room = $request->input('ruangan');
        $locationId = DB::table('locations')
            ->where('office', $office)
            ->where('floor', $floor)
            ->where('room', $room)
            ->value('id');

        $material = Materials::find($id);
        $material->code = $request->input('kode_barang');
        $material->nup = $request->input('nup');
        $material->name = $request->input('nama_barang');
        $material->name_fix = $request->input('koreksi_nama');
        $material->no_seri = $request->input('no_seri');
        $material->category = $request->input('category');
        $material->nilai = $request->input('nilai');
        $material->years = $request->input('tahun');
        $material->satuan = $request->input('satuan');
        $material->store_location = $locationId;
        $material->status = $request->input('status');
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

    public function destroy($id)
    {
        $material = Materials::findOrFail($id);
        $filename = $material->documentation;

        if (!empty($filename)) {
            $destination = public_path('uploads/' . $filename);
            if (file_exists($destination)) {
                unlink($destination);
            }
        }
        $material->delete();

        return response()->json(['message' => 'Data deleted successfully']);
    }

    public function multiDelete(Request $request)
    {
        foreach ($request->id_aset as $id) {
            $material = Materials::findOrFail($id);
            $filename = $material->documentation;

            if (!empty($filename)) {
                $destination = public_path('uploads/' . $filename);
                if (file_exists($destination)) {
                    unlink($destination);
                }
            }
            $material->delete();
        }

        return redirect()->route('asetTetap.index')->with('success', 'Data deleted successfully');
    }

    public function checkNupExists(Request $request)
    {
        $nup = $request->input('nup');
        $code = $request->input('code');
        $oldNup = $request->input('old_nup');

        if ($oldNup) {
            if($nup !== $oldNup){
                $exists = Materials::where('nup', $nup)->where('code', $code)->exists();
            } else {
                $exists = false;
            }
        } else {
            $exists = Materials::where('nup', $nup)->where('code', $code)->exists();
        }

        if ($exists) {
            return response()->json(['message' => 'NUP with code '. $code . 'already exists'], 400);
        }
        return response()->json(['message' => 'NUP is valid'], 200);
    }

    public function checkNoSeriExists(Request $request)
    {
        $noSeri = $request->input('no_seri');
        $oldNoSeri = $request->input('old_no_seri');

        if ($oldNoSeri) {
            $exists = Materials::where('no_seri', $noSeri)->where('no_seri', '!=', $oldNoSeri)->exists();
        } else {
            $exists = Materials::where('no_seri', $noSeri)->exists();
        }

        if ($exists) {
            return response()->json(['message' => 'No Seri already exists'], 400);
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
        if ($type !== 'all') { $query->where('type', $type); }

        $category = $request->input('category');
        if ($category !== 'all') { $query->where('category', $category); }

        $years_from = $request->input('years_from');
        if ($years_from !== 'dari') { $query->where('years', '>=', $years_from); }

        $years_till = $request->input('years_till');
        if ($years_till !== 'sampai') { $query->where('years', '<=', $years_till); }

        $office = $request->input('gedung');
        $floor = $request->input('lantai');
        $room = $request->input('ruangan');

        if ($office || $floor || $room) {
            $query->whereIn('store_location', function ($query) use ($office, $floor, $room) {
                $query->select('id')->from('locations')->where('office', $office);
                if ($floor) { $query->where('floor', $floor); }
                if ($room) { $query->where('room', $room); }
            });
        }

        $condition = $request->input('condition');
        if ($condition !== 'all') { $query->where('condition', $condition); }

        $supervisor = $request->input('supervisor');
        if ($supervisor !== 'all') { $query->where('supervisor', $supervisor); }

        $calibrated = $request->input('calibrate');
        if ($calibrated !== 'all') { $query->where('dikalibrasi', $calibrated); }

        $items = $query->get();

        return view('asetTetap.index', compact('items', 'locations', 'employees', 'categories', 'tahun'));
    }

    public function import()
    {
        return view('asetTetap.import-file');
    }

    public function importStore(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xls,xlsx']);

        try {
            $file = $request->file('file');
            $spreadsheet = IOFactory::load($file);
            $worksheet = $spreadsheet->getActiveSheet();
            $cellValue = $worksheet->getCellByColumnAndRow(1, 1)->getValue();
            $expectedHeader = 'DATA MASTER BMN BALAI SAINS BANGUNAN'; 

            if ($cellValue !== $expectedHeader) {
                throw ValidationException::withMessages([
                    'file' => 'Invalid Excel layout. Header must be: ' . $expectedHeader,
                ]);
            }
            Excel::import(new AsetImport, $file);
            return back()->withStatus('Import Berhasil');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors());
        } catch (Exception $e) {
            return back()->withErrors(['file' => 'Problem processing file: ' . $e->getMessage()]);
        }
    }

    // --- FUNGSI EXPORT ---
    public function export(Request $request)
    {
        $selectedAsets = $request->input('id_aset', []);
        // Ini memanggil Class AsetExportInternal yang ada di bawah file ini
        return Excel::download(new AsetExportInternal($selectedAsets), 'DataAset.xlsx');
    }

} // <--- BATAS CLASS BARANG CONTROLLER (Hanya boleh ada SATU kurung tutup di sini)


// =========================================================================
// CLASS INTERNAL UTK EXPORT (DITARUH DI LUAR CONTROLLER, DI PALING BAWAH)
// =========================================================================

class AsetExportInternal implements FromView, ShouldAutoSize, WithStyles
{
    protected $selectedAsets;

    public function __construct($selectedAsets)
    {
        $this->selectedAsets = $selectedAsets;
    }

    public function view(): View
    {
        // Jika ada ID yang dipilih (dicentang), ambil ID itu saja.
        if (!empty($this->selectedAsets)) {
            $data = Materials::whereIn('id', $this->selectedAsets)->get();
        } else {
            // Jika tidak ada yang dicentang, download SEMUA data.
            $data = Materials::all();
        }

        // Kirim data ke view export
        return view('asetTetap.export-file', [
            'asets' => $data,
            'locations' => locations::all(),
            'employees' => employee::all()
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Bold Header Baris 1
        ];
    }
}