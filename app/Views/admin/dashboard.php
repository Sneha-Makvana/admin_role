<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid">
    <?php if (session()->get('role') == 1) : ?>
        <div class="row clearfix">
            <div class="col-xl-4 col-md-6">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-25"><a href="<?= base_url('project/view'); ?>">Projects</a></h6>
                                <h4 class="fw-700 text-secondary"><a href="<?= base_url('project/view'); ?>"><?= $projectCount; ?></a></h4>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-box bg-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-25"><a href="<?= base_url('staff/view'); ?>">Staff</a></h6>
                                <h4 class="fw-700 text-secondary"><a href="<?= base_url('staff/view'); ?>"><?= $staffCount; ?></a></h4>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users bg-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-25"><a href="<?= base_url('meeting/view'); ?>">Meetings</a></h6>
                                <h4 class="fw-700 text-secondary"><a href="<?= base_url('meeting/view'); ?>"><?= $meetingCount; ?></a></h4>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-briefcase bg-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->get('role') == 2) : ?>
        <div class="row clearfix">
            <div class="col-xl-6 col-md-6">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-25"><a href="<?= base_url('project/view'); ?>">Projects</a></h6>
                                <h4 class="fw-700 text-secondary"><a href="<?= base_url('project/view'); ?>"><?= $projectCount; ?></a></h4>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-box bg-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-md-6">
                <div class="card comp-card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="mb-25"><a href="<?= base_url('meeting/view'); ?>">Meetings</a></h6>
                                <h4 class="fw-700 text-secondary"><a href="<?= base_url('meeting/view'); ?>"><?= $meetingCount; ?></a></h4>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-briefcase bg-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-header row bg-gradient-primary">
        <h3 class="mx-3">Latest Projects</h3>
    </div>
    <div class="card-body">
        <table class="table table-striped table-hover table-active">
            <thead>
                <tr>
                    <th class="table-dark text-light">Project Name</th>
                    <th class="table-dark text-light">Budget</th>
                    <th class="table-dark text-light">Start Date</th>
                    <th class="table-dark text-light">End Date</th>
                    <th class="table-dark text-light">Staff</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($latestProjects)) : ?>
                    <?php foreach ($latestProjects as $project) : ?>
                        <tr>
                            <td><?= esc($project['project_name']); ?></td>
                            <td><?= esc($project['budget']); ?></td>
                            <td><?= esc($project['start_date']); ?></td>
                            <td><?= esc($project['end_date']); ?></td>
                            <td><?= esc($project['username']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center">No projects available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php if (session()->get('role') == 1) : ?>
    <div class="card">
        <div class="card-header row bg-gradient-primary">
            <h3 class="mx-3">Latest Staffs</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover table-active">
                <thead>
                    <tr>
                        <th class="table-dark text-light">Profile</th>
                        <th class="table-dark text-light">Name</th>
                        <th class="table-dark text-light">Email</th>
                        <th class="table-dark text-light">Address</th>
                        <th class="table-dark text-light">Phone No.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($latestStaff)) : ?>
                        <?php foreach ($latestStaff as $staff) : ?>
                            <tr>
                                <td>
                                    <img src="<?= base_url('uploads/' . $staff['profile_image']); ?>" alt="Profile Image" class="rounded-circle" width="50" height="50">
                                </td>
                                <td><?= esc($staff['name']); ?></td>
                                <td><?= esc($staff['email']); ?></td>
                                <td><?= esc($staff['address']); ?></td>
                                <td><?= esc($staff['phone_no']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center">No staff available.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>
<?= $this->endSection(); ?>