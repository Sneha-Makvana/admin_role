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
                    <!-- <p>We will send you a link to reset your password.</p> -->
                    <form id="forgotPasswordForm" action="" method="POST">
                        <div class="form-group">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Your email address">
                            <i class="ik ik-mail"></i>
                            <div id="emailError" class="error" style="color: red;"></div>
                        </div>
                        <div class="sign-btn text-center">
                            <button type="submit" class="btn btn-dark" id="submitBtn">Submit</button>
                        </div>
                    </form>
                    <div class="register">
                        <p>Not a password? <a href="login.php">Login</a></p>
                    </div>
                    <div id="message" class="" style="display: none;"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>