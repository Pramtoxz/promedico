<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data = [
            'title' => 'Dashboard',
            'username' => session()->get('username'),
            'name' => session()->get('name'),
            'role' => session()->get('role')
        ];
        
        return view('welcome_message');
    }
}
