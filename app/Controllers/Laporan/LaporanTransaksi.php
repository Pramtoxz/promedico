<?php

namespace App\Controllers\Laporan;

use App\Controllers\BaseController;
use App\Models\AsetModel;
use CodeIgniter\HTTP\ResponseInterface;

class LaporanTransaksi extends BaseController
{

    public function LaporanBooking()
    {
        $data['title'] = 'Laporan Booking';
        return view('laporan/booking/booking', $data);
    }


    public function viewallLaporanBooking()
    {
        $db = db_connect();
        $booking = $db
            ->table('booking')
            ->select('booking.*, jadwal.hari, dokter.nama as nama_dokter, pasien.nama as nama_pasien,pasien.alamat , pasien.nohp, jenis_perawatan.namajenis, jenis_perawatan.estimasi, jenis_perawatan.harga')
            ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
            ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
            ->join('pasien', 'pasien.id_pasien = booking.id_pasien')
            ->join('jenis_perawatan', 'jenis_perawatan.idjenis = booking.idjenis')
            ->orderBy('booking.idbooking', 'DESC')
            ->get()
            ->getResultArray();
        $data = [
            'booking' => $booking,
        ];
        $response = [
            'data' => view('laporan/booking/viewallbooking', $data),
        ];

        echo json_encode($response);
    }

    public function viewallLaporanBookingTanggal()
    {
        $tglmulai = $this->request->getPost('tglmulai');
        $tglakhir = $this->request->getPost('tglakhir');
        $db = db_connect();
        $query = $db
            ->table('booking')
            ->select('booking.*, jadwal.hari, dokter.nama as nama_dokter, pasien.nama as nama_pasien,pasien.alamat , pasien.nohp, jenis_perawatan.namajenis, jenis_perawatan.estimasi, jenis_perawatan.harga')
            ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
            ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
            ->join('pasien', 'pasien.id_pasien = booking.id_pasien')
            ->join('jenis_perawatan', 'jenis_perawatan.idjenis = booking.idjenis')
            ->orderBy('booking.idbooking', 'DESC')
           ->where('booking.created_at >=', $tglmulai)
            ->where('booking.created_at <=', $tglakhir)
            ->getCompiledSelect();
        $booking = $db->query($query)->getResultArray();
        $data = [
            'booking' => $booking,
            'tglmulai' => $tglmulai,
            'tglakhir' => $tglakhir,
        ];
        $response = [
            'data' => view('laporan/booking/viewallbookingtanggal', $data),
        ];

        echo json_encode($response);
    }

    public function viewallLaporanBookingBulan()
    {
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');
        $db = db_connect();
        $query = $db
            ->table('booking')
            ->select('booking.*, jadwal.hari, dokter.nama as nama_dokter, pasien.nama as nama_pasien,pasien.alamat , pasien.nohp, jenis_perawatan.namajenis, jenis_perawatan.estimasi, jenis_perawatan.harga')
            ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
            ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
            ->join('pasien', 'pasien.id_pasien = booking.id_pasien')
            ->join('jenis_perawatan', 'jenis_perawatan.idjenis = booking.idjenis')
            ->orderBy('booking.idbooking', 'DESC')
            ->where('month(booking.created_at)', $bulan)
            ->where('year(booking.created_at)', $tahun)
            ->getCompiledSelect();
        $booking = $db->query($query)->getResultArray();
        $data = [
            'booking' => $booking,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ];
        $response = [
            'data' => view('laporan/booking/viewallbookingbulan', $data),
        ];

        echo json_encode($response);
    }

    

    public function LaporanPerawatan()
    {
        $data['title'] = 'Laporan Perawatan';
        return view('laporan/perawatan/perawatan', $data);
    }

    public function viewallLaporanPerawatan()
    {
        $db = db_connect();
        $perawatan = $db
            ->table('detail_perawatan')
            ->select('perawatan.idperawatan, booking.idbooking, pasien.nama as nama_pasien, dokter.nama as nama_dokter, perawatan.tanggal as tglperawatan, detail_perawatan.idobat, detail_perawatan.qty, detail_perawatan.total')
            ->join('perawatan', 'perawatan.idperawatan = detail_perawatan.idperawatan')
            ->join('booking', 'booking.idbooking = perawatan.idbooking')
            ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
            ->join('pasien', 'pasien.id_pasien = booking.id_pasien')
            ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
            ->join('obat', 'obat.idobat = detail_perawatan.idobat')
            ->groupBy('perawatan.idperawatan, booking.idbooking, pasien.nama, dokter.nama, perawatan.tanggal, detail_perawatan.idobat, detail_perawatan.qty, detail_perawatan.total')
            ->get()
            ->getResultArray();

        $data = [
            'perawatan' => $perawatan,
        ];
        $response = [
            'data' => view('laporan/perawatan/viewallperawatan', $data),
        ];

        echo json_encode($response);
    }

    public function viewallLaporanPerawatanTanggal()
    {
        $tglmulai = $this->request->getPost('tglmulai');
        $tglakhir = $this->request->getPost('tglakhir');
        
        $db = db_connect();
        $perawatan = $db
            ->table('detail_perawatan')
            ->select('perawatan.idperawatan, booking.idbooking, pasien.nama as nama_pasien, dokter.nama as nama_dokter, perawatan.tanggal as tglperawatan, detail_perawatan.idobat, detail_perawatan.qty, detail_perawatan.total')
            ->join('perawatan', 'perawatan.idperawatan = detail_perawatan.idperawatan')
            ->join('booking', 'booking.idbooking = perawatan.idbooking')
            ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
            ->join('pasien', 'pasien.id_pasien = booking.id_pasien')
            ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
            ->join('obat', 'obat.idobat = detail_perawatan.idobat')
            ->where('perawatan.tanggal >=', $tglmulai)
            ->where('perawatan.tanggal <=', $tglakhir)
            ->groupBy('perawatan.idperawatan, booking.idbooking, pasien.nama, dokter.nama, perawatan.tanggal, detail_perawatan.idobat, detail_perawatan.qty, detail_perawatan.total')
            ->get()
            ->getResultArray();

        $data = [
            'perawatan' => $perawatan,
            'tglmulai' => $tglmulai,
            'tglakhir' => $tglakhir,
        ];
        $response = [
            'data' => view('laporan/perawatan/viewallperawatantanggal', $data),
        ];

        echo json_encode($response);
    }

    public function viewallLaporanPerawatanBulan()
    {
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');
        
        $db = db_connect();
        $perawatan = $db
            ->table('detail_perawatan')
            ->select('perawatan.idperawatan, booking.idbooking, pasien.nama as nama_pasien, dokter.nama as nama_dokter, perawatan.tanggal as tglperawatan, detail_perawatan.idobat, detail_perawatan.qty, detail_perawatan.total')
            ->join('perawatan', 'perawatan.idperawatan = detail_perawatan.idperawatan')
            ->join('booking', 'booking.idbooking = perawatan.idbooking')
            ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
            ->join('pasien', 'pasien.id_pasien = booking.id_pasien')
            ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
            ->join('obat', 'obat.idobat = detail_perawatan.idobat')
            ->where("MONTH(perawatan.tanggal) = '$bulan'")
            ->where("YEAR(perawatan.tanggal) = '$tahun'")
            ->groupBy('perawatan.idperawatan, booking.idbooking, pasien.nama, dokter.nama, perawatan.tanggal, detail_perawatan.idobat, detail_perawatan.qty, detail_perawatan.total')
            ->get()
            ->getResultArray();

        $data = [
            'perawatan' => $perawatan,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ];
        $response = [
            'data' => view('laporan/perawatan/viewallperawatanbulan', $data),
        ];

        echo json_encode($response);
    }
}
