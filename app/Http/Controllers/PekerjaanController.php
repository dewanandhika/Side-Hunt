<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pekerjaan;
use App\Models\KriteriaJob;
use App\Http\Controllers\KriteriaJobController;

use Illuminate\Http\Request;


class PekerjaanController extends Controller
{
    public function index()
    {
        $active_navbar = 'Beri Lowongan Kerja';
        $nama_halaman = 'Cari Pekerjaan';


        return view("Mitra.pekerjaan-cari", compact("active_navbar", 'nama_halaman'));
    }
    public function create()
    {
        $active_navbar = 'Beri Lowongan Kerja';
        $nama_halaman = 'Tambah Pekerjaan';
        $kriteria = KriteriaJob::all();
        return view("Mitra.pekerjaan-add", compact("active_navbar", 'nama_halaman', 'kriteria'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            $request->validate([
                'nama' => 'required|string|max:60',
                'min_gaji' => 'required|integer|max:99999999999999999999', // maksimal 20 digit
                'max_gaji' => 'required|integer|max:99999999999999999999', // maksimal 20 digit
                'max_pekerja' => 'required|integer|max:9999999999', // maksimal 10 digit
                'deskripsi' => 'required|string|max:1000',
                'alamat' => 'required|string|max:100',
                'petunjuk_alamat' => 'required|string|max:100',
                'koordinat' => 'required|string',
                'latitude' => 'required|string',
                'longitude' => 'required|string',
                'start_job' => 'required|date|after_or_equal:today',
                'end_job' => 'required|date|after_or_equal:start_job',
                'deadline_job' => 'nullable|date|before_or_equal:end_job',
                'kriteria' => 'required|array|min:3',
                'foto_job' => 'nullable|file|mimes:jpg,jpeg,png,img,image/jpeg, image/png|max:5120',
            ], [
                'nama.required' => 'Nama wajib diisi.',
                'nama.string' => 'Nama harus berupa teks.',
                'nama.max' => 'Nama maksimal 60 karakter.',

                'min_gaji.required' => 'Gaji minimum wajib diisi.',
                'min_gaji.integer' => 'Gaji minimum harus berupa angka bulat.',
                'min_gaji.max' => 'Gaji minimum maksimal 20 digit angka.',

                'max_gaji.required' => 'Gaji maksimum wajib diisi.',
                'max_gaji.integer' => 'Gaji maksimum harus berupa angka bulat.',
                'max_gaji.max' => 'Gaji maksimum maksimal 20 digit angka.',

                'max_pekerja.required' => 'Pekerja diterima wajib diisi.',
                'max_pekerja.integer' => 'Pekerja diterima harus berupa angka bulat.',
                'max_pekerja.max' => 'Pekerja diterima maksimal 10 digit angka.',

                'deskripsi.required' => 'Deskripsi wajib diisi.',
                'deskripsi.string' => 'Deskripsi harus berupa teks.',
                'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.',

                'alamat.required' => 'Alamat wajib diisi.',
                'alamat.string' => 'Alamat harus berupa teks.',
                'alamat.max' => 'Alamat maksimal 100 karakter.',

                'petunjuk_alamat.required' => 'Petunjuk alamat wajib diisi.',
                'petunjuk_alamat.string' => 'Petunjuk alamat harus berupa teks.',
                'petunjuk_alamat.max' => 'Petunjuk alamat maksimal 100 karakter.',

                'koordinat.required' => 'Lokasi Alamat wajib diisi.',

                'start_job.required' => 'Tanggal & waktu mulai wajib diisi.',
                'start_job.date' => 'Format tanggal & waktu mulai tidak valid.',
                'start_job.after_or_equal' => 'Tanggal & waktu mulai tidak boleh sebelum hari ini.',

                'end_job.required' => 'Tanggal & waktu selesai wajib diisi.',
                'end_job.date' => 'Format tanggal & waktu selesai tidak valid.',
                'end_job.after_or_equal' => 'Waktu selesai tidak boleh lebih awal dari waktu mulai.',

                'deadline_job.date' => 'Format deadline tidak valid.',
                'deadline_job.before_or_equal' => 'Deadline harus sebelum atau sama dengan waktu berakhirnya kerja.',

                'foto_job.mimes' => 'Foto harus berformat JPG/PNG/JPEG/IMG/IMAGE.',
                'foto_job.max' => 'Ukuran foto maksimal 5MB.',


                'kriteria.required' => 'Minimal masukkan 3 kriteria.',
                'kriteria.array' => 'Format kriteria tidak valid.',
                'kriteria.min' => 'Minimal masukkan 3 kriteria.',


            ])

        ]);
        $request['pembuat'] = session('account')['id'];
        $kriteria = [];
        // dd($request->kriteria);     
        foreach ($request->kriteria as $nama) {
            $cek = (new KriteriaJobController())->cek_exist($nama);
            if ($cek == false) {
                $new = (new KriteriaJobController())->store(trim($nama));
                // dD($new);
                $kriteria[] = $new->id;
            } else {
                $kriteria[] = $cek;
            }
        }

        $request['kriteria'] = implode(",", $kriteria);
        // dd($request);


        $data = collect($request->all())->mapWithKeys(function ($value, $key) {
            return [$key => is_array($value) ? $value : (string)$value];
        })->toArray();
        if ($request['deadline_job'] == null) {
            $data['deadline_job'] = null;
        } else {
            $data['deadline_job'] = $request['deadline_job'];
        }

        if ($request->hasFile('foto_job')) {
            $file = $request->file('foto_job');
            $filename = $request->nama . "." . $file->getClientOriginalExtension();
            $path = $file->storeAs('job', $filename, 'public');
            $data['foto_job'] = $filename;
        }
        if (Pekerjaan::create($data)) {
            return redirect()->back()->with('success', 'Pekerjaan Berhasil didaftarkan');
        };
    }
}
