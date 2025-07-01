<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Cek apakah user sudah login
        if (session()->has('logged_in') && session()->get('logged_in')) {
            $role = session()->get('role');
            
            // Redirect berdasarkan role
            if ($role === 'admin' || $role === 'manager') {
                return redirect()->to('admin');
            } 
            // User biasa tetap di landing page
        }
        
        $data = [
            'title' => 'Wisma - Tempat Penginapan Nyaman',
            'username' => session()->get('username'),
            'name' => session()->get('name'),
            'role' => session()->get('role'),
            'is_logged_in' => session()->has('logged_in') && session()->get('logged_in')
        ];
        
        return view('landing/home', $data);
    }
    
    public function booking()
    {
        // Cek login
        if (!session()->has('logged_in') || !session()->get('logged_in')) {
            session()->setFlashdata('error', 'Silakan login terlebih dahulu untuk melakukan booking');
            return redirect()->to('auth');
        }
        
        $data = [
            'title' => 'Booking Wisma',
            'username' => session()->get('username'),
            'name' => session()->get('name'),
            'role' => session()->get('role')
        ];
        
        return view('landing/booking', $data);
    }
}
