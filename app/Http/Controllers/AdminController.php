<?php

namespace App\Http\Controllers;

use App\Models\pengguna;
use App\Models\reservasi;
use App\Models\riwayat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    function index()
    {
        $reservasi = Reservasi::orderBy('created_at')->get();

        $dataKunjungan = [];
        $dataKonsultasi = [];
        $categories = [];

        foreach ($reservasi as $item) {
            $date = Carbon::parse($item->created_at)->format('Y-m-d');

            // Inisialisasi data per tanggal
            if (!isset($dataKunjungan[$date])) {
                $dataKunjungan[$date] = 0;
                $dataKonsultasi[$date] = 0;
                $categories[] = $date;
            }

            // Hitung jumlah reservasi per jenis kegiatan
            if ($item->kegiatan->id == 1) { // Asumsikan id 1 untuk Reservasi Kunjungan
                $dataKunjungan[$date]++;
            } elseif ($item->kegiatan->id == 2) { // Asumsikan id 2 untuk Reservasi Konsultasi Data
                $dataKonsultasi[$date]++;
            }
        }

        // Ubah data menjadi array
        $dataKunjungan = array_values($dataKunjungan);
        $dataKonsultasi = array_values($dataKonsultasi);

        $today = Carbon::today();
        return view(
            'admin.dashboard',
            [
                'pegawai_count' => User::whereIn('role', ['admin', 'pegawai'])->count(),
                'tamu_count' => User::where('role', 'tamu')->count(),
                'reservasi_count' => Reservasi::where('status', 'proses')->count(),
                'jadwaltoday_count' => Reservasi::whereDate('tgl_req', $today)->where('status', 'disetujui')->count(),

                'dataKunjungan' => $dataKunjungan,
                'dataKonsultasi' => $dataKonsultasi,
                'categories' => $categories
            ]
        );
    }
    function pegawai()
    {
        return view('admin.pegawai', ['user_data' => User::whereIn('role', ['admin', 'pegawai'])->get()]);
    }
    public function tambahPegawai(Request $request)
    {

        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string',
            'email' => 'required|email|unique:users,email', // Validasi email unik
            'no_tlp' => 'required|string',
            'pekerj' => 'required|string',
            'kelamin' => 'required|string',
            'role' => 'required|in:pegawai,admin',
        ], [
            'nama_lengkap' => 'Nama Lengkap Belum Diisi',
            'email' => 'Email tidak tersedia',
            'no_tlp' => 'No. Telepon/WhatsApp  Belum Diisi',
            'pekerj' => 'Jabatan Belum Diisi',
            'kelamin' => 'Jenis Kelamin Belum Diisi'
        ]);

        // Cek apakah validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        // Gunakan transaksi database untuk memastikan integritas data
        DB::beginTransaction();

        try {
            // Buat data pengguna terlebih dahulu
            $pengguna = Pengguna::create([
                'nama_lengkap' => $request->nama_lengkap,
                'pend' => null,
                'kelamin' => $request->kelamin,
                'pekerj' => $request->pekerj,
            ]);

            // Buat data user
            $user = User::create([
                'email' => $request->email,
                'no_tlp' => $request->no_tlp,
                'password' => Hash::make('123456'), // Hashing the password
                'pengguna_id' => $pengguna->id, // Menggunakan ID pengguna yang baru dibuat
                'role' => $request->role, // Tentukan role default, jika ada
            ]);

            // Commit transaksi jika berhasil
            DB::commit();

            // Redirect ke halaman atau route yang sesuai setelah berhasil menyimpan
            return redirect()->route('pegawai')->with('success', 'Data pengguna dan user berhasil disimpan.');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();

            // Redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.')->withInput();
        }
    }

    public function updatepegawai(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'no_tlp' => 'required|string',
            'pekerj' => 'required|string',
            'kelamin' => 'required|string',
            'role' => 'required|in:pegawai,admin'
        ], [
            'nama_lengkap' => 'Nama Lengkap Belum Diisi',
            'email' => 'Email tidak tersedia',
            'no_tlp' => 'No. Telepon/WhatsApp  Belum Diisi',
            'pekerj' => 'Jabatan Belum Diisi',
            'kelamin' => 'Jenis Kelamin Belum Diisi'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Mengambil data pengguna yang ada
        $user = User::find($id);
        $pengguna = $user->pengguna;

        // Memperbarui data pengguna
        $pengguna->update([
            'nama_lengkap' => $request->nama_lengkap,
            'pend' => null,
            'kelamin' => $request->kelamin,
            'pekerj' => $request->pekerj,
        ]);

        // Memperbarui data user
        $user->update([
            'email' => $request->email,
            'no_tlp' => $request->no_tlp,
            'role' => $request->role
        ]);

        return redirect()->route('admin.pegawai')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function deletePegawai(Request $request)
    {
        $selectedUsers = json_decode($request->input('selected_users'));

        if ($selectedUsers) {
            // Hapus Pegawai dan Pengguna terkait
            User::whereIn('id', $selectedUsers)->each(function ($User) {
                $User->pengguna()->delete(); // Hapus Pengguna terkait dengan User
                $User->delete(); // Hapus User itu sendiri
            });

            return redirect()->back()->with('success', 'Data pegawai berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih untuk dihapus.');
        }
    }


    function pengguna()
    {
        return view('admin.pengguna', ['user_data' => User::where('role', 'tamu')->get()]);
    }
    public function tambahPengguna(Request $request)
    {

        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string',
            'pend' => 'required|in:<= SMA,DIPLOMA D1/D2/D3,S1,S2,S3',
            'email' => 'required|email|unique:users,email', // Validasi email unik
            'no_tlp' => 'required|string',
            'pekerj' => 'required|string',
            'pekerj_lainnya' => 'nullable|string',
            'kelamin' => 'required|string'
        ], [
            'nama_lengkap' => 'Nama Lengkap Belum Diisi',
            'pend' => 'Pendidikan Terakhir Belum Diisi',
            'email' => 'Email tidak tersedia',
            'no_tlp' => 'No. Telepon/WhatsApp  Belum Diisi',
            'pekerj' => 'Pekerjaan Belum Diisi',
            'kelamin' => 'Jenis Kelamin Belum Diisi'
        ]);

        // Cek apakah validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Cek apakah pekerjaan adalah "Lainnya"
        $pekerjaan = $request->pekerj;
        if ($pekerjaan === 'Lainnya') {
            $pekerjaan = $request->pekerj_lainnya;
        }

        // Gunakan transaksi database untuk memastikan integritas data
        DB::beginTransaction();

        try {
            // Buat data pengguna terlebih dahulu
            $pengguna = Pengguna::create([
                'nama_lengkap' => $request->nama_lengkap,
                'pend' => $request->pend,
                'kelamin' => $request->kelamin,
                'pekerj' => $pekerjaan,
            ]);

            // Buat data user
            $user = User::create([
                'email' => $request->email,
                'no_tlp' => $request->no_tlp,
                'password' => Hash::make('123456'), // Hashing the password
                'pengguna_id' => $pengguna->id, // Menggunakan ID pengguna yang baru dibuat
                'role' => 'tamu', // Tentukan role default, jika ada
            ]);

            // Commit transaksi jika berhasil
            DB::commit();

            // Redirect ke halaman atau route yang sesuai setelah berhasil menyimpan
            return redirect()->route('admin.pengguna')->with('success', 'Data pengguna dan user berhasil disimpan.');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();

            // Redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.')->withInput();
        }
    }

    public function updatePengguna(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string',
            'pend' => 'required|in:<= SMA,DIPLOMA D1/D2/D3,S1,S2,S3',
            'email' => 'required|email|unique:users,email,' . $id,
            'no_tlp' => 'required|string',
            'pekerj' => 'required|string',
            'kelamin' => 'required|string',
        ], [
            'nama_lengkap' => 'Nama Lengkap Belum Diisi',
            'pend' => 'Pendidikan Terakhir Belum Diisi',
            'email' => 'Email tidak tersedia',
            'no_tlp' => 'No. Telepon/WhatsApp  Belum Diisi',
            'pekerj' => 'Pekerjaan Belum Diisi',
            'kelamin' => 'Jenis Kelamin Belum Diisi'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Mengambil data pengguna yang ada
        $user = User::find($id);
        $pengguna = $user->pengguna;

        // Memperbarui data pengguna
        $pengguna->update([
            'nama_lengkap' => $request->nama_lengkap,
            'pend' => $request->pend,
            'kelamin' => $request->kelamin,
            'pekerj' => $request->pekerj,
        ]);

        // Memperbarui data user
        $user->update([
            'email' => $request->email,
            'no_tlp' => $request->no_tlp,
        ]);

        return redirect()->route('admin.pengguna')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function deletePengguna(Request $request)
    {
        $selectedUsers = json_decode($request->input('selected_users'));

        if ($selectedUsers) {
            // Hapus users yang dipilih dan data terkait secara cascade
            $users = User::whereIn('id', $selectedUsers)->get();
            foreach ($users as $user) {
                $user->pengguna()->delete();
                $user->delete();
            }

            return redirect()->back()->with('success', 'Data Pengguna berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih untuk dihapus.');
        }
    }

    function mading()
    {
        return view('admin.mading');
    }
    public function permintaan()
    {
        $reservasi = reservasi::with(['user.pengguna', 'kegiatan'])
            ->where('status', 'proses')
            ->get();
        return view('admin.permintaan.permintaan', compact('reservasi'));
    }

    public function updateStatus(Request $request, $id, $status)
    {
        $reservasi = reservasi::findOrFail($id);

        // Buat balasan di tabel riwayat
        $riwayat = riwayat::create([
            'kepada' => $reservasi->user->pengguna->nama_lengkap,
            'pengirim' => Auth::user()->role,
            'reservasi_id' => $reservasi->id,
            'subjek' => $request->input('subjek', 'Null'),
            'deskripsi' => $request->input('deskripsi', ''),
        ]);

        // Update status dan riwayat_id di reservasi
        $reservasi->update([
            'status' => $status,
            'riwayat_id' => $riwayat->id,
        ]);

        return redirect()->back()->with('success', 'Reservasi berhasil diperbarui.');
    }

    public function permintaan1()
    {
        $reservasi = reservasi::with(['user.pengguna', 'kegiatan'])
            ->where('status', 'proses')
            ->get();
        return view('admin.permintaan.permintaan1', compact('reservasi'));
    }
    function riwayat()
    {
        return view('admin.riwayat.riwayat', ['reservasi' => reservasi::with(['user.pengguna', 'kegiatan'])->whereIn('status', ['disetujui', 'ditolak'])->get()]);
    }
    function riwayat1()
    {
        return view('admin.riwayat.riwayat1', ['reservasi' => reservasi::with(['user.pengguna', 'kegiatan'])->whereIn('status', ['disetujui', 'ditolak'])->get()]);
    }
    function kalender()
    {
        $reservasi = Reservasi::where('status', 'disetujui')->get();
        $event = array();
        foreach ($reservasi as $reservasis) {
            $event[] = [
                'user_id' => $reservasis->user_id,
                'start' => $reservasis->tgl_req,
                'end' => $reservasis->tgl_req,
                'wkt_req' => $reservasis->wkt_req,
                'plat_req' => $reservasis->plat_req,
                'title' => $reservasis->kegiatan->nama,
            ];
        }
        $usePagination = request()->has('paginate');
        // $usePagination = true;
        $detilQuery = reservasi::with('user.pengguna')->where('status', 'disetujui');
        if ($usePagination) {
            $detil = $detilQuery->get();
            // return ('bisa');
        } else {
            $detil = $detilQuery->paginate(3); // Mengambil semua data sekaligus
            // return('nda bisa');
        }
        return view('admin.schedule', ['event' => $event], compact('detil', 'usePagination'));
        // return $detil;
    }
}
