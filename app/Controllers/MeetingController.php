<?php

namespace App\Controllers;

use App\Models\MeetingModel;
use App\Models\ProjectModel;
use App\Models\UserModel;

class MeetingController extends BaseController
{
    public function create()
    {
        $userModel = new UserModel();
        $users = $userModel->where('role', 2)->findAll();
        $projectModel = new ProjectModel();
        $projects = $projectModel->findAll();

        return view('meeting/meeting', ['users' => $users, 'projects' => $projects]);
    }

    public function view()
    {
        return view('meeting/view');
    }
    public function insert()
    {
        $meetingModel = new MeetingModel();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'meeting_title' => 'required|max_length[255]',
            'meeting_date' => 'required|valid_date',
            'start_time' => 'required',
            'end_time' => 'required',
            'agenda' => 'required',
            'user_id' => 'required|integer',
            'project_id' => 'required|integer',
            'location' => 'required|max_length[255]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $validation->getErrors()
            ]);
        }

        $meetingData = $this->request->getPost();
        if ($meetingModel->insert($meetingData)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Meeting successfully added!'
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Failed to insert meeting. Please try again.'
        ]);
    }


    public function update()
    {
        $id = $this->request->getPost('id');

        if (empty($id)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Meeting ID is required.']);
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'meeting_title' => 'required|max_length[255]',
            'meeting_date' => 'required|valid_date',
            'start_time' => 'required',
            'end_time' => 'required',
            'agenda' => 'required',
            'user_id' => 'required|integer',
            'project_id' => 'required|integer',
            'location' => 'required|max_length[255]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['success' => false, 'errors' => $validation->getErrors()]);
        }

        $meetingModel = new MeetingModel();
        $meeting = $meetingModel->find($id);

        if (!$meeting) {
            return $this->response->setJSON(['success' => false, 'message' => 'Meeting not found.']);
        }

        $updateData = $this->request->getPost();
        if ($meetingModel->update($id, $updateData)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Meeting updated successfully.']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Failed to update meeting. Please try again.']);
    }

    public function fetchMeeting($id)
    {
        $meetingModel = new MeetingModel();
        $meeting = $meetingModel->find($id);

        if ($meeting) {
            return $this->response->setJSON([
                'success' => true,
                'data' => $meeting
            ]);
        }
        return $this->response->setJSON([
            'success' => false,
            'message' => 'meeting not found.'
        ]);
    }

    public function fetchAll()
    {
        $meetingModel = new MeetingModel();

        $meetings = $meetingModel
            ->select('meetings.id, meetings.meeting_title, meetings.meeting_date, meetings.start_time, meetings.end_time, projects.end_date,users.username, projects.project_name')
            ->join('users', 'users.id = meetings.user_id')
            ->join('projects', 'projects.id = meetings.project_id')
            ->orderBy('meetings.id', 'DESC')
            ->findAll();

        return $this->response->setJSON($meetings);
    }
    public function delete($id)
    {
        $meetingModel = new MeetingModel();

        $meetings = $meetingModel->find($id);
        if ($meetings) {
            $meetingModel->delete($id);
            return $this->response->setJSON(['success' => true, 'message' => 'Meetings deleted successfully.']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Meetings not found.']);
    }
    public function display()
    {
        return view('meeting/profile');
    }
    public function details($id)
    {
        $model = new MeetingModel();

        $meeting = $model
            ->select('meetings.meeting_title, users.username, projects.project_name, meetings.meeting_date, meetings.start_time, meetings.end_time, meetings.agenda, meetings.location')
            ->join('users', 'users.id = meetings.user_id')
            ->join('projects', 'projects.id = meetings.project_id')
            ->where('meetings.id', $id)
            ->first();

        if ($meeting) {
            return $this->response->setJSON(['success' => true, 'data' => $meeting]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Meeting not found']);
        }
    }
}
