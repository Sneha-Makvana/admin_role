<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'email', 'password', 'role'];

    public function validateUser($email, $password)
    {
        return $this->where('email', $email)
            ->where('password', md5($password))
            ->first();
    }
    
}
