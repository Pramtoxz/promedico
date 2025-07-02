<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Kamar;
use Hermawan\DataTables\DataTable;

class KamarController extends BaseController
{
    protected $Kamar;

    public function __construct()
    {
        $this->Kamar = new Kamar();
    }

    public function index()
    {
        $title = 'Data Kamar';
        return view('Kamar/datakamar', compact('title'));
    }

    public function viewKamar()
    {
        $db = db_connect();
        $builder = $db->table('kamar')
            ->select('idkamar, nama, harga, status_kamar');

        return DataTable::of($builder)
            ->addNumbering()
            ->add('action', function ($row) {
                $actionButtons = '<div class="action-wrapper">
                    <div class="action-dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow shadow-none" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="icon-base ri ri-more-2-line icon-18px"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item btn-detail" href="javascript:void(0);" data-id="' . $row->idkamar . '">
                                <i class="icon-base ri ri-eye-line icon-18px me-1"></i> Detail
                            </a>
                            <a class="dropdown-item" href="' . base_url('kamar/edit/' . $row->idkamar) . '">
                                <i class="icon-base ri ri-pencil-line icon-18px me-1"></i> Edit
                            </a>
                            <a class="dropdown-item btn-delete" href="javascript:void(0);" data-id="' . $row->idkamar . '" data-name="' . ($row->nama ? $row->nama : 'Kamar ID ' . $row->idkamar) . '">
                                <i class="icon-base ri ri-delete-bin-6-line icon-18px me-1"></i> Delete
                            </a>
                        </div>
                    </div>';
                
                $actionButtons .= '</div>';
                return $actionButtons;
            }, 'last')
            ->edit('status_kamar', function ($row) {
                return $row->status_kamar == 1 ? 'Tersedia' : 'Tidak Tersedia';
            })
            ->toJson();
    }

    public function getKamarDetail()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $kamar = $this->Kamar->find($id);

            if ($kamar) {
                return $this->response->setJSON([
                    'success' => true,
                    'data' => $kamar
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Kamar tidak ditemukan'
                ]);
            }
        }
        return redirect()->to('kamar');
    }

    public function createKamar()
    {
        $title = 'Tambah Tamu';
        return view('Tamu/tambah', compact('title'));
    }

    public function storeTamu()
    {
        $rules = [
            'nik' => 'required|is_unique[tamu.nik]',
            'nama' => 'required',
            'nohp' => 'required',
            'jenkel' => 'required',
            'tgllahir' => 'required|valid_date',
            'alamat' => 'required'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'nik' => $this->request->getPost('nik'),
            'nama' => $this->request->getPost('nama'),
            'nohp' => $this->request->getPost('nohp'),
            'jenkel' => $this->request->getPost('jenkel'),
            'tgllahir' => $this->request->getPost('tgllahir'),
            'alamat' => $this->request->getPost('alamat')
        ];
        
        $this->Tamu->insert($data);
        return redirect()->to('tamu')->with('message', 'Tamu berhasil ditambahkan');
    }

    public function editTamu($nik = null)
    {
        if ($nik === null) {
            return redirect()->to('tamu')->with('error', 'Tamu tidak ditemukan');
        }
        
        $tamu = $this->Tamu->find($nik);
        if (!$tamu) {
            return redirect()->to('tamu')->with('error', 'Tamu tidak ditemukan');
        }
        
        $title = 'Edit Tamu';
        return view('Tamu/edit', compact('title', 'tamu'));
    }

   public function updateTamu($nik = null)
{
    if ($nik === null) {
        return redirect()->to('tamu')->with('error', 'NIK tidak ditemukan.');
    }

    $existing = $this->Tamu->find($nik);
    if (!$existing) {
        return redirect()->to('tamu')->with('error', 'Data tamu tidak ditemukan.');
    }

    $rules = [
        'nama'     => 'required',
        'nohp'     => 'required',
        'jenkel'   => 'required|in_list[L,P]',
        'tgllahir' => 'required|valid_date',
        'alamat'   => 'required'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $data = [
        'nik'      => $nik,
        'nama'     => $this->request->getPost('nama'),
        'nohp'     => $this->request->getPost('nohp'),
        'jenkel'   => $this->request->getPost('jenkel'),
        'tgllahir' => $this->request->getPost('tgllahir'),
        'alamat'   => $this->request->getPost('alamat')
    ];  

    // Bandingkan apakah ada perubahan
    if ($existing == $data) {
        return redirect()->to('tamu')->with('info', 'Tidak ada perubahan data.');
    }

    if ($this->Tamu->update($nik, $data)) {
        return redirect()->to('tamu')->with('message', 'Data tamu berhasil diperbarui.');
    }

    log_message('error', 'Gagal update tamu NIK: ' . $nik . ', error: ' . print_r($this->Tamu->errors(), true));
    return redirect()->back()->withInput()->with('errors', $this->Tamu->errors());
}

    public function deleteTamu()
    {
        if ($this->request->isAJAX()) {
            $nik = $this->request->getPost('id');
            if ($this->Tamu->delete($nik)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Tamu berhasil dihapus']);
            }
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus tamu']);
        }
        return redirect()->to('tamu');
    }

    public function createUserForTamu()
    {
        if ($this->request->isAJAX()) {
            $nik = $this->request->getPost('nik');
            $tamu = $this->Tamu->find($nik);
            
            if (!$tamu) {
                return $this->response->setJSON(['success' => false, 'message' => 'Tamu tidak ditemukan']);
            }
            
            $rules = [
                'username' => 'required|min_length[4]|max_length[50]|is_unique[users.username]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
            ];
            
            if (!$this->validate($rules)) {
                return $this->response->setJSON(['success' => false, 'errors' => $this->validator->getErrors()]);
            }
            
            // Load UserModel
            $userModel = new \App\Models\UserModel();
            
            // Data user baru
            $userData = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
                'role' => 'user',
                'status' => 'active'
            ];
            
            // Simpan user baru
            $userId = $userModel->insert($userData);
            
            if ($userId) {
                // Update tamu dengan iduser baru
                $this->Tamu->update($nik, ['iduser' => $userId]);
                
                return $this->response->setJSON([
                    'success' => true, 
                    'message' => 'User berhasil dibuat untuk tamu ' . $tamu['nama']
                ]);
            }
            
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Gagal membuat user'
            ]);
        }
        
        return redirect()->to('tamu');
    }
}
