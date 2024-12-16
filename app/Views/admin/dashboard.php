<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-xl-4 col-md-6">
            <div class="card comp-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="mb-25"><a href="all_project.php">Projects</a></h6>
                            <h4 class="fw-700 text-secondary"><a href="all_project.php"> </a></h4>
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
                            <h6 class="mb-25"><a href="all_staff.php">Staff</a></h6>
                            <h4 class="fw-700 text-secondary"><a href="all_staff.php"> </a></h4>
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
                            <h6 class="mb-25"><a href="all_meeting.php">Meetings</a></h6>
                            <h4 class="fw-700 text-secondary"><a href="all_meeting.php"> </a></h4>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-briefcase bg-secondary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                        <!-- <th class="table-dark text-light">Description</th> -->
                        <th class="table-dark text-light">Budget</th>
                        <th class="table-dark text-light">Start Date</th>
                        <th class="table-dark text-light">End Date</th>
                        <th class="table-dark text-light">Staff</th>
                        <!-- <th class="table-dark text-light">Action</th> -->
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header row">
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
                        <th class="table-dark text-light">Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>