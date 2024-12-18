<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="row">
        <!-- Profile Card -->
        <div class="col-lg-4 col-md-5">
            <div class="card">
                <div class="card-body text-center">
                    <img id="profile-image" src="<?= base_url('uploads/' . ($userInfo['profile_image'] ?? 'default-avatar.jpg')); ?>" alt="Profile Image" class="rounded-circle" width="180">
                    <h4 class="card-title mt-3"><?= $userInfo['name'] ?? 'No Name' ?></h4>
                    <p class="card-subtitle">
                        <?= $role == 1 ? 'Admin' : ($role == 2 ? 'Staff' : 'User') ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Profile Details -->
        <div class="col-lg-8 col-md-7">
            <div class="card">
                <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#profile" role="tab">
                            Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#settings" role="tab">
                            Settings
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <!-- Profile Info -->
                    <div class="tab-pane fade show active" id="profile" role="tabpanel">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6>Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary"><?= $userInfo['name'] ?? 'N/A' ?></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6>Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary"><?= $user['email'] ?? 'N/A' ?></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6>Phone</h6>
                                </div>
                                <div class="col-sm-9 text-secondary"><?= $userInfo['phone_no'] ?? 'N/A' ?></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6>Gender</h6>
                                </div>
                                <div class="col-sm-9 text-secondary"><?= $userInfo['gender'] ?? 'N/A' ?></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6>Address</h6>
                                </div>
                                <div class="col-sm-9 text-secondary"><?= $userInfo['address'] ?? 'N/A' ?></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6>City</h6>
                                </div>
                                <div class="col-sm-9 text-secondary"><?= $userInfo['city'] ?? 'N/A' ?></div>
                            </div>
                            <hr>
                        </div>
                    </div>

                    <!-- Settings Tab -->
                    <div class="tab-pane fade" id="settings" role="tabpanel">
                        <div class="card-body">
                            <form id="updateProfile" method="POST" enctype="multipart/form-data" data-action="<?= site_url('profile/update'); ?>">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" id="name" class="form-control" value="<?= $userInfo['name'] ?>">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" id="email" class="form-control" value="<?= $user['email'] ?>">
                                </div>
                                <!-- Gender -->
                                <div class="form-group">
                                    <label>Gender</label><br>
                                    <label>
                                        <input type="radio" name="gender" value="male" <?= ($userInfo['gender'] === 'male') ? 'checked' : ''; ?>> Male
                                    </label>
                                    <label>
                                        <input type="radio" name="gender" value="female" <?= ($userInfo['gender'] === 'female') ? 'checked' : ''; ?>> Female
                                    </label>
                                    <div id="genderError" class="text-danger"></div>
                                </div>

                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" name="phone_no" id="phone_no" class="form-control" value="<?= $userInfo['phone_no'] ?>">
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" name="address" id="address" class="form-control" value="<?= $userInfo['address'] ?>">
                                </div>
                                <div class="form-group">
                                    <label>Profile Image</label>
                                    <div class="mb-3">
                                        <img src="<?= base_url('uploads/' . ($userInfo['profile_image'] ?? 'default-avatar.jpg')); ?>" alt="Current Profile Image" class="img-thumbnail" width="100">
                                    </div>
                                    <input type="file" name="profile_image" id="profile_image" class="form-control">
                                </div>

                                <button type="button" id="submitProfile" class="btn btn-dark">Update Profile</button>
                            </form>
                            <div id="profileMessage"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#submitProfile').on('click', function() {
            let formData = new FormData($('#updateProfile')[0]);
            let actionUrl = $('#updateProfile').data('action');

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success') {
                        $('#profileMessage').html('<div class="text-success">' + response.message + ' <a href="<?= base_url('/profile'); ?>">View</a>' + '</div>');
                    } else {
                        $('#profileMessage').html('<div class="text-danger">' + response.message + '</div>');
                    }
                },
                error: function(xhr) {
                    $('#profileMessage').html('<div class="text-danger">An error occurred while updating the profile.</div>');
                }
            });
        });
    });
</script>

<?= $this->endSection(); ?>