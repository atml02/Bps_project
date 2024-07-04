<?php

namespace App\Http\Controllers;

use App\Models\reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TamuController extends Controller
{
    // Fungsi untuk menampilkan form reservasi
    public function index()
    {
        return view('reservasi');
    }

    // Fungsi untuk menyimpan reservasi ke database
    public function masukan(Request $request)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            'tgl_req' => 'required|date',
            'wkt_req' => 'required|in:Sesi Pagi (08.00-12.00),Sesi Siang (13.00-16.00)',
            'temu_req_option' => 'required', // Memastikan salah satu pilihan dipilih
            'temu_req_textarea' => 'nullable:temu_req_option,Lainnya', // Hanya required jika pilihan "Lainya" dipilih
            'keperluan' => 'required|string',
        ],[
            'tgl_req.required'=>'Pilih Tanggal Yang Akan Diajukan',
            'wkt_req.required'=>'Pilih Waktu Yang Akan Diajukan',
            'temu_req_option.required'=>'Pilih Yang Anda Ingin Temui',
            'keperluan.required'=>'Isi Keperluan Anda'
        ]);

        $temu_req = $request->temu_req_option;
        if ($temu_req === 'Lainnya') {
            $temu_req = $request->temu_req_textarea;
        }

        // Menyimpan data reservasi baru ke dalam database
        Reservasi::create([
            'user_id' => Auth::id(), // Menggunakan ID user yang sedang login
            'kegiatan_id' => '1',
            'tgl_req' => $request->tgl_req,
            'wkt_req' => $request->wkt_req,
            'temu_req' => $temu_req,
            'keperluan' => $request->keperluan,
            'status' => 'proses', // Default status proses
        ]);

        // Redirect ke halaman atau route yang sesuai setelah berhasil menyimpan
        return redirect()->route('pesan')->with('success', 'Reservasi berhasil disimpan.');
    }

    function online()
    {
        return view('reservasi_online');
    }

    public function masukanOnline(Request $request)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            'tgl_req' => 'required|date',
            'wkt_req' => 'required|in:Sesi Pagi (08.00-12.00),Sesi Siang (13.00-16.00)',
            'plat_req' => 'required|in:WhatsApp,Zoom Meeting,Google Meet',
            'keperluan' => 'required|string',
        ],[
            'tgl_req.required'=>'Pilih Tanggal Yang Akan Diajukan',
            'wkt_req.required'=>'Pilih Waktu Yang Akan Diajukan',
            'plat_req.required'=>'Pilih Platform Untuk Konsultasi Daring',
            'keperluan.required'=>'Isi Keperluan Anda'
        ]);

        
        // Menyimpan data reservasi baru ke dalam database
        Reservasi::create([
            'user_id' => Auth::id(), // Menggunakan ID user yang sedang login
            'kegiatan_id' => '2',
            'tgl_req' => $request->tgl_req,
            'wkt_req' => $request->wkt_req,
            'plat_req' => $request->plat_req,
            'keperluan' => $request->keperluan,
            'status' => 'proses', // Default status proses
        ]);

        // Redirect ke halaman atau route yang sesuai setelah berhasil menyimpan
        return redirect()->route('pesan')->with('success', 'Reservasi berhasil disimpan.');
    }

    function konfirmasi()
    {
        return view('pesan_konfirmasi');
    }


    function riwayat_p(Request $request)
    {
        $search = $request->input('search');
        $reservasiQuery = reservasi::with(['user.pengguna', 'kegiatan']);
        if ($search) {
            $reservasiQuery->where(function ($query) use ($search) {
                $query->orWhere('plat_req', 'like', '%' . $search . '%')
                    ->orWhere('wkt_req', 'like', '%' . $search . '%')
                    ->orWhereRaw('DATE_FORMAT(created_at, "%d %b %Y") like ?', ['%' . $search . '%'])
                    ->orWhere('status', 'like', '%' . $search . '%')
                    ->orWhereHas('kegiatan', function ($query) use ($search) {
                        $query->where('nama', 'like', '%' . $search . '%');
                    });
            });
        
            $reservasi = $reservasiQuery->where('user_id', Auth::user()->id)->get();
        } else {
            $reservasi = $reservasiQuery->where('user_id', Auth::user()->id)->paginate(3);
        }
        return view('riwayat_pengajuan', compact('reservasi'));
    }
    function kotak_p(Request $request)
    {
        $search = $request->input('search');
        $reservasiQuery = reservasi::with(['user.pengguna', 'kegiatan' ,'riwayat']);
        if ($search) {
            $reservasiQuery->where(function ($query) use ($search) {
                $query->orWhere('plat_req', 'like', '%' . $search . '%')
                    ->orWhere('wkt_req', 'like', '%' . $search . '%')
                    ->orWhereRaw('DATE_FORMAT(created_at, "%d %b %Y") like ?', ['%' . $search . '%'])
                    ->orWhereHas('kegiatan', function ($query) use ($search) {
                        $query->where('nama', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('riwayat', function ($query) use ($search) {
                        $query->where('pengirim', 'like', '%' . $search . '%');
                        
                    })
                    ->orWhereHas('riwayat', function ($query) use ($search) {
                        $query->where('kepada', 'like', '%' . $search . '%');
                        
                    })
                    ->orWhereHas('riwayat', function ($query) use ($search) {
                        $query->where('subjek', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('riwayat', function ($query) use ($search) {
                        $query->where('deskripsi', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('riwayat', function ($query) use ($search) {
                        $query->where('created_at', 'like', '%' . $search . '%');
                    })
                    ;
            });
        
            $reservasi = $reservasiQuery->where('user_id', Auth::user()->id)->whereIn('status', ['disetujui', 'ditolak'])->get();
        } else {
            $reservasi = $reservasiQuery->where('user_id', Auth::user()->id)->whereIn('status', ['disetujui', 'ditolak'])->paginate(3);
        }
        return view('kotak_pesan', compact('reservasi'));
    }
    function pesan()
    {
        return view('pesan');
    }
}
