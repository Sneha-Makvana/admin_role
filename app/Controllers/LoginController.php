<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UserInfoModel;
use CodeIgniter\Controller;

class LoginController extends Controller
{
    public function view()
    {
        if (session()->get('is_logged_in')) {
            $role = session()->get('role');
            if ($role == 1) {
                return redirect()->to(base_url('admin'));
            } elseif ($role == 2) {
                return redirect()->to(base_url('admin'));
            }
        }

        return view('login/login');
    }

    // public function authenticate()
    // {
    //     if ($this->request->isAJAX()) {
    //         $validation = \Config\Services::validation();

    //         $validation->setRules([
    //             'email' => 'required|valid_email',
    //             'password' => 'required|min_length[6]'
    //         ]);

    //         if (!$validation->withRequest($this->request)->run()) {
    //             return $this->response->setJSON([
    //                 'status' => 'error',
    //                 'errors' => $validation->getErrors()
    //             ]);
    //         }

    //         $email = $this->request->getPost('email');
    //         $password = $this->request->getPost('password');

    //         $userModel = new UserModel();
    //         $user = $userModel->validateUser($email, $password);

    //         if ($user) {
    //             session()->set([
    //                 'user_id' => $user['id'],
    //                 'username' => $user['username'],
    //                 'email' => $user['email'],
    //                 'role' => $user['role'],
    //                 'is_logged_in' => true
    //             ]);

    //             if ($user['role'] == 1) {
    //                 $redirectUrl = base_url('admin');
    //             } else {
    //                 $redirectUrl = base_url('admin');
    //             }

    //             return $this->response->setJSON([
    //                 'status' => 'success',
    //                 'redirect_url' => $redirectUrl
    //             ]);
    //         } else {
    //             return $this->response->setJSON([
    //                 'status' => 'error',
    //                 'message' => 'Invalid email or password.'
    //             ]);
    //         }
    //     }

    //     throw new \CodeIgniter\Exceptions\PageNotFoundException('Page not found');
    // }

    public function authenticate()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $validation->setRules([
                'email' => 'required|valid_email',
                'password' => 'required|min_length[6]'
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => $validation->getErrors()
                ]);
            }

            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $userModel = new UserModel();
            $user = $userModel->validateUser($email, $password);

            if ($user) {
                $userInfoModel = new UserInfoModel();
                $userInfo = $userInfoModel->where('user_id', $user['id'])->first();

                session()->set([
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'profile_image' => $userInfo['profile_image'],
                    'is_logged_in' => true
                ]);


                if ($user['role'] == 1) {
                    $redirectUrl = base_url('admin');
                } else {
                    $redirectUrl = base_url('admin');
                }

                return $this->response->setJSON([
                    'status' => 'success',
                    'redirect_url' => $redirectUrl
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Invalid email or password.'
                ]);
            }
        }
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Page not found');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }

    public function ForgotPass()
    {
        return view('login/forgotPassword');
    }
}
