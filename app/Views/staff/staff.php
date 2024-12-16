<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-8 mx-5">
            <div class="card mt-5">
                <div class="card-header">
                    <h5 class="card-title mb-0 text-dark fs-4">Staff</h5>
                </div>
                <form action="" method="POST" enctype="multipart/form-data" id="staffForm">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="role" value="2">
                    <div class="card-body">
                        <div class="form-row align-items-center">
                            <input type="hidden" name="id" id="id">

                            <!-- Name Field -->
                            <div class="form-group col-md-3">
                                <label for="name" class="col-form-label">Name</label>
                            </div>
                            <div class="form-group col-md-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ik ik-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
                                </div>
                                <div class="error text-danger" id="nameError"></div>
                            </div>

                            <!-- Email Field -->
                            <div class="form-group col-md-3">
                                <label for="email" class="col-form-label">Email</label>
                            </div>
                            <div class="form-group col-md-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ik ik-mail"></i></span>
                                    </div>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
                                </div>
                                <div class="error text-danger" id="emailError"></div>
                            </div>

                            <!-- Password Field -->
                            <div class="form-group col-md-3">
                                <label for="password" class="col-form-label">Password</label>
                            </div>
                            <div class="form-group col-md-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ik ik-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                                </div>
                                <div class="error text-danger" id="passwordError"></div>
                            </div>

                            <!-- Gender Field -->
                            <div class="form-group col-md-3">
                                <label class="col-form-label">Gender</label>
                            </div>
                            <div class="form-group col-md-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="male">
                                    <label class="form-check-label">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" value="female">
                                    <label class="form-check-label">Female</label>
                                </div>
                                <div class="error text-danger" id="genderError"></div>
                            </div>

                            <!-- Address Field -->
                            <div class="form-group col-md-3">
                                <label for="address" class="col-form-label">Address</label>
                            </div>
                            <div class="form-group col-md-9">
                                <textarea class="form-control" name="address" id="address" rows="2" placeholder="Enter your address"></textarea>
                                <div class="error text-danger" id="addressError"></div>
                            </div>

                            <!-- City Field -->
                            <div class="form-group col-md-3">
                                <label for="city" class="col-form-label">City</label>
                            </div>
                            <div class="form-group col-md-9">
                                <select class="form-control" name="city" id="city" required>
                                    <option selected disabled>Select City</option>
                                    <option value="India">India</option>
                                    <option value="London">London</option>
                                    <option value="Japan">Japan</option>
                                    <option value="Canada">Canada</option>
                                    <option value="Dubai">Dubai</option>
                                    <option value="UK">UK</option>
                                </select>
                                <div class="error text-danger" id="cityError"></div>
                            </div>

                            <!-- Phone Field -->
                            <div class="form-group col-md-3">
                                <label for="phone_no" class="col-form-label">Phone No.</label>
                            </div>
                            <div class="form-group col-md-9">
                                <input type="tel" class="form-control" id="phone_no" name="phone_no" placeholder="Enter your phone number" pattern="[0-9]{10}">
                                <div class="error text-danger" id="phone_noError"></div>
                            </div>

                            <!-- Profile Image Field -->
                            <div class="form-group col-md-3">
                                <label for="image" class="col-form-label">Profile Image</label>
                            </div>
                            <div class="form-group col-md-9">
                                <input type="file" class="form-control" name="image" id="image" accept="image/*">
                                <div class="error text-danger" id="imageError"></div>
                                <input type="hidden" name="existing_profile_image" id="existing_profile_image" value="">
                                <div id="currentProfileImage"></div>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group col-md-9 offset-md-3">
                                <button type="submit" id="submitBtn" class="btn btn-dark mt-4"><i class="ik ik-clipboard"></i> Save Staff</button>
                            </div>
                        </div>
                        <div id="responseMessage" class="mt-3"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        const id = getQueryParameter('id');
        if (id) {
            fetchUserData(id);
        }

        function fetchUserData(id) {
            $.ajax({
                url: `<?= base_url('/staff/fetchUsers/') ?>${id}`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        populateForm(response.data);
                    } else {
                        alert('Failed to fetch user data: ' + response.message);
                    }
                },
                error: function() {
                    alert('An error occurred while fetching user data.');
                }
            });
        }

        function populateForm(data) {
            $("#id").val(data.id);
            $("#name").val(data.name);
            $("#email").val(data.email);
            $(`input[name="gender"][value="${data.gender}"]`).prop("checked", true);
            $("#address").val(data.address);
            $("#city").val(data.city);
            $("#phone_no").val(data.phone_no);
            $("#existing_profile_image").val(data.profile_image);

            if (data.profile_image) {
                $('#currentProfileImage').html(`<img src="<?= base_url('uploads/') ?>${data.profile_image}" alt="Profile Image" style="max-width: 100px; max-height: 200px;"/>`);
            } else {
                $('#currentProfileImage').html('<p>No image uploaded.</p>');
            }
        }


        function getQueryParameter(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        $("#staffForm").on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const formAction = id ? 'update' : 'insert';

            $(".error").html("");

            $.ajax({
                url: `<?= base_url('staff/') ?>${formAction}`,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        $("#responseMessage").html('<p class="text-success">' + response.message + ' <a href="<?= base_url('/staff/view');?>">View</a>' +'</p>');
                    } else {
                        $.each(response.errors, function(key, value) {
                            $('#' + key + 'Error').html('<p class="text-danger">' + value + '</p>');
                        });
                    }
                },

                error: function() {
                    $("#responseMessage").html('<p class="text-danger">An error occurred while submitting the form. Please try again.</p>');
                }
            });
        });
    });
</script>

<?= $this->endSection(); ?>