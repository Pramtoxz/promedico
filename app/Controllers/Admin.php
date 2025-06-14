<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;
use Hermawan\DataTables\DataTable;

class Admin extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $title = 'Dashboard';
        return view('dashboard/admin', compact('title'));
    }

    public function users()
    {
        $title = 'Manajemen User';
        return view('Admin/users', compact('title'));
    }

    public function usersDatatable()
    {
        $db = db_connect();
        $builder = $db->table('users')
            ->select('users.id, users.username, users.email, tamu.nama as name, users.status')
            ->join('tamu', 'tamu.iduser = users.id', 'left');

        return DataTable::of($builder)
            ->addNumbering()
            ->edit('status', function ($row) {
                $badge = $row->status == 'active' ? 'bg-label-success' : 'bg-label-danger';
                return '<span class="badge rounded-pill ' . $badge . '">' . ucfirst($row->status) . '</span>';
            })
            ->add('action', function ($row) {
                return '<div class="action-wrapper">
                    <div class="action-dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow shadow-none" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="icon-base ri ri-more-2-line icon-18px"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item btn-detail" href="javascript:void(0);" data-id="' . $row->id . '">
                                <i class="icon-base ri ri-eye-line icon-18px me-1"></i> Detail
                            </a>
                            <a class="dropdown-item" href="' . base_url('admin/users/edit/' . $row->id) . '">
                                <i class="icon-base ri ri-pencil-line icon-18px me-1"></i> Edit
                            </a>
                            <a class="dropdown-item btn-delete" href="javascript:void(0);" data-id="' . $row->id . '" data-name="' . ($row->name ? $row->name : 'User ID ' . $row->id) . '">
                                <i class="icon-base ri ri-delete-bin-6-line icon-18px me-1"></i> Delete
                            </a>
                        </div>
                    </div>
                </div>';
            }, 'last')
            ->hide('id')
            ->toJson();
    }

    public function getUserDetail()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $db = db_connect();
            $user = $db->table('users')
                ->select('users.*, tamu.nama as name')
                ->join('tamu', 'tamu.iduser = users.id', 'left')
                ->where('users.id', $id)
                ->get()
                ->getRowArray();
            
            if ($user) {
                return $this->response->setJSON([
                    'success' => true,
                    'data' => $user,
                    'role_badge' => $this->getRoleBadge($user['role']),
                    'status_badge' => $this->getStatusBadge($user['status'])
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'User tidak ditemukan'
                ]);
            }
        }
        return redirect()->to('admin/users');
    }

    private function getRoleBadge($role)
    {
        $badges = [
            'admin' => '<span class="badge rounded-pill bg-label-primary">Admin</span>',
            'manager' => '<span class="badge rounded-pill bg-label-info">Manager</span>',
            'user' => '<span class="badge rounded-pill bg-label-secondary">User</span>'
        ];
        
        return $badges[$role] ?? '<span class="badge rounded-pill bg-label-secondary">' . ucfirst($role) . '</span>';
    }
    
    private function getStatusBadge($status)
    {
        return $status == 'active' 
            ? '<span class="badge rounded-pill bg-label-success">Active</span>'
            : '<span class="badge rounded-pill bg-label-danger">Inactive</span>';
    }

    public function createUser()
    {
        $title = 'Tambah User Baru';
        return view('Admin/users_create', compact('title'));
    }

    public function storeUser()
    {
        $rules = $this->userModel->getValidationRules();
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'role' => $this->request->getPost('role'),
            'status' => $this->request->getPost('status'),
        ];

        if ($this->userModel->save($data)) {
            return redirect()->to('admin/users')->with('message', 'User berhasil ditambahkan');
        }
        
        return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
    }

    public function editUser($id = null)
    {
        if ($id == null) {
            return redirect()->to('admin/users')->with('error', 'User tidak ditemukan');
        }

        $db = db_connect();
        $user = $db->table('users')
            ->select('users.*, tamu.nama as name')
            ->join('tamu', 'tamu.iduser = users.id', 'left')
            ->where('users.id', $id)
            ->get()
            ->getRowArray();
            
        if (!$user) {
            return redirect()->to('admin/users')->with('error', 'User tidak ditemukan');
        }

        $title = 'Edit User';
        return view('Admin/users_edit', compact('title', 'user'));
    }

    public function updateUser($id = null)
    {
        if ($id == null) {
            return redirect()->to('admin/users')->with('error', 'User tidak ditemukan');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('admin/users')->with('error', 'User tidak ditemukan');
        }

        // Get form input
        $input = [
            'id' => $id,
            'role' => $this->request->getPost('role'),
            'status' => $this->request->getPost('status'),
        ];

        // Only include username and email if they've changed
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        
        if ($username != $user['username']) {
            $input['username'] = $username;
        }
        
        if ($email != $user['email']) {
            $input['email'] = $email;
        }
        
        // Password is optional for update
        if ($password = $this->request->getPost('password')) {
            $input['password'] = $password;
        }
        
        // Get only rules for fields that are being updated
        $rules = [];
        $validationRules = $this->userModel->getValidationRules();
        foreach ($input as $field => $value) {
            if (isset($validationRules[$field])) {
                $rules[$field] = $validationRules[$field];
                
                // Make password validation optional
                if ($field === 'password') {
                    $rules['password']['rules'] = 'permit_empty|min_length[6]';
        }
            }
        }
        
        // Validate only the fields being updated
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update user
        if ($this->userModel->save($input)) {
            return redirect()->to('admin/users')->with('message', 'User berhasil diupdate');
        }
        
        return redirect()->back()->withInput()->with('errors', $this->userModel->errors());
    }

    public function deleteUser()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            if ($this->userModel->delete($id)) {
                return $this->response->setJSON(['success' => true, 'message' => 'User berhasil dihapus']);
            }
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal menghapus user']);
        }
        return redirect()->to('admin/users');
    }
}
