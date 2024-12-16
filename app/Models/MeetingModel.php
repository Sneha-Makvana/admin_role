<?php

namespace App\Models;

use CodeIgniter\Model;

class MeetingModel extends Model
{
    protected $table = 'meetings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['project_id','user_id', 'meeting_title', 'meeting_date', 'start_time', 'end_time', 'agenda', 'location'];
}
?>