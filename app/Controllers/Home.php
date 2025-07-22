<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CucianMasukModel;
use App\Models\CucianKeluarModel;

class Home extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

}