<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 col-md-5">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <img id="profile-image" src="<?= base_url('public/img/default-avatar.jpg'); ?>" alt="Customer Avatar" class="img-fluid rounded-circle mb-2" width="128" height="128" />
                        <h4 class="card-title mt-10" id="users_username"></h4>
                        <p class="card-subtitle">Front End Developer</p>

                    </div>
                </div>
                <hr class="mb-0">
                <div class="card-body">

                    <h6></h6>
                    <div class="map-box">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d248849.886539092!2d77.49085452149588!3d12.953959988118836!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae1670c9b44e6d%3A0xf8dfc3e8517e4fe0!2sBengaluru%2C+Karnataka!5e0!3m2!1sen!2sin!4v1542005497600" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                    <small class="text-muted d-block pt-30">Social Profile</small>
                    <br />
                    <button class="btn btn-icon btn-facebook"><i class="fab fa-facebook-f"></i></button>
                    <button class="btn btn-icon btn-twitter"><i class="fab fa-twitter"></i></button>
                    <button class="btn btn-icon btn-instagram"><i class="fab fa-instagram"></i></button>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary" id="users_info-name">

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary" id="users-email">

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Gender</h6>
                        </div>
                        <div class="col-sm-9 text-secondary" id="users_info-gender">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Phone</h6>
                        </div>
                        <div class="col-sm-9 text-secondary" id="users_info-phone_no">
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Address</h6>
                        </div>
                        <div class="col-sm-9 text-secondary" id="users_info-address">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">City</h6>
                        </div>
                        <div class="col-sm-9 text-secondary" id="users_info-city">
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-sm-12">
                            <a href="<?= base_url('/staff/view');?>" class="btn btn-dark">Back to List</a>
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
        const params = new URLSearchParams(window.location.search);
        const staffId = params.get('id');

        if (staffId) {
            $.ajax({
                url: `<?= site_url('staff/details'); ?>/${staffId}`,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        const user = data.data;
                        $('#users_username').text(user.name);
                        $('#users_info-name').text(user.name);
                        $('#users-email').text(user.email);
                        $('#users_info-phone_no').text(user.phone_no);
                        $('#users_info-gender').text(user.gender);
                        $('#users_info-address').text(user.address);
                        $('#users_info-city').text(user.city);

                        if (user.image_url) {
                            $('#profile-image').attr('src', user.image_url);
                        }
                    } else {
                        alert(data.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error fetching staff details: ' + error);
                }
            });

        } else {
            alert('No customer ID provided.');
        }
    });
</script>

<?= $this->endSection(); ?>