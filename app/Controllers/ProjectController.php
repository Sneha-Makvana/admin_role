<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ProjectModel;
use CodeIgniter\Controller;

class ProjectController extends Controller
{
    public function create()
    {
        $userModel = new UserModel();

        $staff = $userModel->where('role', 2)->findAll();

        return view('project/project', ['staff' => $staff]);
    }

    public function view()
    {
        return view('project/view');
    }

    public function insert()
    {
        $response = ['success' => false, 'message' => '', 'errors' => []];

        $validation = \Config\Services::validation();
        $validation->setRules([
            'project_name' => 'required|min_length[3]|max_length[255]',
            'user_id' => 'required',
            'description' => 'required|min_length[5]',
            'budget' => 'required|numeric',
            'start_date' => 'required|valid_date',
            'end_date' => 'required|valid_date',
            'project_status' => 'required',
            'project_files' => 'uploaded[project_files]|max_size[project_files,2048]|ext_in[project_files,pdf,jpg,jpeg,png,txt,doc,docx,webp]',
        ]);

        if (!$this->validate($validation->getRules())) {
            $response['errors'] = $validation->getErrors();
        } else {
            $model = new ProjectModel();
            $data = [
                'user_id' => $this->request->getPost('user_id'),
                'project_name' => $this->request->getPost('project_name'),
                'description' => $this->request->getPost('description'),
                'budget' => $this->request->getPost('budget'),
                'start_date' => $this->request->getPost('start_date'),
                'end_date' => $this->request->getPost('end_date'),
                'project_status' => $this->request->getPost('project_status'),
            ];

            $files = $this->request->getFiles();
            if ($files['project_files']) {
                $uploadedFiles = [];
                foreach ($files['project_files'] as $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        $newName = $file->getRandomName();
                        $file->move(FCPATH . 'uploads', $newName);
                        $uploadedFiles[] = $newName;
                    }
                }
                $data['project_files'] = json_encode($uploadedFiles);
            }

            if ($model->insert($data)) {
                $response['success'] = true;
                $response['message'] = 'Project added successfully!';
            } else {
                $response['message'] = 'Failed to add project!';
            }
        }

        return $this->response->setJSON($response);
    }


    public function update()
    {
        $id = $this->request->getPost('id');
        $validation = \Config\Services::validation();
        $validation->setRules([
            'project_name' => 'required|min_length[3]|max_length[255]',
            'user_id' => 'required',
            'description' => 'required|min_length[5]',
            'budget' => 'required|numeric',
            'start_date' => 'required|valid_date',
            'end_date' => 'required|valid_date',
            'project_status' => 'required',
            'project_files' => 'max_size[project_files,2048]|ext_in[project_files,pdf,jpg,jpeg,png,txt,doc,docx,webp]',
        ]);

        if (!$this->validate($validation->getRules())) {
            return $this->response->setJSON(['success' => false, 'errors' => $validation->getErrors()]);
        }

        $model = new ProjectModel();
        $project = $model->find($id);

        if (!$project) {
            return $this->response->setJSON(['success' => false, 'message' => 'Project not found.']);
        }

        $files = $this->request->getFiles();
        $uploadedFiles = $project['project_files'] ? json_decode($project['project_files'], true) : [];

        if (isset($files['project_files'])) {
            foreach ($files['project_files'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move(FCPATH . 'uploads', $newName);
                    $uploadedFiles[] = $newName;
                }
            }
        }

        $model->update($id, [
            'user_id' => $this->request->getPost('user_id'),
            'project_name' => $this->request->getPost('project_name'),
            'description' => $this->request->getPost('description'),
            'budget' => $this->request->getPost('budget'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            'project_status' => $this->request->getPost('project_status'),
            'project_files' => json_encode($uploadedFiles),
        ]);

        return $this->response->setJSON(['success' => true, 'message' => 'Project updated successfully.']);
    }

    public function fetchProject($id)
    {
        $model = new ProjectModel();
        $project = $model->find($id);

        if ($project) {
            return $this->response->setJSON([
                'success' => true,
                'data' => $project
            ]);
        }
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Project not found.'
        ]);
    }

    public function fetchAll()
    {
        $model = new ProjectModel();

        $projects = $model
            ->select('projects.id, projects.project_name, projects.description, projects.budget, projects.start_date, projects.end_date, projects.project_status, projects.project_files, users.username')
            ->join('users', 'users.id = projects.user_id')
            ->orderBy('projects.id', 'DESC')
            ->findAll();

        return $this->response->setJSON($projects);
    }
    public function delete($id)
    {
        $model = new ProjectModel();

        $project = $model->find($id);
        if ($project) {
            $model->delete($id);
            return $this->response->setJSON(['success' => true, 'message' => 'Project deleted successfully.']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Project not found.']);
    }

    public function display()
    {
        return view('project/profile');
    }
    public function details($id)
    {
        $model = new ProjectModel();

        $project = $model
            ->select('projects.project_name, users.username, projects.description, projects.budget, projects.start_date, projects.end_date, projects.project_status, projects.project_files')
            ->join('users', 'users.id = projects.user_id')
            ->where('projects.id', $id)
            ->first();

        if ($project) {
            $filePaths = json_decode($project['project_files'], true) ?: [];

            $base_url = base_url('uploads');
            $project['file_urls'] = array_map(function ($file) use ($base_url) {
                return $base_url . '/' . $file;
            }, $filePaths);

            return $this->response->setJSON(['success' => true, 'data' => $project]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Project not found']);
        }
    }
}
