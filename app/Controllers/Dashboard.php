<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Booking;
use App\Models\Perawatan;
use App\Models\Obat;
use App\Models\Jadwal;
use App\Models\Jenis;
use App\Models\ObatMasuk;

class Dashboard extends BaseController
{
    public function index()
    {
        // Initialize models
        $pasienModel = new Pasien();
        $dokterModel = new Dokter();
        $bookingModel = new Booking();
        $perawatanModel = new Perawatan();
        $obatModel = new Obat();
        $jadwalModel = new Jadwal();
        $jenisModel = new Jenis();
        $obatMasukModel = new ObatMasuk();

        // Get current user role
        $role = session('role');

        // Prepare data based on role
        $data = [
            'role' => $role,
            'user_name' => session('username') ?? 'User'
        ];

        // Admin & Pimpinan get full statistics
        if ($role === 'admin' || $role === 'pimpinan') {
            $data['stats'] = [
                'total_pasien' => $pasienModel->countAll(),
                'total_dokter' => $dokterModel->countAll(),
                'total_booking' => $bookingModel->countAll(),
                'total_perawatan' => $perawatanModel->countAll(),
                'total_obat' => $obatModel->countAll(),
                'total_jadwal' => $jadwalModel->where('is_active', 1)->countAllResults(),
                'total_jenis' => $jenisModel->countAll(),
                'booking_pending' => $bookingModel->where('status', 'pending')->countAllResults(),
                'booking_approved' => $bookingModel->where('status', 'approved')->countAllResults(),
                'booking_completed' => $bookingModel->where('status', 'completed')->countAllResults(),
                'obat_stok_rendah' => $obatModel->where('stok <=', 10)->countAllResults(),
                'total_pendapatan' => $perawatanModel->selectSum('total')->first()['total'] ?? 0,
                'booking_hari_ini' => $bookingModel->where('DATE(tanggal)', date('Y-m-d'))->countAllResults(),
                'perawatan_hari_ini' => $perawatanModel->where('DATE(tanggal)', date('Y-m-d'))->countAllResults()
            ];

            // Recent activities
            $data['recent_bookings'] = $bookingModel
                ->select('booking.*, pasien.nama as nama_pasien')
                ->join('pasien', 'pasien.id_pasien = booking.id_pasien')
                ->orderBy('booking.created_at', 'DESC')
                ->limit(5)
                ->find();

            $data['upcoming_jadwal'] = $jadwalModel
                ->select('jadwal.*, dokter.nama as nama_dokter')
                ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
                ->where('jadwal.is_active', 1)
                ->orderBy('jadwal.hari', 'ASC')
                ->limit(5)
                ->find();
        }

        // Dokter gets limited data
        if ($role === 'dokter') {
            $dokter_id = session('dokter_id'); // Assuming dokter_id is stored in session
            
            $data['stats'] = [
                'total_pasien_today' => $bookingModel
                    ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
                    ->where('jadwal.iddokter', $dokter_id)
                    ->where('DATE(booking.tanggal)', date('Y-m-d'))
                    ->countAllResults(),
                'total_perawatan_today' => $perawatanModel
                    ->join('booking', 'booking.idbooking = perawatan.idbooking')
                    ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
                    ->where('jadwal.iddokter', $dokter_id)
                    ->where('DATE(perawatan.tanggal)', date('Y-m-d'))
                    ->countAllResults(),
                'my_jadwal' => $jadwalModel->where('iddokter', $dokter_id)->where('is_active', 1)->countAllResults(),
                'pending_booking' => $bookingModel
                    ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
                    ->where('jadwal.iddokter', $dokter_id)
                    ->where('booking.status', 'approved')
                    ->countAllResults()
            ];

            // Doctor's recent patients
            $data['recent_patients'] = $bookingModel
                ->select('booking.*, pasien.nama as nama_pasien, jenis_perawatan.namajenis')
                ->join('pasien', 'pasien.id_pasien = booking.id_pasien')
                ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
                ->join('jenis_perawatan', 'jenis_perawatan.idjenis = booking.idjenis')
                ->where('jadwal.iddokter', $dokter_id)
                ->orderBy('booking.tanggal', 'DESC')
                ->limit(5)
                ->find();
        }

        return view('dashboard/index', $data);
    }
}