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

                    <h3>Sign In</h3>
                    <!-- <p>Happy to see you again!</p>  -->
                    <form id="loginForm" method="POST">
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                            <i class="ik ik-mail"></i>
                            <div class="error text-danger" id="emailError"></div>
                        </div>


                        <div class="form-group">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                            <i class="ik ik-lock"></i>
                            <div class="error text-danger" id="passwordError"></div>
                        </div>
                        <div class="row">
                            <div class="col text-left">
                                <!-- <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="item_checkbox" name="item_checkbox" value="option1">
                                            <span class="custom-control-label">&nbsp;Remember Me</span>
                                        </label> -->
                            </div>
                            <div class="col text-right">
                                <a href="<?= base_url('/forgotPassword') ?>">Forgot Password ?</a>
                            </div>
                        </div>
                        <div id="message"></div>
                        <div class="sign-btn text-center">
                            <button type="button" id="submitBtn" class="btn btn-dark">Sign In</button>
                        </div>

                    </form>

                    <div class="register">
                        <p>Don't have an account? <a href="register.php">Create an account</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#submitBtn').click(function() {
            $('#message').html('');
            $('#emailError').html('');
            $('#passwordError').html('');

            $.ajax({
                url: "<?= site_url('login/authenticate'); ?>",
                method: "POST",
                data: {
                    email: $('#email').val(),
                    password: $('#password').val()
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === 'error') {
                        if (response.errors) {
                            $('#emailError').html(response.errors.email || '');
                            $('#passwordError').html(response.errors.password || '');
                        } else {
                            $('#message').html(`<p style="color:red;">${response.message}</p>`);
                        }
                    } else if (response.status === 'success') {
                        window.location.href = response.redirect_url;
                    }
                },
                error: function() {
                    $('#message').html('<p style="color:red;">Something went wrong. Please try again later.</p>');
                }
            });
        });
    });
</script>

<?= $this->endSection(); ?>