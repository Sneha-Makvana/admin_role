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
        $users = $userModel->findAll();

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
            if ($this->request->getFileMultiple('files')) {
                $files = $this->request->getFileMultiple('files');
                $fileNames = [];
                foreach ($files as $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        $newName = $file->getRandomName();
                        $file->move(WRITEPATH . 'uploads', $newName);
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
