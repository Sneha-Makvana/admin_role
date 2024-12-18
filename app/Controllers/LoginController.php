<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UserInfoModel;
use App\Models\ResetPasswordModel;
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


    public function forgotPassword()
    {
        if (session()->get('is_logged_in')) {
            $role = session()->get('role');
            if ($role == 1) {
                return redirect()->to(base_url('admin'));
            } elseif ($role == 2) {
                return redirect()->to(base_url('admin'));
            }
        }
        return view('login/forgotPassword');
    }
    public function ResetPass()
    {
        if (session()->get('is_logged_in')) {
            $role = session()->get('role');
            if ($role == 1) {
                return redirect()->to(base_url('admin'));
            } elseif ($role == 2) {
                return redirect()->to(base_url('admin'));
            }
        }
        return view('login/resetPassword');
    }

    public function sendResetLink()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $validation->setRules([
                'email' => 'required|valid_email',
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => $validation->getErrors(),
                ]);
            }

            $email = $this->request->getPost('email');
            $userModel = new UserModel();
            $user = $userModel->where('email', $email)->first();

            if (!$user) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'No account found with this email.',
                ]);
            }

            $token = bin2hex(random_bytes(32));
            $resetModel = new ResetPasswordModel();
            $resetModel->save([
                'email' => $email,
                'token' => $token,
                'user_id' => $user['id'],
            ]);

            $resetLink = base_url("resetPassword/{$user['id']}/$token");

            $emailService = \Config\Services::email();
            $emailService->setTo($email);
            $emailService->setFrom('smtp@fableadtechnolabs.com', 'Reset Password');
            $emailService->setSubject('Password Reset Request');
            $emailService->setMessage("Click the link below to reset your password:<br><a href='$resetLink'>$resetLink</a>");

            if ($emailService->send()) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'A password reset link has been sent to your email.',
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to send email. Please try again.',
                ]);
            }
        }
        throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }

    public function resetPassword($user_id, $token)
    {
        $resetModel = new ResetPasswordModel();
        $resetRecord = $resetModel->where('token', $token)->where('user_id', $user_id)->first();

        if (!$resetRecord) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Invalid or expired token.');
        }

        return view('login/resetPassword', ['user_id' => $user_id, 'token' => $token]);
    }

    public function updatePassword()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $validation->setRules([
                'password' => 'required|min_length[6]',
                'conPassword' => 'required|matches[password]',
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => $validation->getErrors(),
                ]);
            }

            $token = $this->request->getPost('token');
            $password = $this->request->getVar('password');

            $resetModel = new ResetPasswordModel();
            $resetRecord = $resetModel->where('token', $token)->first();

            if (!$resetRecord) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Invalid or expired token.',
                ]);
            }

            $hashedPassword = md5($password);

            $userModel = new UserModel();
            $userModel->update($resetRecord['user_id'], [
                'password' => $hashedPassword,
            ]);

            $resetModel->delete($resetRecord['id']);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Your password has been updated.',
            ]);
        }

        throw new \CodeIgniter\Exceptions\PageNotFoundException();
    }
}
