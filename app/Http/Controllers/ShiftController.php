<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Traits\JsonResponse;
use Illuminate\Http\Request;
use App\Models\EmployeeShift;
use Illuminate\Support\Facades\Validator;

class ShiftController extends Controller
{
    use JsonResponse;

    public function index()
    {
        $shifts = EmployeeShift::orderBy('shift')->get();

        return view('shift', compact('shifts'));
    }

    public function insert(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'employee_id' => 'required|exists:employees,id',
            'shift' => 'required|date',
        ]);

        if ($validation->fails()) {
            return $this->responseError($validation->errors()->all()[0]);
        }

        $date = Carbon::parse($request->input('shift'));
        $now = Carbon::now()->endOfDay();

        // Cek jika lebih dari hari ini (poin c)
        if ($date->gt($now)) {
            return $this->responseError('Tanggal tidak bisa lebih dari hari ini!');
        }

        // Cek jika karyawan sudah input di hari sama (poin d)
        $cek = EmployeeShift::whereDate('shift', $date->format('Y'))->first();
        if ($cek) {
            return $this->responseError('Karyawan tidak bisa pilih shift di hari yang sama!');
        }

        $shift = EmployeeShift::create([
            'employee_id' => $request->input('employee_id'),
            'shift' => $date,
        ]);

        return $this->responseSuccess($shift, 'Berhasil ditambahkan!');
    }
}
