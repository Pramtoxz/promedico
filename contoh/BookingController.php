<?php

namespace App\Controllers;

use App\Models\Booking;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\Jenis;
use CodeIgniter\RESTful\ResourceController;
use Hermawan\DataTables\DataTable;

class BookingController extends ResourceController
{
    protected $bookingModel;
    protected $pasienModel;
    protected $dokterModel;
    protected $jadwalModel;
    protected $jenisModel;
    
    public function __construct()
    {
        $this->bookingModel = new Booking();
        $this->pasienModel = new Pasien();
        $this->dokterModel = new Dokter();
        $this->jadwalModel = new Jadwal();
        $this->jenisModel = new Jenis();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Data Booking',
        ];
        
        return view('booking/index', $data);
    }
    
    public function getDataTables()
    {
        $db = db_connect();
        $builder = $db->table('booking')
            ->select('
                booking.idbooking,
                pasien.nama as nama_pasien,
                dokter.nama as nama_dokter,
                booking.tanggal,
                booking.waktu_mulai,
                booking.waktu_selesai,
                booking.status
            ')
            ->join('pasien', 'pasien.id_pasien = booking.id_pasien')
            ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
            ->join('dokter', 'dokter.id_dokter = jadwal.iddokter');
        
        return DataTable::of($builder)
            ->addNumbering('no')
            ->add('action', function($row){
                // Tombol view selalu ditampilkan
                $html = '<div class="d-flex">';
                $html .= '<a href="'.site_url('booking/'.$row->idbooking).'" class="btn btn-info btn-sm me-1">';
                $html .= '<i class="bi bi-eye"></i>';
                $html .= '</a>';
                
                // Tombol edit dan delete hanya ditampilkan jika status bukan 'diperiksa'
                if ($row->status != 'diperiksa') {
                    $html .= '<a href="'.site_url('booking/'.$row->idbooking.'/edit').'" class="btn btn-warning btn-sm me-1">';
                    $html .= '<i class="bi bi-pencil"></i>';
                    $html .= '</a>';
                    $html .= '<button type="button" class="btn btn-danger btn-sm btn-delete" data-id="'.$row->idbooking.'">';
                    $html .= '<i class="bi bi-trash"></i>';
                    $html .= '</button>';
                }
                
                $html .= '</div>';
                return $html;
            })
            ->format('tanggal', function($value){
                return date('d/m/Y', strtotime($value));
            })
            ->format('waktu_mulai', function($value){
                return date('H:i', strtotime($value));
            })
            ->format('waktu_selesai', function($value){
                return date('H:i', strtotime($value));
            })
            ->format('status', function($value){
                if ($value == 'diproses') {
                    return '<span class="badge bg-warning">Diproses</span>';
                } else if ($value == 'diterima') {
                    return '<span class="badge bg-success">Diterima</span>';
                } else if ($value == 'ditolak') {
                    return '<span class="badge bg-danger">Ditolak</span>';
                } else if ($value == 'diperiksa') {
                    return '<span class="badge bg-primary">Diperiksa</span>';
                }
                return $value;
            })
            ->toJson(true);
    }
    
    public function show($id = null)
    {
        $db = db_connect();
        $booking = $db->table('booking')
            ->select('
                booking.*,
                pasien.nama as nama_pasien,
                dokter.nama as nama_dokter,
                jenis_perawatan.namajenis as jenis_perawatan,
                jenis_perawatan.estimasi as durasi_perawatan
            ')
            ->join('pasien', 'pasien.id_pasien = booking.id_pasien')
            ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
            ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
            ->join('jenis_perawatan', 'jenis_perawatan.idjenis = booking.idjenis')
            ->where('booking.idbooking', $id)
            ->get()
            ->getRowArray();
        
        if (!$booking) {
            return redirect()->to(site_url('booking'))->with('error', 'Data booking tidak ditemukan');
        }
        
        $data = [
            'title' => 'Detail Booking',
            'booking' => $booking
        ];
        
        return view('booking/detail', $data);
    }
    
    public function new()
    {
        // Generate ID Booking dengan format BK0001, BK0002, dst
        $db = db_connect();
        $tanggal = date('Ymd');
        $query = $db->query("SELECT CONCAT('BK', '$tanggal', LPAD(IFNULL(MAX(SUBSTRING(idbooking, 11)) + 1, 1), 4, '0')) AS next_number FROM booking WHERE idbooking LIKE 'BK$tanggal%'");
        $row = $query->getRow();
        $next_number = $row->next_number;
        
        $data = [
            'title' => 'Tambah Booking Offline',
            'next_number' => $next_number,
            'jenis' => $this->jenisModel->findAll(),
            'validation' => \Config\Services::validation()
        ];
        
        return view('booking/tambah', $data);
    }
    
    public function create()
    {
        $rules = [
            'idbooking' => [
                'rules' => 'required|is_unique[booking.idbooking]',
                'errors' => [
                    'required' => 'ID Booking harus diisi',
                    'is_unique' => 'ID Booking sudah terdaftar'
                ]
            ],
            'id_pasien' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pasien harus dipilih'
                ]
            ],
            'idjadwal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jadwal dokter harus dipilih'
                ]
            ],
            'idjenis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis perawatan harus dipilih'
                ]
            ],
            'tanggal' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'Tanggal harus diisi',
                    'valid_date' => 'Format tanggal tidak valid'
                ]
            ]
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $idjadwal = $this->request->getPost('idjadwal');
        $tanggal = $this->request->getPost('tanggal');
        $idjenis = $this->request->getPost('idjenis');
        
        // Set timezone ke Waktu Indonesia Barat (WIB)
        date_default_timezone_set('Asia/Jakarta');
        
        // Dapatkan jadwal dokter
        $jadwal = $this->jadwalModel->find($idjadwal);
        if (!$jadwal) {
            return redirect()->back()->withInput()->with('error', 'Jadwal dokter tidak ditemukan');
        }
        
        // Validasi apakah tanggal sesuai dengan hari jadwal dokter
        $dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $dayOfWeek = date('w', strtotime($tanggal)); // 0 (Minggu) sampai 6 (Sabtu)
        $dayName = $dayNames[$dayOfWeek];
        
        if ($dayName !== $jadwal['hari']) {
            return redirect()->back()->withInput()->with('error', "Tanggal {$tanggal} bukan hari {$jadwal['hari']}. Silakan pilih tanggal yang sesuai.");
        }
        
        // Validasi apakah waktu jadwal untuk hari ini sudah lewat
        $today = date('Y-m-d');
        if ($tanggal == $today) {
            $currentTime = date('H:i:s');
            
            // Jika waktu saat ini sudah lewat dari waktu awal jadwal
            if ($currentTime > $jadwal['waktu_mulai']) {
                // Untuk booking langsung (walk-in), kita tetap perbolehkan jika masih dalam rentang jadwal
                $is_walk_in = true; // Karena ini booking offline oleh admin
                
                // Jika ini walk-in dan masih dalam rentang waktu jadwal, perbolehkan
                if ($is_walk_in && $currentTime < $jadwal['waktu_selesai']) {
                    // Lanjutkan proses booking
                } else {
                    // Jika bukan walk-in atau sudah melewati waktu selesai jadwal, tolak
                return redirect()->back()->withInput()->with('error', "Jadwal dokter untuk hari ini pada pukul " . substr($jadwal['waktu_mulai'], 0, 5) . " sudah lewat. Silakan pilih tanggal lain.");
                }
            }
        }
        
        // Dapatkan durasi jenis perawatan
        $jenis = $this->jenisModel->find($idjenis);
        $durasi_menit = $jenis['estimasi'];
        
        // Karena ini booking offline oleh admin, set is_walk_in ke true
        $is_walk_in = true;
        
        // Cari slot waktu yang tersedia berdasarkan jadwal dokter
        $slot = $this->bookingModel->findAvailableSlotFromSchedule($idjadwal, $tanggal, $durasi_menit);
        
        if (!$slot) {
            return redirect()->back()->withInput()->with('error', 'Tidak ada slot waktu tersedia pada jadwal yang dipilih');
        }
        
        // Jika ini adalah booking langsung (walk-in) dan tanggal hari ini
        if ($is_walk_in && $tanggal == $today) {
            $currentTime = date('H:i:s');
            
            // Cek apakah ada booking sebelumnya pada tanggal tersebut
            $existingBookings = $this->bookingModel->where('idjadwal', $idjadwal)
                              ->where('tanggal', $tanggal)
                              ->where('status !=', 'ditolak')
                              ->countAllResults();
            
            // Jika tidak ada booking lain, gunakan waktu saat ini (WIB)
            if ($existingBookings == 0) {
                // Hanya gunakan waktu saat ini jika masih dalam range jadwal
                if ($currentTime >= $jadwal['waktu_mulai'] && $currentTime < $jadwal['waktu_selesai']) {
                    $slot['waktu_mulai'] = $currentTime;
                    $slot['waktu_selesai'] = date('H:i:s', strtotime($currentTime) + ($durasi_menit * 60));
                }
            }
        }
        
        $data = [
            'idbooking' => $this->request->getPost('idbooking'),
            'id_pasien' => $this->request->getPost('id_pasien'),
            'idjadwal' => $idjadwal,
            'idjenis' => $idjenis,
            'tanggal' => $tanggal,
            'waktu_mulai' => $slot['waktu_mulai'],
            'waktu_selesai' => $slot['waktu_selesai'],
            'status' => 'diterima', // Langsung diterima karena dari admin
            'catatan' => $this->request->getPost('catatan')
        ];
        
        $this->bookingModel->insert($data);
        
        return redirect()->to(site_url('booking'))->with('message', 'Booking berhasil ditambahkan');
    }
    
    public function edit($id = null)
    {
        $db = db_connect();
        $booking = $db->table('booking')
            ->select('booking.*, jadwal.hari')
            ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
            ->where('booking.idbooking', $id)
            ->get()
            ->getRowArray();
        
        if (!$booking) {
            return redirect()->to(site_url('booking'))->with('error', 'Data booking tidak ditemukan');
        }
        
        $data = [
            'title' => 'Edit Booking',
            'booking' => $booking,
            'pasien' => $this->pasienModel->findAll(),
            'jadwal' => $this->getJadwalWithDokter(),
            'jenis' => $this->jenisModel->findAll(),
            'status' => ['diproses', 'diterima', 'ditolak'],
            'validation' => \Config\Services::validation()
        ];
        
        return view('booking/edit', $data);
    }
    
    public function update($id = null)
    {
        $booking = $this->bookingModel->find($id);
        
        if (!$booking) {
            return redirect()->to(site_url('booking'))->with('error', 'Data booking tidak ditemukan');
        }
        
        $rules = [
            'id_pasien' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pasien harus dipilih'
                ]
            ],
            'idjadwal' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jadwal dokter harus dipilih'
                ]
            ],
            'idjenis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jenis perawatan harus dipilih'
                ]
            ],
            'tanggal' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'Tanggal harus diisi',
                    'valid_date' => 'Format tanggal tidak valid'
                ]
            ],
            'status' => [
                'rules' => 'required|in_list[diproses,diterima,ditolak,diperiksa]',
                'errors' => [
                    'required' => 'Status harus dipilih',
                    'in_list' => 'Status tidak valid'
                ]
            ]
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $idjadwal = $this->request->getPost('idjadwal');
        $tanggal = $this->request->getPost('tanggal');
        $idjenis = $this->request->getPost('idjenis');
        $status = $this->request->getPost('status');
        
        // Validasi apakah jadwal dokter ada
        $jadwal = $this->jadwalModel->find($idjadwal);
        if (!$jadwal) {
            return redirect()->back()->withInput()->with('error', 'Jadwal dokter tidak ditemukan');
        }
        
        // Validasi apakah tanggal sesuai dengan hari jadwal dokter
        $dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $dayOfWeek = date('w', strtotime($tanggal)); // 0 (Minggu) sampai 6 (Sabtu)
        $dayName = $dayNames[$dayOfWeek];
        
        if ($dayName !== $jadwal['hari']) {
            return redirect()->back()->withInput()->with('error', "Tanggal {$tanggal} bukan hari {$jadwal['hari']}. Silakan pilih tanggal yang sesuai.");
        }
        
        // Jika waktu sudah diset dari form (melalui hidden input)
        $waktu_mulai = $this->request->getPost('waktu_mulai');
        $waktu_selesai = $this->request->getPost('waktu_selesai');
        
        // Jika waktu tidak diset, cari slot yang tersedia
        if (empty($waktu_mulai) || empty($waktu_selesai)) {
            // Dapatkan durasi jenis perawatan
            $jenis = $this->jenisModel->find($idjenis);
            if (!$jenis) {
                return redirect()->back()->withInput()->with('error', 'Jenis perawatan tidak ditemukan');
            }
            
            $durasi_menit = $jenis['estimasi'];
            
            // Cari slot waktu yang tersedia
            $slot = $this->bookingModel->findAvailableSlotFromSchedule($idjadwal, $tanggal, $durasi_menit);
            
            if (!$slot) {
                return redirect()->back()->withInput()->with('error', 'Tidak ada slot waktu tersedia pada jadwal yang dipilih');
            }
            
            $waktu_mulai = $slot['waktu_mulai'];
            $waktu_selesai = $slot['waktu_selesai'];
        }
        
        // Validasi waktu (waktu selesai harus lebih dari waktu mulai)
        if (strtotime($waktu_selesai) <= strtotime($waktu_mulai)) {
            return redirect()->back()->withInput()->with('error', 'Waktu selesai harus lebih dari waktu mulai');
        }
        
        // Validasi apakah slot waktu tersedia (tidak bentrok dengan booking lain)
        $is_available = $this->bookingModel->isSlotAvailable(
            $idjadwal,
            $tanggal,
            $waktu_mulai,
            $waktu_selesai,
            $id
        );
        
        if (!$is_available) {
            return redirect()->back()->withInput()->with('error', 'Slot waktu yang dipilih tidak tersedia (bentrok dengan booking lain)');
        }
        
        $data = [
            'id_pasien' => $this->request->getPost('id_pasien'),
            'idjadwal' => $idjadwal,
            'idjenis' => $idjenis,
            'tanggal' => $tanggal,
            'waktu_mulai' => $waktu_mulai,
            'waktu_selesai' => $waktu_selesai,
            'status' => $status,
            'catatan' => $this->request->getPost('catatan')
        ];
        
        $this->bookingModel->update($id, $data);
        
        return redirect()->to(site_url('booking'))->with('message', 'Data booking berhasil diperbarui');
    }
    
    public function delete($id = null)
    {
        $booking = $this->bookingModel->find($id);
        
        if (!$booking) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data booking tidak ditemukan'
            ]);
        }
        
        $this->bookingModel->delete($id);
        
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data booking berhasil dihapus'
        ]);
    }
    
    // Method untuk mendapatkan jadwal dengan nama dokter
    private function getJadwalWithDokter()
    {
        $db = db_connect();
        $jadwal = $db->table('jadwal')
            ->select('jadwal.*, dokter.nama as nama_dokter')
            ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
            ->where('jadwal.is_active', 1)
            ->get()
            ->getResultArray();
        
        return $jadwal;
    }
    
    // API untuk mendapatkan slot waktu tersedia
    public function getAvailableSlot()
    {
        $idjadwal = $this->request->getGet('idjadwal');
        $tanggal = $this->request->getGet('tanggal');
        $idjenis = $this->request->getGet('idjenis');
        $is_walk_in = filter_var($this->request->getGet('is_walk_in'), FILTER_VALIDATE_BOOLEAN);
        
        // Set timezone ke Waktu Indonesia Barat (WIB)
        date_default_timezone_set('Asia/Jakarta');
        
        // Dapatkan jadwal
        $jadwal = $this->jadwalModel->find($idjadwal);
        if (!$jadwal) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Jadwal tidak ditemukan'
            ]);
        }
        
        // Validasi apakah tanggal sesuai dengan hari jadwal dokter
        $dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $dayOfWeek = date('w', strtotime($tanggal)); // 0 (Minggu) sampai 6 (Sabtu)
        $dayName = $dayNames[$dayOfWeek];
        
        if ($dayName !== $jadwal['hari']) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => "Tanggal {$tanggal} bukan hari {$jadwal['hari']}. Silakan pilih tanggal yang sesuai."
            ]);
        }
        
        // Validasi apakah waktu jadwal untuk hari ini sudah lewat
        $today = date('Y-m-d');
        if ($tanggal == $today) {
            $currentTime = date('H:i:s');
            
            // Jika waktu saat ini sudah lewat dari waktu awal jadwal
            if ($currentTime > $jadwal['waktu_mulai']) {
                // Untuk booking langsung (walk-in), tetap perbolehkan jika masih dalam rentang jadwal
                if ($is_walk_in && $currentTime < $jadwal['waktu_selesai']) {
                    // Lanjutkan proses booking
                } else if (!$is_walk_in) {
                    // Jika waktu sekarang sudah melewati jadwal dan ditambah 30 menit untuk booking online
            $timeBuffer = date('H:i:s', strtotime($currentTime) + (30 * 60));
            
            $timeBufferTimestamp = strtotime("2000-01-01 $timeBuffer");
            $jadwalEndTimestamp = strtotime("2000-01-01 {$jadwal['waktu_selesai']}");
            
            if ($timeBufferTimestamp >= $jadwalEndTimestamp) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => "Tidak ada slot waktu tersedia untuk hari ini. Silakan booking untuk hari lain."
                ]);
                    }
                } else {
                    // Jika waktu saat ini sudah melewati waktu selesai jadwal
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => "Jadwal dokter untuk hari ini sudah selesai. Silakan booking untuk hari lain."
                    ]);
                }
            }
        }
        
        // Dapatkan durasi jenis perawatan
        $jenis = $this->jenisModel->find($idjenis);
        if (!$jenis) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Jenis perawatan tidak ditemukan'
            ]);
        }
        
        $durasi_menit = $jenis['estimasi'];
        
        // Cari slot waktu yang tersedia berdasarkan jadwal dokter
        $slot = $this->bookingModel->findAvailableSlotFromSchedule($idjadwal, $tanggal, $durasi_menit);
        
        if (!$slot) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Tidak ada slot waktu tersedia'
            ]);
        }
        
        // Jika ini adalah booking langsung (walk-in) dan tanggal hari ini
        if ($is_walk_in && $tanggal == $today) {
            $currentTime = date('H:i:s');
            
            // Cek apakah ada booking sebelumnya pada tanggal tersebut
            $existingBookings = $this->bookingModel->where('idjadwal', $idjadwal)
                              ->where('tanggal', $tanggal)
                              ->where('status !=', 'ditolak')
                              ->countAllResults();
            
            // Jika tidak ada booking lain, gunakan waktu saat ini (WIB)
            if ($existingBookings == 0) {
                // Hanya gunakan waktu saat ini jika masih dalam range jadwal
                if ($currentTime >= $jadwal['waktu_mulai'] && $currentTime < $jadwal['waktu_selesai']) {
                    $slot['waktu_mulai'] = $currentTime;
                    $slot['waktu_selesai'] = date('H:i:s', strtotime($currentTime) + ($durasi_menit * 60));
                }
            }
        }
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => [
                'waktu_mulai' => $slot['waktu_mulai'],
                'waktu_selesai' => $slot['waktu_selesai'],
                'durasi' => $durasi_menit
            ]
        ]);
    }
} 