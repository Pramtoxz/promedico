<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DetailPerawatan;
use App\Models\Obat;
use App\Models\Perawatan;
use App\Models\Booking;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;

class DokterDashboardController extends BaseController
{
    public function CekPasien()
    {
        $title = [
            'title' => 'Cek Pasien'
        ];
        return view('Rdokter/cekpasien', $title);
    }

    public function viewCekPasien()
    {
        $db = db_connect();
        $query = $db->table('pasien')
                    ->select('id_pasien, nama, nohp, jenkel');

        return DataTable::of($query)
        ->add('action', function ($row) {
            $button1 = '<button type="button" class="btn btn-primary btn-sm btn-detail" data-id_pasien="' . $row->id_pasien . '" data-toggle="modal" data-target="#detailModal"><i class="fas fa-eye"></i></button>';            
            $buttonsGroup = '<div style="display: flex;">' . $button1 . '</div>';
            return $buttonsGroup;
            }, 'last')
            ->edit('jenkel', function ($row) {
                return $row->jenkel == 'L' ? 'Laki-laki' : 'Perempuan';
            })
            ->addNumbering()
            ->toJson();
    }



    public function DetailPasien($id_pasien)
    {
        $db = db_connect();
        $pasien = $db->table('pasien')
            ->select('*')
            ->where('id_pasien', $id_pasien)
            ->get()
            ->getRowArray();

        if (!$pasien) {
            return redirect()->back()->with('error', 'Data pasien tidak ditemukan');
        }

        $data = [
            'pasien' => $pasien
        ];

        return view('Rdokter/detailpasien', $data);
    }




     public function CekPerawatan()
    {
        $title = [
            'title' => 'Cek Perawatan'
        ];
        return view('Rdokter/cekperawatan', $title);
    }

    public function viewCekPerawatan()
    {
        $db = db_connect();
        $query = $db->table('perawatan')
                    ->select('perawatan.idperawatan as kode_perawatan, perawatan.tanggal, pasien.id_pasien, pasien.nama as nama_pasien, booking.catatan, jenis_perawatan.namajenis as nama_jenis, booking.status')
                    ->join('booking', 'booking.idbooking = perawatan.idbooking', 'left')
                    ->join('pasien', 'pasien.id_pasien = booking.id_pasien', 'left')
                    ->join('jenis_perawatan', 'jenis_perawatan.idjenis = booking.idjenis', 'left')
                    ->whereIn('booking.status', ['diperiksa', 'selesai']);

        return DataTable::of($query)
        ->add('action', function ($row) {
            $button1 = '<button type="button" class="btn btn-primary btn-sm btn-detail" data-kode_perawatan="' . $row->kode_perawatan . '" data-toggle="modal" data-target="#detailModal"><i class="fas fa-eye"></i></button>';
            // Jika status selesai, sembunyikan tombol resep
            $button2 = '';
            if ($row->status == 'diperiksa') {
                $button2 = '<button type="button" class="btn btn-warning btn-sm btn-resep" data-kode_perawatan="' . $row->kode_perawatan . '" style="margin-left: 5px;"><i class="fas fa-pencil-alt"></i></button>';
            }
            $buttonsGroup = '<div style="display: flex;">' . $button1 . $button2 . '</div>';
            return $buttonsGroup;
            }, 'last')
            ->edit('tanggal', function ($row) {
                return date('d-m-Y', strtotime($row->tanggal));
            })
            ->edit('status', function ($row) {
                return $row->status == 'diperiksa' ? '<span class="badge badge-warning">Diperiksa</span>' : '<span class="badge badge-success">Selesai</span>';
            })
            ->addNumbering()
            ->toJson();
    }

    public function FormResep($kode_perawatan)
    {
        
        $db = db_connect();
        $query = $db->table('perawatan')
                    ->select('perawatan.idperawatan as kode_perawatan, perawatan.tanggal, pasien.id_pasien, pasien.nama as nama_pasien, booking.catatan, jenis_perawatan.namajenis as nama_jenis, booking.status, perawatan.resep')
                    ->join('booking', 'booking.idbooking = perawatan.idbooking', 'left')
                    ->join('pasien', 'pasien.id_pasien = booking.id_pasien', 'left')
                    ->join('jenis_perawatan', 'jenis_perawatan.idjenis = booking.idjenis', 'left')
                    ->where('perawatan.idperawatan', $kode_perawatan);

                 $perawatan = $query->get()->getRowArray();

        if (!$perawatan) {
            return redirect()->back()->with('error', 'Data perawatan tidak ditemukan');
        }
        $data = [
            'title' => 'Form Resep',
            'kode_perawatan' => $kode_perawatan,
            'perawatan' => $perawatan
        ];
        return view('Rdokter/formresep', $data);
    }

    
    public function saveResep()
    {
        if ($this->request->isAJAX()) {
            $kode_perawatan = $this->request->getPost('kode_perawatan');
            $resep = $this->request->getPost('resep');
            
            $rules = [
                'resep' => [
                    'label' => 'Resep',
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Mohon Maaf Dokter, Resep ini wajib diisi',
                    ]
                ],
            ];

            if (!$this->validate($rules)) {
                $errors = [];
                foreach ($rules as $field => $rule) {
                    $errors["error_$field"] = $this->validator->getError($field);
                }

                $json = [
                    'error' => $errors
                ];
            } else {
                $model = new Perawatan();
                $dataUpdate = [
                    'resep' => $resep
                ];
                
                $model->update($kode_perawatan, $dataUpdate);
                
                $json = [
                    'sukses' => 'Data Resep berhasil diupdate'
                ];
            }
            return $this->response->setJSON($json);
        }
    }

    public function DetailPerawatan($kode_perawatan)
    {
        $db = db_connect();
        $query = $db->table('perawatan')
                    ->select('perawatan.idperawatan as kode_perawatan, perawatan.tanggal, pasien.id_pasien, pasien.nama as nama_pasien, booking.catatan, jenis_perawatan.namajenis as nama_jenis, booking.status,booking.catatan, perawatan.resep, perawatan.idperawatan')
                    ->join('booking', 'booking.idbooking = perawatan.idbooking', 'left')
                    ->join('pasien', 'pasien.id_pasien = booking.id_pasien', 'left')
                    ->join('jenis_perawatan', 'jenis_perawatan.idjenis = booking.idjenis', 'left')
                    ->where('perawatan.idperawatan', $kode_perawatan);

                 $perawatan = $query->get()->getRowArray();

        if (!$perawatan) {
            return redirect()->back()->with('error', 'Data perawatan tidak ditemukan');
        }

        $data = [
            'perawatan' => $perawatan
        ];

        return view('Rdokter/detailperawatan', $data);
    }
}