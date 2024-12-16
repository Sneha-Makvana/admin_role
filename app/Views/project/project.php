<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-8 mx-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0 text-dark fs-4">Project</h5>
                </div>
                <form id="addProjectForm" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        <input type="hidden" name="id" id="id">

                        <!-- Project Name -->
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="project_name" class="col-form-label">Project Name</label>
                            </div>
                            <div class="form-group col-md-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="ik ik-user"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="project_name" id="project_name" placeholder="Enter your project name">
                                </div>
                                <div class="error" id="project_nameError"></div>
                            </div>
                        </div>

                        <!-- Staff Name -->
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="staff" class="col-form-label">Staff Name</label>
                            </div>
                            <div class="form-group col-md-9">
                                <select class="form-control" id="user_id" name="user_id">
                                    <option selected disabled>Select Staff</option>
                                    <?php if (isset($staff) && !empty($staff)) : ?>
                                        <?php foreach ($staff as $user) : ?>
                                            <option value="<?= $user['id'] ?>"><?= $user['username'] ?></option>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <option disabled>No staff available</option>
                                    <?php endif; ?>
                                </select>
                                <div class="error" id="user_idError"></div>
                            </div>
                        </div>

                        <!-- Project Description -->
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="description" class="col-form-label">Project Description</label>
                            </div>
                            <div class="form-group col-md-9">
                                <div class="input-group">
                                    <textarea class="form-control" name="description" id="description" rows="4" placeholder="Enter description"></textarea>
                                </div>
                                <div class="error" id="descriptionError"></div>
                            </div>
                        </div>

                        <!-- Budget -->
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="budget" class="col-form-label">Budget</label>
                            </div>
                            <div class="form-group col-md-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="ik ik-file"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="budget" id="budget" placeholder="Enter budget">
                                </div>
                                <div class="error" id="budgetError"></div>
                            </div>
                        </div>

                        <!-- Start Date -->
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="start_date" class="col-form-label">Project Start Date</label>
                            </div>
                            <div class="form-group col-md-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="ik ik-arrow-up-circle"></i>
                                        </span>
                                    </div>
                                    <input type="datetime-local" class="form-control" name="start_date" id="start_date">
                                </div>
                                <div class="error" id="start_dateError"></div>
                            </div>
                        </div>

                        <!-- End Date -->
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="end_date" class="col-form-label">Project End Date</label>
                            </div>
                            <div class="form-group col-md-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="ik ik-arrow-down-circle"></i>
                                        </span>
                                    </div>
                                    <input type="datetime-local" class="form-control" name="end_date" id="end_date">
                                </div>
                                <div class="error" id="end_dateError"></div>
                            </div>
                        </div>

                        <!-- Project Status -->
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="status" class="col-form-label">Project Status</label>
                            </div>
                            <div class="form-group col-md-9">
                                <select class="form-control" id="project_status" name="project_status">
                                    <option selected disabled>Select Status</option>
                                    <option value="Ongoing">Ongoing</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Pending">Pending</option>
                                    <option value="On Hold">On Hold</option>
                                </select>
                                <div class="error" id="project_statusError"></div>
                            </div>
                        </div>

                        <!-- Upload New Files -->
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label for="project_files" class="col-form-label">Upload Project Files</label>
                            </div>
                            <div class="form-group col-md-9">
                                <input type="file" class="form-control" id="project_files" name="project_files[]" accept="application/pdf, image/*" multiple>
                                <input type="hidden" name="existing_project_files" id="existing_project_files" value="<?= isset($project['project_files']) ? htmlspecialchars($project['project_files'], ENT_QUOTES, 'UTF-8') : '' ?>">
                                <div class="error" id="project_filesError"></div>
                                <div id="currentProjectFiles">
                                </div>
                            </div>

                        </div>

                        <!-- Submit Button -->
                        <div class="form-row">
                            <div class="form-group col-md-12 mx-3">
                                <button type="submit" class="btn btn-dark mt-2"><i class="ik ik-clipboard"></i> Save Project</button>
                            </div>
                            <div id="responseMessage" class="mt-3"></div>
                        </div>
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
                url: `<?= base_url('/project/fetchProject/') ?>${id}`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        populateForm(response.data);
                    } else {
                        alert('Failed to fetch project data: ' + response.message);
                    }
                },
                error: function() {
                    alert('An error occurred while fetching project data.');
                }
            });
        }

        function populateForm(data) {
            $("#id").val(data.id);
            $("#user_id").val(data.user_id);
            $("#project_name").val(data.project_name);
            $("#description").val(data.description);
            $("#start_date").val(data.start_date);
            $("#end_date").val(data.end_date);
            $("#budget").val(data.budget);
            $("#project_status").val(data.project_status);

            $("#existing_project_files").val(data.project_files);

            if (data.project_files) {
                let files = JSON.parse(data.project_files);
                let fileLinks = files.map(file => `<p>Current file: <a href="<?= base_url() ?>/uploads/${file}" target="_blank">${file}</a></p>`).join('');
                $("#currentProjectFiles").html(fileLinks);
            }

        }


        function getQueryParameter(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        $("#addProjectForm").on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const formAction = id ? 'update' : 'insert';

            $(".error").html("");

            $.ajax({
                url: `<?= base_url('project/') ?>${formAction}`,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        $("#responseMessage").html('<p class="text-success">' + response.message + ' <a href="<?= base_url('/project/view');?>">View</a></p>');
                        $("#addProjectForm")[0].reset();
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