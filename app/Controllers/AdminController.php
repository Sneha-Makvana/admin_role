<?php

namespace App\Controllers;
use CodeIgniter\Controller;

class AdminController extends Controller
{

    public function dashboard()
    {
        $role = session()->get('role');

        if ($role == 1) {
            return view('admin/dashboard');
        } elseif ($role == 2) {
            return view('admin/dashboard');
        }

        return redirect()->to('/login');
    }
}