<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Change Password</h3>
                </div>
                <div class="card-body">
                    <form id="changePasswordForm">
                        <label for="oldPassword">Old Password</label>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="ik ik-lock"></i>
                                    </span>
                                </div>
                                <input type="password" class="form-control" name="oldPassword" id="oldPassword" placeholder="Enter old password">
                            </div>
                        </div>

                        <label for="newPassword">New Password</label>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="ik ik-check-square"></i>
                                    </span>
                                </div>
                                <input type="password" class="form-control" name="newPassword" id="newPassword" placeholder="Enter new password">
                            </div>
                        </div>

                        <label for="conPassword">Confirm Password</label>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="ik ik-check"></i>
                                    </span>
                                </div>
                                <input type="password" class="form-control" name="conPassword" id="conPassword" placeholder="Enter confirm password">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark mr-2">Change Password</button>
                    </form>
                    <div id="responseMessage" class="text d-none"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#changePasswordForm').on('submit', function(e) {
            e.preventDefault();

            $("#responseMessage").html("");
            
            let oldPassword = $('#oldPassword').val();
            let newPassword = $('#newPassword').val();
            let conPassword = $('#conPassword').val();

            if (!oldPassword || !newPassword || !conPassword) {
                $('#responseMessage').removeClass('d-none').addClass('text-danger').text('All fields are required.');
                return;
            }

            if (newPassword !== conPassword) {
                $('#responseMessage').removeClass('d-none').addClass('text-danger').text('New password and confirm password do not match.');
                return;
            }

            $.ajax({
                url: '<?= site_url('admin/changePassword') ?>',
                type: 'POST',
                data: {
                    oldPassword: oldPassword,
                    newPassword: newPassword,
                    conPassword: conPassword
                },
                success: function(response) {
                    if (response.status === 'success') {
                        $('#responseMessage').removeClass('d-none').addClass('text-success').text(response.message);
                    } else {
                        $('#responseMessage').removeClass('d-none').addClass('text-danger').text(response.message);
                    }
                },
                error: function() {
                    $('#responseMessage').removeClass('d-none').addClass('text-danger').text('An error occurred while changing the password.');
                }
            });
        });
    });
</script>

<?= $this->endSection(); ?>