<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Booking as ModelsBooking;
use App\Models\Jadwal;
use App\Models\Jenis;
use App\Models\Pasien;
use App\Models\Dokter;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;

class BookingController extends BaseController
{
    public function index()
    {
        $title = [
            'title' => 'Kelola Data Booking'
        ];
        return view('booking/databooking', $title);
    }

    public function viewBooking()
    {
        $db = db_connect();
        $query = $db->table('booking')
                    ->select('booking.idbooking, booking.tanggal,pasien.nama as nama_pasien,dokter.nama as nama_dokter, booking.waktu_mulai, booking.waktu_selesai, booking.status')
                    ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
                    ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
                    ->join('pasien', 'pasien.id_pasien = booking.id_pasien')
                    ->join('jenis_perawatan', 'jenis_perawatan.idjenis = booking.idjenis');

        return DataTable::of($query)
        ->edit('status', function ($row) {
            $statusClass = '';
            $statusText = ucfirst($row->status);
            
            switch($row->status) {
                case 'pending':
                    $statusClass = 'badge badge-warning';
                    break;
                case 'diterima':
                    $statusClass = 'badge badge-success';
                    break;
                case 'ditolak':
                    $statusClass = 'badge badge-danger';
                    break;
                default:
                    $statusClass = 'badge badge-secondary';
            }
            
            return '<span class="' . $statusClass . '">' . $statusText . '</span>';
        })
        ->add('action', function ($row) {
            $button1 = '<button type="button" class="btn btn-primary btn-sm btn-detail" data-idbooking="' . $row->idbooking . '" data-toggle="modal" data-target="#detailModal"><i class="fas fa-eye"></i></button>';
            $button2 = '<button type="button" class="btn btn-secondary btn-sm btn-edit" data-idbooking="' . $row->idbooking . '" style="margin-left: 5px;"><i class="fas fa-pencil-alt"></i></button>';
            $button3 = '<button type="button" class="btn btn-danger btn-sm btn-delete" data-idbooking="' . $row->idbooking . '" style="margin-left: 5px;"><i class="fas fa-trash"></i></button>';
            
            // Tombol untuk ubah status
            $buttonApprove = '';
            $buttonReject = '';
            
            if ($row->status == 'pending') {
                $buttonApprove = '<button type="button" class="btn btn-success btn-sm btn-approve" data-idbooking="' . $row->idbooking . '" style="margin-left: 5px;"><i class="fas fa-check"></i></button>';
                $buttonReject = '<button type="button" class="btn btn-danger btn-sm btn-reject" data-idbooking="' . $row->idbooking . '" style="margin-left: 5px;"><i class="fas fa-times"></i></button>';
            }
            
            $buttonsGroup = '<div style="display: flex;">' . $button1 . $button2 . $button3 . $buttonApprove . $buttonReject . '</div>';
            return $buttonsGroup;
        }, 'last')
        ->edit('tanggal', function ($row) {
            return date('d-m-Y', strtotime($row->tanggal));
        })
        ->addNumbering()
        ->toJson();
    }

    public function formtambah()
    {
        $db = db_connect();
        $query = $db->query("SELECT CONCAT('BK', LPAD(IFNULL(MAX(SUBSTRING(idbooking, 3)) + 1, 1), 4, '0')) AS next_number FROM booking");
        $row = $query->getRow();
        $next_number = $row->next_number;
        
        // Ambil data pasien
        $pasienModel = new Pasien();
        $pasien = $pasienModel->findAll();
        
        // Ambil data jadwal
        $jadwalModel = new Jadwal();
        $jadwal = $db->table('jadwal')
                 ->select('jadwal.idjadwal, jadwal.hari, jadwal.waktu_mulai, jadwal.waktu_selesai, dokter.nama as nama_dokter')
                 ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
                 ->where('jadwal.is_active', 1)
                 ->get()->getResultArray();
                 
        // Ambil data jenis perawatan
        $jenisModel = new Jenis();
        $jenis = $jenisModel->findAll();
        
        $data = [
            'next_number' => $next_number,
            'pasien' => $pasien,
            'jadwal' => $jadwal,
            'jenis' => $jenis
        ];
        
        return view('booking/formtambah', $data);
    }

    public function save()
    {
        if ($this->request->isAJAX()) {
            $idbooking = $this->request->getPost('idbooking');
            $id_pasien = $this->request->getPost('id_pasien');
            $idjadwal = $this->request->getPost('idjadwal');
            $idjenis = $this->request->getPost('idjenis');
            $tanggal = $this->request->getPost('tanggal');
            $waktu_mulai = $this->request->getPost('waktu_mulai');
            $waktu_selesai = $this->request->getPost('waktu_selesai');
            $status = $this->request->getPost('status');
            $catatan = $this->request->getPost('catatan');
            $bukti_bayar = $this->request->getFile('bukti_bayar');

            $rules = [
                'id_pasien' => [
                    'label' => 'Pasien',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ],
                'idjadwal' => [
                    'label' => 'Jadwal',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ],
                'idjenis' => [
                    'label' => 'Jenis Perawatan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ],
                'tanggal' => [
                    'label' => 'Tanggal Booking',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'waktu_mulai' => [
                    'label' => 'Waktu Mulai',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'waktu_selesai' => [
                    'label' => 'Waktu Selesai',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ];

            // Jika bukti_bayar diupload, tambahkan validasi
            if ($bukti_bayar && $bukti_bayar->isValid()) {
                $rules['bukti_bayar'] = [
                    'label' => 'Bukti Pembayaran',
                    'rules' => 'mime_in[bukti_bayar,image/jpg,image/jpeg,image/png,application/pdf]|max_size[bukti_bayar,2048]',
                    'errors' => [
                        'mime_in' => 'Format file tidak didukung. Gunakan JPG, JPEG, PNG, atau PDF',
                        'max_size' => 'Ukuran file maksimal 2MB',
                    ]
                ];
            }

            if (!$this->validate($rules)) {
                $errors = [];
                foreach ($rules as $field => $rule) {
                    if ($this->validator->hasError($field)) {
                        $errors["error_$field"] = $this->validator->getError($field);
                    }
                }

                $json = [
                    'error' => $errors
                ];
                return $this->response->setJSON($json);
            }

            // Cek ketersediaan jadwal
            $bookingModel = new ModelsBooking();
            $isAvailable = $bookingModel->isSlotAvailable($idjadwal, $tanggal, $waktu_mulai, $waktu_selesai);

            if (!$isAvailable) {
                $json = [
                    'error' => [
                        'error_jadwal' => 'Jadwal sudah terisi pada waktu tersebut. Silahkan pilih waktu lain.'
                    ]
                ];
                return $this->response->setJSON($json);
            }

            // Proses upload bukti bayar jika ada
            $bukti_bayar_name = null;
            if ($bukti_bayar && $bukti_bayar->isValid() && !$bukti_bayar->hasMoved()) {
                $newName = 'bukti-' . date('Ymd') . '-' . $idbooking . '.' . $bukti_bayar->getClientExtension();
                $bukti_bayar->move('uploads/bukti_bayar', $newName);
                $bukti_bayar_name = $newName;
            }

            $bookingModel->insert([
                'idbooking' => $idbooking,
                'id_pasien' => $id_pasien,
                'idjadwal' => $idjadwal,
                'idjenis' => $idjenis,
                'tanggal' => $tanggal,
                'waktu_mulai' => $waktu_mulai,
                'waktu_selesai' => $waktu_selesai,
                'status' => $status ?? 'pending',
                'bukti_bayar' => $bukti_bayar_name,
                'catatan' => $catatan
            ]);

            $json = [
                'sukses' => 'Booking berhasil disimpan'
            ];
            
            return $this->response->setJSON($json);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $idbooking = $this->request->getPost('idbooking');

            $model = new ModelsBooking();
            
            // Cek apakah ada file bukti bayar yang perlu dihapus
            $booking = $model->find($idbooking);
            if ($booking && !empty($booking['bukti_bayar'])) {
                $filePath = 'uploads/bukti_bayar/' . $booking['bukti_bayar'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            
            $model->where('idbooking', $idbooking)->delete();

            $json = [
                'sukses' => 'Data Booking berhasil dihapus'
            ];
            return $this->response->setJSON($json);
        }
    }

    public function formedit($idbooking)
    {
        $modelBooking = new ModelsBooking();
        $booking = $modelBooking->find($idbooking);

        if (!$booking) {
            return redirect()->to('/booking')->with('error', 'Data Booking tidak ditemukan');
        }
        
        // Ambil data pasien
        $pasienModel = new Pasien();
        $pasien = $pasienModel->findAll();
        
        // Ambil data jadwal
        $db = db_connect();
        $jadwal = $db->table('jadwal')
                 ->select('jadwal.idjadwal, jadwal.hari, jadwal.waktu_mulai, jadwal.waktu_selesai, dokter.nama as nama_dokter')
                 ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
                 ->where('jadwal.is_active', 1)
                 ->get()->getResultArray();
                 
        // Ambil data jenis perawatan
        $jenisModel = new Jenis();
        $jenis = $jenisModel->findAll();
        
        $data = [
            'booking' => $booking,
            'pasien' => $pasien,
            'jadwal' => $jadwal,
            'jenis' => $jenis
        ];
        
        return view('booking/formedit', $data);
    }

    public function updatedata($idbooking)
    {
        if ($this->request->isAJAX()) {
            $id_pasien = $this->request->getPost('id_pasien');
            $idjadwal = $this->request->getPost('idjadwal');
            $idjenis = $this->request->getPost('idjenis');
            $tanggal = $this->request->getPost('tanggal');
            $waktu_mulai = $this->request->getPost('waktu_mulai');
            $waktu_selesai = $this->request->getPost('waktu_selesai');
            $status = $this->request->getPost('status');
            $catatan = $this->request->getPost('catatan');
            $bukti_bayar = $this->request->getFile('bukti_bayar');

            $rules = [
                'id_pasien' => [
                    'label' => 'Pasien',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ],
                'idjadwal' => [
                    'label' => 'Jadwal',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ],
                'idjenis' => [
                    'label' => 'Jenis Perawatan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} harus dipilih',
                    ]
                ],
                'tanggal' => [
                    'label' => 'Tanggal Booking',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'waktu_mulai' => [
                    'label' => 'Waktu Mulai',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'waktu_selesai' => [
                    'label' => 'Waktu Selesai',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ];

            // Jika bukti_bayar diupload, tambahkan validasi
            if ($bukti_bayar && $bukti_bayar->isValid()) {
                $rules['bukti_bayar'] = [
                    'label' => 'Bukti Pembayaran',
                    'rules' => 'mime_in[bukti_bayar,image/jpg,image/jpeg,image/png,application/pdf]|max_size[bukti_bayar,2048]',
                    'errors' => [
                        'mime_in' => 'Format file tidak didukung. Gunakan JPG, JPEG, PNG, atau PDF',
                        'max_size' => 'Ukuran file maksimal 2MB',
                    ]
                ];
            }

            if (!$this->validate($rules)) {
                $errors = [];
                foreach ($rules as $field => $rule) {
                    if ($this->validator->hasError($field)) {
                        $errors["error_$field"] = $this->validator->getError($field);
                    }
                }

                $json = [
                    'error' => $errors
                ];
                return $this->response->setJSON($json);
            }

            // Cek ketersediaan jadwal
            $bookingModel = new ModelsBooking();
            $isAvailable = $bookingModel->isSlotAvailable($idjadwal, $tanggal, $waktu_mulai, $waktu_selesai, $idbooking);

            if (!$isAvailable) {
                $json = [
                    'error' => [
                        'error_jadwal' => 'Jadwal sudah terisi pada waktu tersebut. Silahkan pilih waktu lain.'
                    ]
                ];
                return $this->response->setJSON($json);
            }

            $dataBooking = $bookingModel->find($idbooking);
            
            // Proses upload bukti bayar jika ada
            $bukti_bayar_name = $dataBooking['bukti_bayar']; // Gunakan yang lama jika tidak ada upload baru
            if ($bukti_bayar && $bukti_bayar->isValid() && !$bukti_bayar->hasMoved()) {
                // Hapus file lama jika ada
                if (!empty($dataBooking['bukti_bayar']) && file_exists('uploads/bukti_bayar/' . $dataBooking['bukti_bayar'])) {
                    unlink('uploads/bukti_bayar/' . $dataBooking['bukti_bayar']);
                }
                
                $newName = 'bukti-' . date('Ymd') . '-' . $idbooking . '.' . $bukti_bayar->getClientExtension();
                $bukti_bayar->move('uploads/bukti_bayar', $newName);
                $bukti_bayar_name = $newName;
            }

            $bookingModel->update($idbooking, [
                'id_pasien' => $id_pasien,
                'idjadwal' => $idjadwal,
                'idjenis' => $idjenis,
                'tanggal' => $tanggal,
                'waktu_mulai' => $waktu_mulai,
                'waktu_selesai' => $waktu_selesai,
                'status' => $status,
                'bukti_bayar' => $bukti_bayar_name,
                'catatan' => $catatan
            ]);

            $json = [
                'sukses' => 'Data Booking berhasil diupdate'
            ];
            
            return $this->response->setJSON($json);
        }
    }
    
    public function detail($idbooking)
    {
        $db = db_connect();
        $booking = $db->table('booking')
            ->select('booking.*, jadwal.hari, dokter.nama as nama_dokter, pasien.nama as nama_pasien, jenis_perawatan.namajenis, jenis_perawatan.estimasi, jenis_perawatan.harga')
            ->join('jadwal', 'jadwal.idjadwal = booking.idjadwal')
            ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
            ->join('pasien', 'pasien.id_pasien = booking.id_pasien')
            ->join('jenis_perawatan', 'jenis_perawatan.idjenis = booking.idjenis')
            ->where('booking.idbooking', $idbooking)
            ->get()
            ->getRowArray();

        if (!$booking) {
            return redirect()->back()->with('error', 'Data booking tidak ditemukan');
        }

        $data = [
            'booking' => $booking
        ];

        return view('booking/detail', $data);
    }
    
    public function updateStatus()
    {
        if ($this->request->isAJAX()) {
            $idbooking = $this->request->getPost('idbooking');
            $status = $this->request->getPost('status');
            
            if (!in_array($status, ['pending', 'diterima', 'ditolak'])) {
                return $this->response->setJSON([
                    'error' => 'Status tidak valid'
                ]);
            }
            
            $model = new ModelsBooking();
            $updated = $model->update($idbooking, ['status' => $status]);
            
            if ($updated) {
                $message = 'Booking berhasil ' . ($status === 'diterima' ? 'diterima' : 'ditolak');
                return $this->response->setJSON([
                    'sukses' => $message
                ]);
            } else {
                return $this->response->setJSON([
                    'error' => 'Gagal mengubah status booking'
                ]);
            }
        }
    }
    
    public function checkSlotAvailability()
    {
        if ($this->request->isAJAX()) {
            $idjadwal = $this->request->getPost('idjadwal');
            $tanggal = $this->request->getPost('tanggal');
            $waktu_mulai = $this->request->getPost('waktu_mulai');
            $waktu_selesai = $this->request->getPost('waktu_selesai');
            $exclude_id = $this->request->getPost('idbooking'); // Optional untuk edit
            
            // Set timezone ke WIB
            date_default_timezone_set('Asia/Jakarta');
            
            // Validasi jadwal
            $db = db_connect();
            $jadwal = $db->table('jadwal')
                       ->where('idjadwal', $idjadwal)
                       ->get()
                       ->getRowArray();
                        
            if (!$jadwal) {
                return $this->response->setJSON([
                    'available' => false,
                    'message' => 'Jadwal tidak ditemukan'
                ]);
            }
            
            // Validasi apakah tanggal sesuai dengan hari jadwal dokter
            $dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            $dayOfWeek = date('w', strtotime($tanggal)); // 0 (Minggu) sampai 6 (Sabtu)
            $dayName = $dayNames[$dayOfWeek];
            
            if ($dayName !== $jadwal['hari']) {
                return $this->response->setJSON([
                    'available' => false,
                    'message' => "Tanggal {$tanggal} bukan hari {$jadwal['hari']}. Silakan pilih tanggal yang sesuai."
                ]);
            }
            
            // Cek apakah waktu berada dalam range jadwal dokter
            if (strtotime($waktu_mulai) < strtotime($jadwal['waktu_mulai']) || 
                strtotime($waktu_selesai) > strtotime($jadwal['waktu_selesai'])) {
                return $this->response->setJSON([
                    'available' => false,
                    'message' => "Waktu yang dipilih di luar jam praktik dokter (" . 
                        substr($jadwal['waktu_mulai'], 0, 5) . " - " . 
                        substr($jadwal['waktu_selesai'], 0, 5) . ")"
                ]);
            }
            
            // Validasi apakah waktu sudah lewat untuk hari ini
            $today = date('Y-m-d');
            if ($tanggal == $today) {
                $currentTime = date('H:i:s');
                if ($currentTime > $waktu_mulai) {
                    return $this->response->setJSON([
                        'available' => false,
                        'message' => "Waktu yang dipilih sudah lewat. Silakan pilih waktu lain."
                    ]);
                }
            }
            
            $bookingModel = new ModelsBooking();
            $isAvailable = $bookingModel->isSlotAvailable($idjadwal, $tanggal, $waktu_mulai, $waktu_selesai, $exclude_id);
            
            if ($isAvailable) {
                return $this->response->setJSON([
                    'available' => true,
                    'message' => 'Slot waktu tersedia'
                ]);
            } else {
                return $this->response->setJSON([
                    'available' => false,
                    'message' => 'Slot waktu sudah terisi. Silakan pilih waktu lain.'
                ]);
            }
        }
    }
    
    public function findAvailableSlot()
    {
        if ($this->request->isAJAX()) {
            $idjadwal = $this->request->getPost('idjadwal');
            $tanggal = $this->request->getPost('tanggal');
            $idjenis = $this->request->getPost('idjenis');
            $is_walk_in = filter_var($this->request->getPost('is_walk_in') ?? false, FILTER_VALIDATE_BOOLEAN);
            
            // Set timezone ke Waktu Indonesia Barat (WIB)
            date_default_timezone_set('Asia/Jakarta');
            
            // Dapatkan jadwal dokter
            $db = db_connect();
            $jadwal = $db->table('jadwal')
                      ->where('idjadwal', $idjadwal)
                      ->get()
                      ->getRowArray();
                       
            if (!$jadwal) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Jadwal dokter tidak ditemukan'
                ]);
            }
            
            // Validasi apakah tanggal sesuai dengan hari jadwal dokter
            $dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            $dayOfWeek = date('w', strtotime($tanggal)); // 0 (Minggu) sampai 6 (Sabtu)
            $dayName = $dayNames[$dayOfWeek];
            
            if ($dayName !== $jadwal['hari']) {
                return $this->response->setJSON([
                    'success' => false,
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
                    } else {
                        // Jika waktu saat ini sudah melewati jadwal ditambah buffer 30 menit untuk online booking
                        $timeBuffer = date('H:i:s', strtotime($currentTime) + (30 * 60));
                        
                        $timeBufferTimestamp = strtotime("2000-01-01 $timeBuffer");
                        $jadwalEndTimestamp = strtotime("2000-01-01 {$jadwal['waktu_selesai']}");
                        
                        if ($timeBufferTimestamp >= $jadwalEndTimestamp) {
                            return $this->response->setJSON([
                                'success' => false,
                                'message' => "Jadwal dokter untuk hari ini pada pukul " . substr($jadwal['waktu_mulai'], 0, 5) . " sudah lewat. Silakan pilih tanggal lain."
                            ]);
                        }
                    }
                }
            }
            
            // Dapatkan durasi dari jenis perawatan
            $jenis = $db->table('jenis_perawatan')
                     ->where('idjenis', $idjenis)
                     ->get()
                     ->getRowArray();
                     
            if (!$jenis) {
                return $this->response->setJSON([
                    'error' => 'Jenis perawatan tidak ditemukan'
                ]);
            }
            
            $durasi_menit = $jenis['estimasi']; // Asumsi estimasi dalam menit
            
            $bookingModel = new ModelsBooking();
            $availableSlot = $bookingModel->findAvailableSlotFromSchedule($idjadwal, $tanggal, $durasi_menit, $is_walk_in);
            
            if ($availableSlot) {
                return $this->response->setJSON([
                    'success' => true,
                    'slot' => $availableSlot,
                    'jadwal' => [
                        'hari' => $jadwal['hari'],
                        'waktu_mulai' => substr($jadwal['waktu_mulai'], 0, 5),
                        'waktu_selesai' => substr($jadwal['waktu_selesai'], 0, 5)
                    ],
                    'perawatan' => [
                        'nama' => $jenis['namajenis'],
                        'durasi' => $durasi_menit,
                        'harga' => $jenis['harga']
                    ]
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Tidak ada slot waktu tersedia pada jadwal yang dipilih'
                ]);
            }
        }
    }
    
    public function getPasien()
    {

        return view('booking/getPasien');
    }

    public function viewGetPasien()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $pasien = $db->table('pasien')
                ->select('id_pasien, nama,jenkel,tgllahir,nohp');
            return DataTable::of($pasien)
                ->add('action', function ($row) {
                    $button1 = '<button type="button" class="btn btn-primary btn-pilihpasien" data-id_pasien="' . $row->id_pasien . '" data-nama_pasien="' . esc($row->nama) . '">Pilih</button>';
                    return $button1;
                }, 'last')
                ->edit('jenkel', function ($row) {
                    return $row->jenkel == 'L' ? 'Laki-laki' : 'Perempuan';
                })
                ->edit('tgllahir', function ($row) {
                    return date('d-m-Y', strtotime($row->tgllahir));
                })
                ->addNumbering()
                ->toJson();
        }
    }
    
    public function viewGetJadwal()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            
            // Set timezone ke WIB
            date_default_timezone_set('Asia/Jakarta');
            
            // Ambil data jadwal yang aktif beserta nama dokter
            $jadwal = $db->table('jadwal')
                ->select('jadwal.idjadwal, jadwal.hari, jadwal.waktu_mulai, jadwal.waktu_selesai, dokter.nama as nama_dokter, jadwal.is_active')
                ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
                ->where('jadwal.is_active', 1);
            
            // Array nama hari untuk validasi tanggal
            $dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            
            // Hari ini 
            $today = date('Y-m-d');
            $currentDay = date('w', strtotime($today)); // 0 (Minggu) sampai 6 (Sabtu)
            $currentDayName = $dayNames[$currentDay];
            $currentTime = date('H:i:s');
            
            return DataTable::of($jadwal)
                ->addNumbering('no')
                ->add('waktu', function($row) {
                    return substr($row->waktu_mulai, 0, 5) . ' - ' . substr($row->waktu_selesai, 0, 5);
                })
                ->add('status', function($row) use ($currentDayName, $currentTime) {
                    $is_today = ($row->hari == $currentDayName);
                    $is_available_today = true;
                    
                    if ($is_today) {
                        $is_available_today = ($currentTime < $row->waktu_selesai);
                    }
                    
                    if ($row->is_active == 1) {
                        if ($is_today && !$is_available_today) {
                            return '<span class="badge badge-warning">Sudah Lewat</span>';
                        } else {
                            return '<span class="badge badge-success">Tersedia</span>';
                        }
                    } else {
                        return '<span class="badge badge-danger">Tidak Aktif</span>';
                    }
                })
                ->add('action', function($row) use ($currentDayName, $currentTime) {
                    $is_today = ($row->hari == $currentDayName);
                    $is_available_today = true;
                    
                    if ($is_today) {
                        $is_available_today = ($currentTime < $row->waktu_selesai);
                    }
                    
                    if ($row->is_active == 1 && (!$is_today || $is_available_today)) {
                        return '<button type="button" class="btn btn-primary btn-pilihjadwal" ' .
                               'data-idjadwal="' . $row->idjadwal . '" ' .
                               'data-nama_dokter="' . $row->nama_dokter . '" ' .
                               'data-hari="' . $row->hari . '" ' .
                               'data-waktu="' . substr($row->waktu_mulai, 0, 5) . ' - ' . substr($row->waktu_selesai, 0, 5) . '">' .
                               '<i class="fas fa-check-circle"></i> Pilih</button>';
                    } else {
                        return '<button type="button" class="btn btn-secondary" disabled>' .
                               '<i class="fas fa-ban"></i> Tidak Tersedia</button>';
                    }
                })
                ->edit('hari', function($row) use ($currentDayName) {
                    if ($row->hari == $currentDayName) {
                        return $row->hari . ' <span class="badge badge-success">Hari ini</span>';
                    }
                    return $row->hari;
                })
                ->toJson();
        }
    }

    public function getJadwal()
    {
        try {
            // Ambil data jadwal yang aktif
            $db = db_connect();
            $jadwal = $db->table('jadwal')
                        ->select('jadwal.idjadwal, jadwal.hari, jadwal.waktu_mulai, jadwal.waktu_selesai, dokter.nama as nama_dokter, jadwal.is_active')
                        ->join('dokter', 'dokter.id_dokter = jadwal.iddokter')
                        ->where('jadwal.is_active', 1)
                        ->get()->getResultArray();

            return view('booking/getJadwal', ['jadwal' => $jadwal]);
        } catch (\Exception $e) {
            log_message('error', 'Error in getJadwal: '.$e->getMessage());
            return 'Error loading jadwal: ' . $e->getMessage();
        }
    }
    
    /**
     * Memeriksa kesesuaian hari dengan tanggal yang dipilih
     */
    public function checkDayMatch()
    {
        if ($this->request->isAJAX()) {
            $idjadwal = $this->request->getPost('idjadwal');
            $tanggal = $this->request->getPost('tanggal');
            
            // Set timezone ke WIB
            date_default_timezone_set('Asia/Jakarta');
            
            // Dapatkan jadwal
            $db = db_connect();
            $jadwal = $db->table('jadwal')
                        ->where('idjadwal', $idjadwal)
                        ->get()
                        ->getRowArray();
                        
            if (!$jadwal) {
                return $this->response->setJSON([
                    'match' => false,
                    'message' => 'Jadwal tidak ditemukan'
                ]);
            }
            
            // Dapatkan hari dari tanggal yang dipilih
            $dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            $dayOfWeek = date('w', strtotime($tanggal)); // 0 (Minggu) sampai 6 (Sabtu)
            $dayName = $dayNames[$dayOfWeek];
            
            $match = ($dayName === $jadwal['hari']);
            
            return $this->response->setJSON([
                'match' => $match,
                'message' => $match ? 'Tanggal sesuai dengan hari jadwal' : 
                    "Tanggal {$tanggal} bukan hari {$jadwal['hari']}. Silakan pilih tanggal yang sesuai."
            ]);
        }
    }
}
