<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table = 'projects';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'project_name', 'description', 'budget', 'start_date', 'end_date', 'project_status', 'project_files'];
}
?>