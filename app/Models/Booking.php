<?php

namespace App\Models;

use CodeIgniter\Model;

class Booking extends Model
{
    protected $table            = 'booking';
    protected $primaryKey       = 'idbooking';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'idbooking', 'id_pasien', 'idjadwal', 'idjenis', 'tanggal', 
        'waktu_mulai', 'waktu_selesai', 'status', 'bukti_bayar', 'catatan'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    
    // Cek ketersediaan jadwal
    public function isSlotAvailable($idjadwal, $tanggal, $waktu_mulai, $waktu_selesai, $exclude_id = null)
    {
        $builder = $this->builder();
        $builder->where('idjadwal', $idjadwal);
        $builder->where('tanggal', $tanggal);
        $builder->where('deleted_at IS NULL');
        
        // Kondisi untuk cek overlap waktu
        $builder->groupStart()
            ->where("(waktu_mulai < '$waktu_selesai' AND waktu_selesai > '$waktu_mulai')")
        ->groupEnd();
        
        // Jika ada ID yang dikecualikan (untuk keperluan edit)
        if ($exclude_id) {
            $builder->where('idbooking !=', $exclude_id);
        }
        
        $count = $builder->countAllResults();
        return ($count == 0);
    }
    
    // Mencari slot waktu tersedia dalam range waktu tertentu
    public function findAvailableSlot($idjadwal, $tanggal, $blok_waktu, $durasi_menit)
    {
        // Definisikan waktu blok
        $waktu_mulai_blok = ($blok_waktu == 'Pagi') ? '08:00:00' : '13:00:00';
        $waktu_selesai_blok = ($blok_waktu == 'Pagi') ? '12:00:00' : '17:00:00';
        
        // Ambil semua booking pada jadwal dan tanggal tersebut
        $existing_bookings = $this->where('idjadwal', $idjadwal)
                                 ->where('tanggal', $tanggal)
                                 ->where('waktu_mulai >=', $waktu_mulai_blok)
                                 ->where('waktu_selesai <=', $waktu_selesai_blok)
                                 ->where('status !=', 'ditolak')
                                 ->orderBy('waktu_mulai', 'ASC')
                                 ->findAll();
        
        // Buffer time antar pasien (dalam menit)
        $buffer_time = 10;
        
        // Konversi durasi dan buffer ke format time interval (jam)
        $durasi_jam = $durasi_menit / 60;
        $buffer_jam = $buffer_time / 60;
        
        // Inisialisasi waktu mulai pencarian dengan waktu mulai blok
        $current_time = $waktu_mulai_blok;
        
        // Iterasi melalui existing bookings untuk menemukan slot kosong
        foreach ($existing_bookings as $booking) {
            $slot_end_time = date('H:i:s', strtotime($current_time) + ($durasi_menit * 60));
            
            // Jika slot yang tersedia cukup sebelum booking berikutnya
            if (strtotime($slot_end_time) <= strtotime($booking['waktu_mulai'])) {
                return [
                    'waktu_mulai' => $current_time,
                    'waktu_selesai' => $slot_end_time
                ];
            }
            
            // Update current_time ke akhir booking + buffer
            $current_time = date('H:i:s', strtotime($booking['waktu_selesai']) + ($buffer_time * 60));
        }
        
        // Cek apakah masih ada slot setelah booking terakhir
        $slot_end_time = date('H:i:s', strtotime($current_time) + ($durasi_menit * 60));
        if (strtotime($slot_end_time) <= strtotime($waktu_selesai_blok)) {
            return [
                'waktu_mulai' => $current_time,
                'waktu_selesai' => $slot_end_time
            ];
        }
        
        // Jika tidak ada slot yang tersedia
        return null;
    }
    
    // Mencari slot waktu tersedia berdasarkan jadwal dokter
    public function findAvailableSlotFromSchedule($idjadwal, $tanggal, $durasi_menit, $is_walk_in = false)
    {
        // Set timezone ke Waktu Indonesia Barat (WIB)
        date_default_timezone_set('Asia/Jakarta');
        
        // Get jadwal details
        $db = \Config\Database::connect();
        $jadwal = $db->table('jadwal')
                    ->where('idjadwal', $idjadwal)
                    ->get()
                    ->getRowArray();
        
        if (!$jadwal) {
            return null;
        }
        
        // Validasi apakah tanggal sesuai dengan hari jadwal dokter
        $dayNames = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $dayOfWeek = date('w', strtotime($tanggal)); // 0 (Minggu) sampai 6 (Sabtu)
        $dayName = $dayNames[$dayOfWeek];
        
        if ($dayName !== $jadwal['hari']) {
            return null; // Tanggal tidak sesuai dengan hari jadwal
        }
        
        // Ambil waktu mulai dan selesai dari jadwal dokter
        $waktu_mulai_jadwal = $jadwal['waktu_mulai'];
        $waktu_selesai_jadwal = $jadwal['waktu_selesai'];
        
        // Ambil semua booking pada jadwal dan tanggal tersebut
        $existing_bookings = $this->where('idjadwal', $idjadwal)
                                 ->where('tanggal', $tanggal)
                                 ->where('status !=', 'ditolak')
                                 ->orderBy('waktu_mulai', 'ASC')
                                 ->findAll();
        
        // Buffer time antar pasien (dalam menit)
        $buffer_time = 10;
        
        // Jika ada booking sebelumnya, gunakan waktu selesai booking terakhir + buffer
        if (count($existing_bookings) > 0) {
            $lastBooking = end($existing_bookings);
            $current_time = date('H:i:s', strtotime($lastBooking['waktu_selesai']) + ($buffer_time * 60));
        } else {
            // Jika tidak ada booking, perlu tentukan waktu mulai berdasarkan apakah ini tanggal hari ini atau masa depan
            $today = date('Y-m-d');
            
            // Jika tanggal yang dipilih adalah tanggal hari ini
            if ($tanggal == $today) {
                $currentTime = date('H:i:s');
                
                // Jika waktu saat ini masih dalam range jadwal
                if ($currentTime > $waktu_mulai_jadwal && $currentTime < $waktu_selesai_jadwal) {
                    // Tambahkan buffer berdasarkan jenis booking
                    $buffer_minutes = $is_walk_in ? 0 : 30; // Jika walk-in, tidak perlu buffer, jika online perlu 30 menit
                    $waktu_mulai_minimal = date('H:i:s', strtotime($currentTime) + ($buffer_minutes * 60));
                    
                    // Waktu mulai adalah waktu saat ini + buffer
                    $current_time = $waktu_mulai_minimal;
                } else if ($currentTime <= $waktu_mulai_jadwal) {
                    // Jika waktu saat ini sebelum jadwal dimulai
                    $current_time = $waktu_mulai_jadwal;
                } else {
                    // Jika waktu saat ini sudah melewati jadwal
                    return null; // Tidak ada slot tersedia
                }
            } else {
                // Jika tanggal di masa depan, gunakan waktu awal jadwal
                $current_time = $waktu_mulai_jadwal;
            }
        }
        
        // Jika waktu mulai yang disesuaikan sudah melewati waktu selesai jadwal, tidak ada slot tersedia
        $startTimestamp = strtotime("2000-01-01 $current_time");
        $endTimestamp = strtotime("2000-01-01 $waktu_selesai_jadwal");
        
        if ($startTimestamp >= $endTimestamp) {
            return null;
        }
        
        // Hitung waktu slot berdasarkan current_time dan durasi
        $slot_end_time = date('H:i:s', strtotime($current_time) + ($durasi_menit * 60));
        
        // Periksa apakah slot berakhir dalam waktu jadwal
        $slotEndTimestamp = strtotime("2000-01-01 $slot_end_time");
        
        if ($slotEndTimestamp <= $endTimestamp) {
            return [
                'waktu_mulai' => $current_time,
                'waktu_selesai' => $slot_end_time
            ];
        }
        
        // Jika tidak ada slot yang tersedia
        return null;
    }
} 