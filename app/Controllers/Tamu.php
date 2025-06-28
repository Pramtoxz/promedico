<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\TamuModel;
use Hermawan\DataTables\DataTable;

class Tamu extends BaseController
{
    protected $tamuModel;

    public function __construct()
    {
        $this->tamuModel = new TamuModel();
    }

    public function index()
    {
        $title = 'Data Tamu';
        return view('Tamu/datatamu', compact('title'));
    }

    public function viewTamu()
    {
        $db = db_connect();
        $builder = $db->table('tamu')
            ->select('nik, nama, jenkel, tgllahir,nohp, alamat, iduser');

        return DataTable::of($builder)
            ->addNumbering()
            ->format('iduser', function($value) {
                return ''; // Agar iduser tidak tampil sebagai kolom
            })
            ->add('action', function ($row) {
                $actionButtons = '<div class="action-wrapper">
                    <div class="action-dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow shadow-none" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="icon-base ri ri-more-2-line icon-18px"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item btn-detail" href="javascript:void(0);" data-id="' . $row->nik . '">
                                <i class="icon-base ri ri-eye-line icon-18px me-1"></i> Detail
                            </a>
                            <a class="dropdown-item" href="' . base_url('tamu/edit/' . $row->nik) . '">
                                <i class="icon-base ri ri-pencil-line icon-18px me-1"></i> Edit
                            </a>
                            <a class="dropdown-item btn-delete" href="javascript:void(0);" data-id="' . $row->nik . '" data-name="' . ($row->nama ? $row->nama : 'Tamu ID ' . $row->nik) . '">
                                <i class="icon-base ri ri-delete-bin-6-line icon-18px me-1"></i> Delete
                            </a>
                        </div>
                    </div>';
                
                // Tambahkan tombol kunci jika iduser masih kosong
                if (empty($row->iduser)) {
                    $actionButtons .= ' <button type="button" class="btn p-0 btn-create-user" data-id="' . $row->nik . '" data-name="' . $row->nama . '" title="Buat User">
                        <i class="icon-base ri ri-key-2-line icon-18px"></i>
                    </button>';
                }
                
                $actionButtons .= '</div>';
                
                return $actionButtons;
            }, 'last')
            ->hide('iduser') // Sembunyikan kolom iduser
            ->edit('jenkel', function($value) {
                return $value == 'L' ? 'Perempuan' : 'Laki-laki';
            })
            ->toJson();
    }

    public function getTamuDetail()
    {
        if ($this->request->isAJAX()) {
            $nik = $this->request->getPost('id');
            $tamu = $this->tamuModel->find($nik);
            
            if ($tamu) {
                return $this->response->setJSON([
                    'success' => true,
                    'data' => $tamu
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Tamu tidak ditemukan'
                ]);
            }
        }
        return redirect()->to('tamu');
    }

    public function createTamu()
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
        
        if ($this->tamuModel->save($data)) {
            return redirect()->to('tamu')->with('message', 'Tamu berhasil ditambahkan');
        }
        
        return redirect()->back()->withInput()->with('errors', $this->tamuModel->errors());
    }

    public function editTamu($nik = null)
    {
        if ($nik === null) {
            return redirect()->to('tamu')->with('error', 'Tamu tidak ditemukan');
        }
        
        $tamu = $this->tamuModel->find($nik);
        if (!$tamu) {
            return redirect()->to('tamu')->with('error', 'Tamu tidak ditemukan');
        }
        
        $title = 'Edit Tamu';
        return view('Tamu/edit', compact('title', 'tamu'));
    }

    public function updateTamu($nik = null)
    {
        if ($nik === null) {
            return redirect()->to('tamu')->with('error', 'Tamu tidak ditemukan');
        }
        
        $tamu = $this->tamuModel->find($nik);
        if (!$tamu) {
            return redirect()->to('tamu')->with('error', 'Tamu tidak ditemukan');
        }
        
        $rules = [
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
            'nik' => $nik, // NIK sebagai primary key, tidak bisa diubah
            'nama' => $this->request->getPost('nama'),
            'nohp' => $this->request->getPost('nohp'),
            'jenkel' => $this->request->getPost('jenkel'),
            'tgllahir' => $this->request->getPost('tgllahir'),
            'alamat' => $this->request->getPost('alamat')
        ];
        
        if ($this->tamuModel->save($data)) {
            return redirect()->to('tamu')->with('message', 'Tamu berhasil diupdate');
        }
        
        return redirect()->back()->withInput()->with('errors', $this->tamuModel->errors());
    }

    public function deleteTamu()
    {
        if ($this->request->isAJAX()) {
            $nik = $this->request->getPost('id');
            if ($this->tamuModel->delete($nik)) {
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
            $tamu = $this->tamuModel->find($nik);
            
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
                $this->tamuModel->update($nik, ['iduser' => $userId]);
                
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
