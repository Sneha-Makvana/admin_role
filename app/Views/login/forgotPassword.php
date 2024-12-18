<?= $this->extend('layout_auth'); ?>
<?= $this->section('content'); ?>

<div class="auth-wrapper">
    <div class="container-fluid h-100">
        <div class="row flex-row h-100 bg-white">
            <div class="col-xl-8 col-lg-6 col-md-5 p-0 d-md-block d-lg-block d-sm-none d-none">
                <div class="lavalite-bg" style="background-image: url('public/assets/img/login-bg.jpg')">
                    <div class="lavalite-overlay"></div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-7 my-auto p-0">
                <div class="authentication-form mx-auto">
                    <h3>Forgot Password</h3>
                    <form id="forgotPasswordForm">
                        <div class="form-group">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Your email address">
                            <i class="ik ik-mail"></i>
                            <div id="emailError" class="text-danger"></div>
                        </div>
                        <div id="message" class="mt-3"></div>
                        <div class="sign-btn text-center">
                            <button type="submit" class="btn btn-dark" id="submitBtn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#forgotPasswordForm').submit(function(e) {
        e.preventDefault();

        $('#emailError').text('');
        $('#message').text('').removeClass('success error');

        $.ajax({
            url: '<?= base_url("sendResetLink") ?>',
            type: 'POST',
            data: {
                email: $('#email').val()
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'error') {
                    if (response.errors && response.errors.email) {
                        $('#emailError').text(response.errors.email);
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