<?= $this->extend('layout_auth'); ?>
<?= $this->section('content'); ?>

<div class="auth-wrapper">
    <div class="container-fluid h-100">
        <div class="row flex-row h-100 bg-white">
            <div class="col-xl-8 col-lg-6 col-md-5 p-0 d-md-block d-lg-block d-sm-none d-none">
                <div class="lavalite-bg" style="background-image: url('<?= base_url('public/assets/img/login-bg.jpg') ?>')">
                    <div class="lavalite-overlay"></div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-7 my-auto p-0">
                <div class="authentication-form mx-auto">
                    <h3>Reset Password</h3>
                    <form id="resetPasswordForm">
                        <input type="hidden" name="user_id" id="user_id" value="<?= $user_id ?>">
                        <input type="hidden" name="token" id="token" value="<?= $token ?>">
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" id="password" placeholder="New Password">
                            <i class="ik ik-lock"></i>
                            <div id="passwordError" class="text-danger"></div>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="conPassword" id="conPassword" placeholder="Confirm Password">
                            <i class="ik ik-lock"></i>
                            <div id="conPasswordError" class="text-danger"></div>
                        </div>
                        <div class="sign-btn text-center">
                            <button type="submit" id="submitBtn" class="btn btn-dark">Reset Password</button>
                        </div>
                        <div id="message" class="text-success mt-3"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#resetPasswordForm').submit(function(e) {
        e.preventDefault();

        $('#passwordError').text('');
        $('#conPasswordError').text('');
        $('#message').text('').removeClass('success error');

        var password = $('#password').val();
        var conPassword = $('#conPassword').val();

        if (password !== conPassword) {
            $('#conPasswordError').text('Passwords do not match.');
            return;
        }
        if (password.length < 6) {
            $('#passwordError').text('Password must be at least 6 characters.');
            return;
        }

        $.ajax({
            url: '<?= base_url("updatePassword") ?>',
            type: 'POST',
            data: $('#resetPasswordForm').serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'error') {
                    if (response.errors) {
                        if (response.errors.password) $('#passwordError').text(response.errors.password);
                        if (response.errors.conPassword) $('#conPasswordError').text(response.errors.conPassword);
                    }
                    $('#message').text(response.message).addClass('error');
                } else {
                    $('#message').text(response.message).addClass('success');
                }
            },
            error: function() {
                $('#message').text('An error occurred. Please try again.').addClass('error');
            }
        });
    });
</script>

<?= $this->endSection(); ?>