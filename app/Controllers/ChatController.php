<?php

namespace App\Controllers;

use App\Models\ChatModel;
use App\Models\UserInfoModel;
use CodeIgniter\Controller;

class ChatController extends Controller
{
    public function view()
    {
        return view('chat/chat');
    }

    public function getUsers()
    {
        $userModel = new UserInfoModel();
        $role = session()->get('role');
        $currentUserId = session()->get('user_id');

        if ($role == 1) {
            $users = $userModel
                ->join('users', 'users.id = users_info.user_id')
                ->where('users.role !=', 1)
                ->where('users.id !=', $currentUserId)
                ->findAll();
        } else {
            $users = $userModel
                ->join('users', 'users.id = users_info.user_id')
                ->where('users.role', 1)
                ->findAll();
        }

        return $this->response->setJSON(['success' => true, 'data' => $users]);
    }

    public function sendMessage()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'message' => 'required',
                'receiver_id' => 'required'
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => $validation->getErrors()
                ]);
            }

            $message = $this->request->getPost('message');
            $receiver_id = $this->request->getPost('receiver_id');
            $sender_id = session()->get('user_id');

            $fileNames = '';
            if ($files = $this->request->getFiles()) {
                $fileNames = [];
                foreach ($files['files'] as $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        $newName = $file->getRandomName();
                        $file->move(FCPATH . 'uploads', $newName);
                        $fileNames[] = $newName;
                    }
                }
                $fileNames = implode(',', $fileNames);
            }

            $chatModel = new ChatModel();
            $chatModel->saveMessage($sender_id, $receiver_id, $message, $fileNames);

            return $this->response->setJSON(['status' => 'success', 'message' => 'Message sent successfully!']);
        }
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Page not found');
    }
    public function getMessages($receiver_id)
    {
        $sender_id = session()->get('user_id');
        $chatModel = new ChatModel();
        $messages = $chatModel->getMessages($sender_id, $receiver_id);

        return $this->response->setJSON(['success' => true, 'data' => $messages]);
    }
}
