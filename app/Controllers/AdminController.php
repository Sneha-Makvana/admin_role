<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProjectModel;
use App\Models\MeetingModel;
use App\Models\UserModel;
use App\Models\UserInfoModel;

class AdminController extends Controller
{
    public function dashboard()
    {
        $role = session()->get('role');

        if ($role == 1 || $role == 2) {

            $projectModel = new ProjectModel();
            $meetingModel = new MeetingModel();
            $userModel = new UserModel();
            $userInfoModel = new UserInfoModel();

            $projectCount = $projectModel->countAllResults();
            $meetingCount = $meetingModel->countAllResults();
            $staffCount = $userModel->where('role', 2)->countAllResults();

            if ($role == 1) {
                $projectCount = $projectModel->countAllResults();
                $meetingCount = $meetingModel->countAllResults();
                $staffCount = $userModel->where('role', 2)->countAllResults();

                $latestProjects = $projectModel
                    ->select('projects.project_name, projects.budget, projects.start_date, projects.end_date, users.username')
                    ->join('users', 'users.id = projects.user_id')
                    ->orderBy('projects.id', 'DESC')
                    ->findAll();

                $latestStaff = $userInfoModel
                    ->select('users.email, users_info.name, users_info.address, users_info.phone_no, users_info.profile_image, users_info.id')
                    ->join('users', 'users.id = users_info.user_id')
                    ->where('users.role', 2)
                    ->orderBy('users_info.id', 'DESC')
                    ->findAll();

                return view('admin/dashboard', [
                    'projectCount' => $projectCount,
                    'meetingCount' => $meetingCount,
                    'staffCount' => $staffCount,
                    'latestProjects' => $latestProjects,
                    'latestStaff' => $latestStaff
                ]);
            }

            if ($role == 2) {
                $projectCount = $projectModel->where('user_id', session()->get('user_id'))->countAllResults();
                $meetingCount = $meetingModel->where('user_id', session()->get('user_id'))->countAllResults();

                $latestProjects = $projectModel
                    ->select('projects.project_name, projects.budget, projects.start_date, projects.end_date, users.username')
                    ->join('users', 'users.id = projects.user_id')
                    ->where('user_id', session()->get('user_id'))
                    ->orderBy('projects.id', 'DESC')
                    ->findAll();

                $latestMeetings = $meetingModel
                    ->select('meetings.meeting_title, meetings.meeting_date, meetings.start_time, meetings.end_time')
                    ->where('user_id', session()->get('user_id'))
                    ->orderBy('meetings.id', 'DESC')
                    ->findAll();

                return view('admin/dashboard', [
                    'projectCount' => $projectCount,
                    'meetingCount' => $meetingCount,
                    'latestProjects' => $latestProjects,
                    'latestMeetings' => $latestMeetings
                ]);
            }
        }
        return redirect()->to('/login');
    }

    public function display()
    {
        $userId = session()->get('user_id');
        $role = session()->get('role');

        $userModel = new UserModel();
        $userInfoModel = new UserInfoModel();

        $user = $userModel->find($userId);
        $userInfo = $userInfoModel->where('user_id', $userId)->first();

        return view('admin/profile', [
            'user' => $user,
            'userInfo' => $userInfo,
            'role' => $role
        ]);
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $validation->setRules([
                'name' => 'required|string|min_length[3]',
                'email' => 'required|valid_email',
                'phone_no' => 'required|numeric',
                'gender' => 'required|in_list[male,female]',
                'address' => 'required|string',
                'profile_image' => 'permit_empty|uploaded[profile_image]|is_image[profile_image]|max_size[profile_image,2048]|mime_in[profile_image,image/jpg,image/jpeg,image/png]'
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validation->getErrors(),
                ]);
            }

            $userId = session()->get('user_id');
            if (!$userId) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'User not authenticated',
                ]);
            }

            $userModel = new \App\Models\UserModel();
            $userInfoModel = new \App\Models\UserInfoModel();

            $name = $this->request->getPost('name');
            $data = [
                'name' => $name,
                'phone_no' => $this->request->getPost('phone_no'),
                'gender' => $this->request->getPost('gender'),
                'address' => $this->request->getPost('address'),
            ];

            $file = $this->request->getFile('profile_image');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads', $newName);
                $data['profile_image'] = $newName;
            }

            $userInfoUpdate = $userInfoModel->where('user_id', $userId)->set($data)->update();

            $userUpdate = $userModel->where('id', $userId)->set([
                'username' => $name,
                'email' => $this->request->getPost('email')
            ])->update();


            if ($userInfoUpdate && $userUpdate) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Profile updated successfully!',
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to update profile.',
                ]);
            }
        }

        throw new \CodeIgniter\Exceptions\PageNotFoundException('Page not found');
    }
    public function view()
    {
        return view('admin/changePass');
    }
    public function changePassword()
    {
        if ($this->request->isAJAX()) {
            $userId = session()->get('user_id');

            $oldPassword = $this->request->getVar('oldPassword');
            $newPassword = $this->request->getVar('newPassword');
            $conPassword = $this->request->getVar('conPassword');

            if (empty($oldPassword) || empty($newPassword) || empty($conPassword)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'All fields are required.'
                ]);
            }

            if ($newPassword !== $conPassword) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'New password and confirm password do not match.'
                ]);
            }

            $userModel = new UserModel();

            $user = $userModel->find($userId);
            if (md5($oldPassword) !== $user['password']) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Old password is incorrect.'
                ]);
            }

            $newPasswordHash = md5($newPassword);

            $update = $userModel->update($userId, ['password' => $newPasswordHash]);

            if ($update) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Password updated successfully!'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to update password.'
                ]);
            }
        }

        throw new \CodeIgniter\Exceptions\PageNotFoundException('Page not found');
    }
}
