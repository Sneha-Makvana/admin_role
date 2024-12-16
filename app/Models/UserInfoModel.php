<?php

namespace App\Models;

use CodeIgniter\Model;

class UserInfoModel extends Model
{
    protected $table = 'users_info';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'name', 'gender', 'address', 'city', 'phone_no', 'profile_image'];

    public function getUsers()
    {
        return $this->select('id, name, profile_image')->findAll();
    }
}

?>