<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-8 mx-5">
            <div class="card mt-5">
                <div class="card-header">
                    <h5 class="card-title mb-0 text-dark fs-4">Schedule a Meeting</h5>
                </div>
                <form id="addMeetingForm" method="POST">
                    <?= csrf_field(); ?>
                    <div class="card-body">
                        <div class="form-row align-items-center">
                            <!-- Meeting Title -->
                            <div class="form-group col-md-3">
                                <label for="title" class="col-form-label">Meeting Title</label>
                            </div>
                            <div class="form-group col-md-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="ik ik-message-square"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="meeting_title" name="meeting_title" placeholder="Enter meeting title">
                                </div>
                                <div class="error" id="meeting_titleError"></div>
                            </div>

                            <!-- Meeting Date -->
                            <div class="form-group col-md-3">
                                <label for="date" class="col-form-label">Meeting Date</label>
                            </div>
                            <div class="form-group col-md-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="ik ik-calendar"></i>
                                        </span>
                                    </div>
                                    <input type="date" class="form-control" id="meeting_date" name="meeting_date">
                                </div>
                                <div class="error" id="meeting_dateError"></div>
                            </div>

                            <!-- Start Time -->
                            <div class="form-group col-md-3">
                                <label for="start_time" class="col-form-label">Start Time</label>
                            </div>
                            <div class="form-group col-md-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="ik ik-arrow-up-circle"></i>
                                        </span>
                                    </div>
                                    <input type="time" class="form-control" id="start_time" name="start_time">
                                </div>
                                <div class="error" id="start_timeError"></div>
                            </div>

                            <!-- End Time -->
                            <div class="form-group col-md-3">
                                <label for="end_time" class="col-form-label">End Time</label>
                            </div>
                            <div class="form-group col-md-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="ik ik-arrow-down-circle"></i>
                                        </span>
                                    </div>
                                    <input type="time" class="form-control" id="end_time" name="end_time">
                                </div>
                                <div class="error" id="end_timeError"></div>
                            </div>

                            <!-- Agenda -->
                            <div class="form-group col-md-3">
                                <label for="agenda" class="col-form-label">Agenda</label>
                            </div>
                            <div class="form-group col-md-9">

                                <textarea class="form-control" id="agenda" name="agenda" rows="3" placeholder="Enter meeting agenda"></textarea>
                                <div class="error" id="agendaError"></div>
                            </div>

                            <!-- Staff -->
                            <div class="form-group col-md-3">
                                <label for="staff" class="col-form-label">Staff</label>
                            </div>
                            <div class="form-group col-md-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="ik ik-user"></i>
                                        </span>
                                    </div>
                                    <select class="form-control" id="user_id" name="user_id">
                                        <option selected disabled>Select Staff</option>
                                        <?php foreach ($users as $user) : ?>
                                            <option value="<?= $user['id'] ?>"><?= $user['username'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="error" id="user_idError"></div>
                            </div>

                            <!-- Project -->
                            <div class="form-group col-md-3">
                                <label for="project" class="col-form-label">Project</label>
                            </div>
                            <div class="form-group col-md-9">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="ik ik-plus-square"></i>
                                        </span>
                                    </div>
                                    <select class="form-control" id="project_id" name="project_id">
                                        <option selected disabled>Select Project</option>
                                        <?php foreach ($projects as $project) : ?>
                                            <option value="<?= $project['id'] ?>"><?= $project['project_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="error" id="project_idError"></div>
                            </div>

                            <!-- Location -->
                            <div class="form-group col-md-3">
                                <label for="location" class="col-form-label">Location</label>
                            </div>
                            <div class="form-group col-md-9">
                                <textarea class="form-control" id="location" name="location" rows="2" placeholder="Enter location"></textarea>
                                <div class="error" id="locationError"></div>
                            </div>
                        </div>
                        <button type="submit" id="submitMeeting" class="btn btn-dark mt-3"><i class="ik ik-clipboard"></i>Save Meeting</button>
                    </div>
                    <div id="responseMessage" class="mt-3"></div>
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
            fetchMeetingData(id);
        }

        function fetchMeetingData(id) {
            $.ajax({
                url: `<?= base_url('/meeting/fetchMeeting/') ?>${id}`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        populateForm(response.data);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('Failed to fetch meeting data.');
                }
            });
        }

        function populateForm(data) {
            $("#meeting_title").val(data.meeting_title);
            $("#meeting_date").val(data.meeting_date);
            $("#start_time").val(data.start_time);
            $("#end_time").val(data.end_time);
            $("#agenda").val(data.agenda);
            $("#user_id").val(data.user_id);
            $("#project_id").val(data.project_id);
            $("#location").val(data.location);
        }

        function getQueryParameter(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        $("#addMeetingForm").on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const formAction = id ? 'update' : 'insert';

            if (id) {
                formData.append('id', id);
            }

            $(".error").html(""); 
            $.ajax({
                url: `<?= base_url('meeting/') ?>${formAction}`,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        $("#responseMessage").html('<p class="text-success">' + response.message + ' <a href="<?= base_url('/meeting/view');?>">View</a>' + '</p>');
                        if (!id) $("#addMeetingForm")[0].reset();
                    } else {
                        $.each(response.errors, function(key, value) {
                            $('#' + key + 'Error').html('<p class="text-danger">' + value + '</p>');
                        });
                    }
                },
                error: function() {
                    $("#responseMessage").html('<p class="text-danger">An error occurred. Please try again.</p>');
                }
            });
        });

    });
</script>
<?= $this->endSection(); ?>