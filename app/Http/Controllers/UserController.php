<?php

namespace App\Http\Controllers;

use App\Models\employee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function get_data()
	{
        $sess = Session::all();
        $employe = employee::all();
        if ($sess['jabatan'] !== 'Operator' ) {
            $users = User::all();
        }else{
            $users = User::where('jabatan', "Operator")->get();
        }
        $allData = $employe->merge($users);
        $rank = $allData;

        // Paginate the merged dataset with 10 items per page
        $pageSize = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $employee = new LengthAwarePaginator(
            $allData->forPage($currentPage, $pageSize),
            $allData->count(),
            $pageSize,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        // Pass the paginated data to the view
		return view('pengguna.getData', compact(['rank','employee', 'sess']));
	}

    public function addData()
    {
        return view('pengguna.add');
    }
    public function dataStore(Request $request)
	{
        $validator = $request->validate([
            'nip'   => 'required|numeric',
            'name'   => 'required',
            'email'   => 'required|email',
            'jabatan'   => 'required',
            'alamat'   => 'required',
            'gender'   => 'required',
            'phone_number'   => 'required|numeric',
        ], [
            'nip.required' => 'NIP harus diisi',
            'nip.numeric' => 'NIP harus diisi nomor',
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak sesuai, contoh: nama@mail.com',
            'jabatan.required' => 'Jabatan harus diisi Karyawan atau Operator',
            'jabatan.in' => 'Data harus diisi dengan',
            'alamat.required' => 'Alamat harus diisi',
            'gender.required' => 'Jenis kelamin harus dipilih',
            'phone_number.required' => 'No Handphone harus diisi',
            'phone_number.numeric' => 'No Handphone harus diisi nomor',
        ]);

        $jabatan = $request->jabatan;

        if ($jabatan !== 'Karyawan') {
            DB::table('users')->insert([
                'nip' => $validator['nip'],
                'name' => $validator['name'],
                'email' => $validator['email'],
                'jabatan' => $validator['jabatan'],
                'alamat' => $validator['alamat'],
                'gender' => $validator['gender'],
                'phone_number' => $request['phone_number'],
                'password' => Hash::make($validator['nip']),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }else {
            DB::table('employees')->insert([
                'nip' => $validator['nip'],
                'name' => $validator['name'],
                'email' => $validator['email'],
                'jabatan' => $validator['jabatan'],
                'alamat' => $validator['alamat'],
                'gender' => $validator['gender'],
                'phone_number' => $request['phone_number'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }


		return redirect('/pengguna');
	}

	//public function editData(Request $request, $id)
	//{
    //    $sess = session::all();
    //    try {
    //        $employe = Employee::findOrFail($id);
    //        if ($employe->nip !== session('nip')) {
    //            $employe = User::findOrFail($id);
    //        }
    //        return view('pengguna.update', ['employe' => $employe, 'sess' => $sess]);
    //    } catch (ModelNotFoundException $e) {
    //        $employe = Employee::findOrFail($id);

    //        return view('pengguna.update', ['employe' => $employe, 'sess' => $sess]);
    //    }
	//}
    public function editData(Request $request, $id)
    {
        $sess = session::all();
        
        try {
            //$employe = Employee::findOrFail($id);
            //$user = User::findOrFail($id);
            $employe = Employee::all();
            $user = User::all();
            $allCek = $employe->merge($user);
            //dd($allCek);

            if ($sess['jabatan'] === 'Admin' || $sess['jabatan'] === 'Operator') {
                $user = User::where('nip', $employe->nip)->first();

                if ($user) {
                    $employe = $user;
                }
            }
            
            return view('pengguna.update', ['employe' => $employe, 'sess' => $sess]);
        } catch (ModelNotFoundException $e) {
            // Handle the exception as needed
        }
    }

	public function update(Request $request, $id)
	{
        $validator = $request->validate([
            'nip'   => 'required|numeric',
            'name'   => 'required',
            'email'   => 'required|email',
            'jabatan'   => 'required',
            'alamat'   => 'required',
            'gender'   => 'required',
            'phone_number'   => 'required|numeric',
        ], [
            'nip.required' => 'NIP harus diisi',
            'nip.numeric' => 'NIP harus diisi nomor',
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak sesuai, contoh: nama@mail.com',
            'jabatan.required' => 'Jabatan harus diisi Karyawan atau Operator',
            'jabatan.in' => 'Data harus diisi dengan',
            'alamat.required' => 'Alamat harus diisi',
            'gender.required' => 'Jenis kelamin harus dipilih',
            'phone_number.required' => 'No Handphone harus diisi',
            'phone_number.numeric' => 'No Handphone harus diisi nomor',
        ]);

        $jabatan = $request->jabatan;
        if ($jabatan !== 'Karyawan') {
            $update = [
                'nip' => $validator['nip'],
                'name' => $validator['name'],
                'jabatan' => $validator['jabatan'],
                'email' => $validator['email'],
                'alamat' => $validator['alamat'],
                'gender' => $validator['gender'],
                'phone_number' => $validator['phone_number'],
                'password' => Hash::make($request->password),
                'updated_at' => Carbon::now()
            ];
            User::where('id', $id)->update($update);
        }else {
            $update = [
                'nip' => $validator['nip'],
                'name' => $validator['name'],
                'jabatan' => $validator['jabatan'],
                'email' => $validator['email'],
                'alamat' => $validator['alamat'],
                'gender' => $validator['gender'],
                'phone_number' => $validator['phone_number'],
                'updated_at' => Carbon::now()
            ];
            employee::where('id', $id)->update($update);
        }


		return redirect('/pengguna');
	}

	public function destroy($id)
	{
		employee::destroy($id);
        User::destroy($id);
		return redirect('/pengguna');
	}

    public function search(Request $request)
    {
        $sess = Session::all();
        $paging = 10;
        $query = $request->input('query');
        $em = employee::all();
        $use = User::all();
        $rank = $em->merge($use);


        $usersQuery = User::query();
        $employeesQuery = Employee::query();

            $usersQuery->where('nip', 'LIKE', '%' . $query . '%')
                        ->orWhere('name', 'LIKE', '%' . $query . '%')
                        ->orWhere('email', 'LIKE', '%' . $query . '%')
                        ->orWhere('alamat', 'LIKE', '%' . $query . '%')
                        ->orWhere('phone_number', 'LIKE', '%' . $query . '%');
            $employeesQuery->where('nip', 'LIKE', '%' . $query . '%')
                        ->orWhere('name', 'LIKE', '%' . $query . '%')
                        ->orWhere('email', 'LIKE', '%' . $query . '%')
                        ->orWhere('alamat', 'LIKE', '%' . $query . '%')
                        ->orWhere('phone_number', 'LIKE', '%' . $query . '%');


        $users = $usersQuery->get();
        $employees = $employeesQuery->get();

        $allData = $employees->merge($users);

        $pageSize = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $employee = new LengthAwarePaginator(
            $allData->forPage($currentPage, $pageSize),
            $allData->count(),
            $pageSize,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        return view('pengguna.getData', compact('employee', 'rank', 'sess'));
    }

    public function filter(Request $request)
{
    $sess = Session::all();
    $jabatan = $request->input('jabatan');
    $gender = $request->input('gender');

    $em = employee::all();
    $use = User::all();
    $rank = $em->merge($use);

    $usersQuery = User::query();
    $employeesQuery = Employee::query();

    if ($jabatan !== 'all') {
        $usersQuery->where('jabatan', 'LIKE', '%' . $jabatan . '%');
        $employeesQuery->where('jabatan', 'LIKE', '%' . $jabatan . '%');
    }

    if ($gender !== 'all') {
        $usersQuery->where('gender', 'LIKE', '%' . $gender . '%');
        $employeesQuery->where('gender', 'LIKE', '%' . $gender . '%');
    }

    $users = $usersQuery->get();
    $employees = $employeesQuery->get();

    $allData = $employees->merge($users);
    

    $pageSize = 10;
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $employee = new LengthAwarePaginator(
        $allData->forPage($currentPage, $pageSize),
        $allData->count(),
        $pageSize,
        $currentPage,
        ['path' => LengthAwarePaginator::resolveCurrentPath()]
    );

    return view('pengguna.getData', compact('employee', 'rank', 'sess'));
}


}
