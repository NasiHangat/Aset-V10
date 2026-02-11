<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Materials;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
	public function index()
	{
		return view('home');
	}

	public function chart()
	{
		// Kode Untuk Chart Habis Pakai
		//$countATK = Items::where('categories', 'ATK')->count();
		$countATK = Items::where('categories', 'ATK')
                 ->where('saldo', '>', 0)
                 ->count();
		$countRT = Items::where('categories', 'Rumah Tangga')
				->where('saldo', '>', 0)
				->count();
		$countLab = Items::where('categories', 'Laboratorium')
				->where('saldo', '>', 0)
				->count();

		//dd($countATK);
		$quantityATK = Items::where('categories', 'ATK')
			->select(DB::raw("CAST($countATK as signed) as saldo"))
			->groupBy(DB::raw("MONTH(created_at)"))
			->pluck('saldo');
		//$quantityATK = Items::where('categories', 'ATK')
		//	->whereNotNull('saldo') // Hanya ambil data dengan nilai pada kolom saldo
		//	->select(DB::raw("SUM(CAST(saldo as signed)) as total_saldo"))
		//	->groupBy(DB::raw("MONTH(created_at)"))
		//	->pluck('total_saldo');


		$quantityRT = Items::where('categories', 'Rumah Tangga')
			->select(DB::raw("CAST($countRT as signed) as saldo"))
			->groupBy(DB::raw("MONTH(created_at)"))
			->pluck('saldo');

		$quantityLab = Items::where('categories', 'Laboratorium')
			->select(DB::raw("CAST($countLab as signed) as saldo"))
			->groupBy(DB::raw("MONTH(created_at)"))
			->pluck('saldo');

		$bulan1 = Items::select(DB::raw("MONTHNAME(created_at) as bulan"))
		->GroupBy(DB::raw("MONTHNAME(created_at)"))
		->pluck('bulan');

		// Kode Untuk Chart Aset
		$countTetap = Materials::where('type', 'Tetap')->count();
		$countBergerak = Materials::where('type', 'Bergerak')->count();

		$quantityTetap = Materials::where('type', 'Tetap')
			->select(DB::raw("CAST($countTetap as signed) as quantity"))
			->groupBy(DB::raw("MONTH(created_at)"))
			->pluck('quantity');

		$quantityBergerak = Materials::where('type', 'Bergerak')
			->select(DB::raw("CAST($countBergerak as signed) as quantity"))
			->groupBy(DB::raw("MONTH(created_at)"))
			->pluck('quantity');

		$bulan = Materials::select(DB::raw("MONTHNAME(created_at) as bulan"))
		->GroupBy(DB::raw("MONTHNAME(created_at)"))
		->pluck('bulan');

		return view('home', compact('quantityTetap','quantityBergerak', 'bulan', 'bulan1', 'quantityRT', 'quantityATK', 'quantityLab'));
	}
}
