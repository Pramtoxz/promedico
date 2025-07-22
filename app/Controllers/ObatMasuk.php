<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelBarangMasuk;
use App\Models\ModelDetailBarangMasuk;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;
use App\Models\BarangModel;
use App\Models\ModelSupplier;
use App\Models\SupplierModel;


class ObatMasuk extends BaseController
{
    public function index()
    {
        $title = [
            'title' => 'Kelola Obat Masuk'
        ];
        return view('obatmasuk/obatmasuk', $title);
    }

    public function view()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $produk = $db->table('barangmasuk')
            ->select('kdmasuk, tglmasuk,namaspl,grandtotal')
            ->join('supplier', 'supplier.kdspl = barangmasuk.kdspl')
            ->groupBy('kdmasuk,tglmasuk,namaspl,grandtotal');

            return DataTable::of($produk)
                ->add('action', function ($row) {
                    return '<a href="#" class="btn btn-primary btn-sm btn-detail mr-1" data-kdmasuk="' . $row->kdmasuk . '" data-toggle="tooltip" title="Detail Data"><i class="fas fa-eye"></i></a>'
                    . '<a href="#" class="btn btn-secondary btn-sm btn-edit mr-1" data-kdmasuk="' . $row->kdmasuk . '" data-toggle="tooltip" title="Edit Data"><i class="fas fa-pencil-alt"></i></a>'
                    . '<a href="#" class="btn btn-danger btn-sm btn-delete" data-kdmasuk="' . $row->kdmasuk . '" data-toggle="tooltip" title="Hapus Data"><i class="fas fa-trash"></i></a>';
                }, 'last')
                ->addNumbering()
                ->format('grandtotal', function ($value, $meta) {
                    return 'Rp ' . number_format($value, 2, '.', ',');
                })
                ->toJson();
        }
    }

    public function formtambah()
    {
        $db = db_connect();
        $db->table('temp')->emptyTable();

       
        $data = [
            'title' => 'Tambah Barang Masuk',
        ];
        return view('barangmasuk/formtambah', $data);
    }

    public function getBarang()
    {

        return view('barangmasuk/getbarang');
    }

    public function viewGetBarang()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $barang = $db->table('barang')
            ->select('kdbarang, namabarang ,jumlah,hargabeli,kategori.namakategori')
            ->join('kategori', 'kategori.kdkategori = barang.kdkategori');
            return DataTable::of($barang)
                ->add('action', function ($row) {
                    $button1 = '<button type="button" class="btn btn-primary btn-pilihpaket" data-kdbarang="' . $row->kdbarang . '" data-namabarang="' . esc($row->namabarang) . '"  data-hargabeli="' . esc($row->hargabeli) . '">
                                Pilih
                            </button>';
                    return $button1;
                }, 'last')
                ->addNumbering()
                ->format('hargabeli', function ($value, $meta) {
                    return 'Rp ' . number_format($value, 2, '.', ',');
                })
                ->hide('kdbarang')
                ->toJson();
        }
    }

    public function getSupplier()
    {

        return view('barangmasuk/getsupplier');
    }

    public function viewGetSupplier()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $supplier = $db->table('supplier')
            ->select('kdspl, namaspl ,nohp,email');
            return DataTable::of($supplier)
                ->add('action', function ($row) {
                    $button1 = '<button type="button" class="btn btn-primary btn-pilihsupplier" data-kdspl="' . $row->kdspl . '" data-namaspl="' . esc($row->namaspl) . '">
                                Pilih
                            </button>';
                    return $button1;
                }, 'last')
                ->addNumbering()
                ->toJson();
        }
    }

    public function addTemp()
    {
        if ($this->request->isAJAX()) {
            $kdbarang = $this->request->getPost('kdbarang');
            $totalharga = $this->request->getPost('totalharga');
            $jumlah = $this->request->getPost('jumlah');
          

            $rules = [
                'kdbarang' => [
                    'label' => 'Kode Barang',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jumlah' => [
                    'label' => 'Jumlah',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
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
                    $db = db_connect();
                    $db->table('temp')->insert([
                        'jumlah' => $jumlah,
                        'totalharga' => $totalharga,
                        'kdbarang' => $kdbarang,
                    ]);

                    $json = [
                        'sukses' => 'Berhasil Ditambahkan'
                    ];
                 
            }
            return $this->response->setJSON($json);
        }
    }
    public function viewTemp()
    {
        if ($this->request->isAJAX()) {
            $db = db_connect();
            $barang = $db->table('temp')->select('id,temp.kdbarang, barang.namabarang,barang.hargabeli,temp.jumlah, temp.totalharga')
             ->join('barang', 'barang.kdbarang = temp.kdbarang');            
             return DataTable::of($barang)
                ->add('action', function ($row) {
                    return 
                     '<a href="#" class="btn btn-danger btn-sm btn-delete" data-id="' . $row->id . '" data-toggle="tooltip" title="Hapus Data"><i class="fas fa-trash"></i></a>';
                }, 'last')
                ->addNumbering()
                ->format('hargabeli', function ($value, $meta) {
                    return 'Rp ' . number_format($value, 2, '.', ',');
                })
                ->hide('kdbarang')
                ->hide('id')
                ->toJson();
        }
    }

    public function deleteTemp()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');

            $db = db_connect();
                $db->table('temp')->where('id', $id)->delete();
                $json = [
                    'sukses' => 'Data berhasil dihapus'
                ];
             
            return $this->response->setJSON($json);
        }
    }
    public function deleteAllTemp()
    {
        if ($this->request->isAJAX()) {

            $db = db_connect();
            $db->table('temp')->emptyTable();
            $json = [
                'sukses' => 'Semua data berhasil dihapus'
            ];

            return $this->response->setJSON($json);
        }
    }
    public function save()
    {
        if ($this->request->isAJAX()) {
            $kdmasuk = $this->request->getPost('kdmasuk');
            $kdspl = $this->request->getPost('kdspl');
            $namaspl = $this->request->getPost('namaspl');
            $grandtotal = $this->request->getPost('grandtotal');

            $rules = [
                'kdmasuk' => [
                    'label' => 'Kode Masuk',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'namaspl' => [
                    'label' => 'Nama Supplier',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'grandtotal' => [
                    'label' => 'Grand Total',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
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
                return $this->response->setJSON($json);
            } else {
                $db = db_connect();
                $db->transStart();

                $ModelBarangMasuk = new ModelBarangMasuk();
                $modelDetail = new ModelDetailBarangMasuk();
                $modelBarang = new BarangModel(); // Model untuk mengupdate stok barang

                $datasetmasuk = [
                    'kdmasuk' => $kdmasuk,
                    'tglmasuk' => date('Y-m-d'),
                    'kdspl' => $kdspl,
                    'grandtotal' => $grandtotal,
                ];
                $ModelBarangMasuk->insert($datasetmasuk);

                $tempMasuk = $db->table('temp')->get()->getResultArray();
                foreach ($tempMasuk as $item) {
                    $dataDetail = [
                        'kdmasuk' => $kdmasuk,
                        'kdbarang' => $item['kdbarang'],
                        'jumlah' => $item['jumlah'],
                        'totalharga' => $item['totalharga'],
                    ];
                    // Cek apakah detail sudah ada berdasarkan kdmasuk dan kdbarang
                    $existingDetail = $modelDetail->where(['kdmasuk' => $kdmasuk, 'kdbarang' => $item['kdbarang']])->first();
                    if ($existingDetail) {
                        // Update detail jika sudah ada
                        $modelDetail->update($existingDetail['kdmasuk'], $dataDetail);
                    } else {
                        // Insert detail baru jika belum ada
                        $modelDetail->insert($dataDetail);
                    }

                    // Update jumlah stok barang
                    $barang = $modelBarang->find($item['kdbarang']);
                    if ($barang) {
                        $updatedJumlah = $barang['jumlah'] + $item['jumlah'];
                        $modelBarang->update($item['kdbarang'], ['jumlah' => $updatedJumlah]);
                    }
                }

                $db->table('temp')->emptyTable();
                $db->transComplete();

                if ($db->transStatus() === FALSE) {
                    $json = ['error' => 'Gagal menyimpan data'];
                } else {
                    $json = ['sukses' => 'Barang Masuk berhasil disimpan'];
                }
                return $this->response->setJSON($json);
        }
    }
}

  
    public function formedit($kdmasuk)
    {
        $db = db_connect();
        $db->table('temp')->emptyTable();
        $modelBarangMasuk = new ModelBarangMasuk();
        $barangmasuk = $modelBarangMasuk->where('kdmasuk', $kdmasuk)->first();
        $modelSupplier = new ModelSupplier();
        if (!$barangmasuk) {
            return redirect()->back()->with('error', 'Data Barang Masuk tidak ditemukan');
        }
        $supplier = $modelSupplier->where('kdspl', $barangmasuk['kdspl'])->first();

        $supplierData = $db->table('supplier')->where('kdspl', $barangmasuk['kdspl'])->get()->getRowArray();
        if (!$supplierData) {
            return redirect()->back()->with('error', 'Data Supplier tidak ditemukan');
        }

        $cekData = $db->table('temp')->where('kdmasuk', $kdmasuk)->countAllResults();
        if ($cekData == 0) {
            $detailBarangMasuk = $db->table('detailbarangmasuk')
                ->select('kdmasuk, kdbarang, jumlah, totalharga')
                ->where('kdmasuk', $kdmasuk)
                ->get();

            foreach ($detailBarangMasuk->getResultArray() as $row) {
                $db->table('temp')->insert([
                    'kdmasuk' => $kdmasuk,
                    'kdbarang' => $row['kdbarang'],
                    'jumlah' => $row['jumlah'],
                    'totalharga' => $row['totalharga'],
                ]);
            }
            // Hapus data di detailbarangmasuk setelah dipindahkan ke temp
            $db->table('detailbarangmasuk')->where('kdmasuk', $kdmasuk)->delete();
        }

        $data = [
            'barangmasuk' => $barangmasuk,
            'supplier' => $supplier,
            'namaspl' => $supplierData['namaspl'],
        ];

        return view('barangmasuk/formedit', $data);
    }
    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $kdmasuk = $this->request->getPost('kdmasuk');
            $kdspl = $this->request->getPost('kdspl');
            $namaspl = $this->request->getPost('namaspl');
            $grandtotal = $this->request->getPost('grandtotal');

            $rules = [
                'kdmasuk' => [
                    'label' => 'Kode Masuk',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'namaspl' => [
                    'label' => 'Nama Supplier',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
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
                $db = db_connect();
                $db->transStart();

                $ModelBarangMasuk = new ModelBarangMasuk();
                $ModelDetailBarangMasuk = new ModelDetailBarangMasuk(); // Model untuk detail barang masuk
                $modelBarang = new BarangModel(); // Model untuk barang

                // Update data barang masuk
                $dataBarangMasuk = [
                    'tglmasuk' => date('Y-m-d'),
                    'kdspl' => $kdspl,
                    'grandtotal' => $grandtotal,
                ];
                $ModelBarangMasuk->update($kdmasuk, $dataBarangMasuk);

                $tempMasuk = $db->table('temp')->get()->getResultArray();
                foreach ($tempMasuk as $item) {
                    $dataDetailBarangMasuk = [
                        'kdmasuk' => $kdmasuk,
                        'kdbarang' => $item['kdbarang'],
                        'jumlah' => $item['jumlah'],
                        'totalharga' => $item['totalharga'],
                    ];
                    $ModelDetailBarangMasuk->insert($dataDetailBarangMasuk); // Mengganti update menjadi insert

                    // Update jumlah di tabel barang
                    $barang = $modelBarang->find($item['kdbarang']);
                    if ($barang) {
                        $modelBarang->update($item['kdbarang'], ['jumlah' => $item['jumlah']]);
                    }
                }

                $db->table('temp')->emptyTable();
                $db->transComplete();

                if ($db->transStatus() === FALSE) {
                    $json = ['error' => 'Gagal memperbarui data'];
                } else {
                    $json = ['sukses' => 'Data berhasil diperbarui',
                    'kdmasuk' => $kdmasuk
                ];
                }
            }
            return $this->response->setJSON($json);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $kdmasuk = $this->request->getPost('kdmasuk');
            $db = db_connect();
            $modelBarangMasuk = new ModelBarangMasuk();
            $modelDetailBarangMasuk = new ModelDetailBarangMasuk();
            $modelBarang = new BarangModel();

            // Ambil data detail barang masuk untuk mengembalikan jumlah barang
                $detailBarangMasuk = $modelDetailBarangMasuk->where('kdmasuk', $kdmasuk)->findAll();
            foreach ($detailBarangMasuk as $detail) {
                // Kembalikan jumlah barang ke tabel barang
                $barang = $modelBarang->find($detail['kdbarang']);
                if ($barang) {
                    $jumlahBaru = $barang['jumlah'] - $detail['jumlah'];
                    $modelBarang->update($detail['kdbarang'], ['jumlah' => $jumlahBaru]);
                }
            }

            // Hapus data di tabel detailbarangmasuk
            $modelDetailBarangMasuk->where('kdmasuk', $kdmasuk)->delete();

            // Hapus data di tabel barangmasuk
            $modelBarangMasuk->where('kdmasuk', $kdmasuk)->delete();

            $json = [
                'sukses' => 'Data Barang Masuk Berhasil Dihapus'
            ];

            return $this->response->setJSON($json);
        }
    }


    public function DetailBarangMasuk($kdmasuk)
    {
        $db = db_connect();
        $userQuery = $db
            ->table('detailbarangmasuk')
            ->select('detailbarangmasuk.kdmasuk,barangmasuk.kdmasuk,barangmasuk.tglmasuk,supplier.namaspl,barangmasuk.grandtotal')
            ->select('(SELECT count(kdbarang) FROM detailbarangmasuk where detailbarangmasuk.kdmasuk = barangmasuk.kdmasuk) as countItem')
            ->select('(SELECT sum(jumlah) FROM detailbarangmasuk where detailbarangmasuk.kdmasuk = barangmasuk.kdmasuk) as totaljumlah')
            ->join('barangmasuk', 'barangmasuk.kdmasuk = detailbarangmasuk.kdmasuk')
            ->join('supplier', 'supplier.kdspl = barangmasuk.kdspl')
            ->groupBy('barangmasuk.kdmasuk')
            ->where('barangmasuk.kdmasuk', $kdmasuk);

        $user = $userQuery->get();

        $detailproduk = $db
            ->table('detailbarangmasuk')
            ->select('barang.namabarang,detailbarangmasuk.jumlah,barang.hargabeli,detailbarangmasuk.totalharga')
            ->join('barang', 'barang.kdbarang = detailbarangmasuk.kdbarang')
            ->where('kdmasuk', $kdmasuk);
        $detail = $detailproduk->get();

        $item = $detail->getResultArray();
        $userData = $user->getRow();
        if (!$userData) {
            return redirect()->back();
        }
        $data = [
            'barang' => $userData,
            'detail' => $item
        ];

        return view('barangmasuk/detail', $data);
    }

}
