<?php

namespace App\Models;

use CodeIgniter\Model;

class ChatModel extends Model
{
    protected $table = 'chats';
    protected $primaryKey = 'id';
    protected $allowedFields = ['sender_id', 'receiver_id', 'message', 'files', 'sent_at'];

    // Function to insert a chat message
    public function saveMessage($sender_id, $receiver_id, $message, $files = null)
    {
        $data = [
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'message' => $message,
            'files' => $files, // Save file paths if there are any
            'sent_at' => date('Y-m-d H:i:s')
        ];

        return $this->insert($data);
    }

    // Function to get chat messages between two users
    public function getMessages($sender_id, $receiver_id)
    {
        return $this->where('sender_id', $sender_id)
                    ->where('receiver_id', $receiver_id)
                    ->orWhere('sender_id', $receiver_id)
                    ->where('receiver_id', $sender_id)
                    ->orderBy('sent_at', 'ASC')
                    ->findAll();
    }
}
