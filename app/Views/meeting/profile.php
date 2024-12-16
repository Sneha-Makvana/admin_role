<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="row">

        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <h5 class="mb-0">Meeting Details</h5>
                        </div>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Meeting Title</h6>
                        </div>
                        <div class="col-sm-9 text-secondary" id="meetings-meeting_title">
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Meeting Date</h6>
                        </div>
                        <div class="col-sm-9 text-secondary" id="meetings-meeting_date">

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Start Time</h6>
                        </div>
                        <div class="col-sm-9 text-secondary" id="meetings-start_time">
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">End Time</h6>
                        </div>
                        <div class="col-sm-9 text-secondary" id="meetings-end_time">

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Agenda</h6>
                        </div>
                        <div class="col-sm-9 text-secondary" id="meetings-agenda">

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Staff Member</h6>
                        </div>
                        <div class="col-sm-9 text-secondary" id="users-username">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Project</h6>
                        </div>
                        <div class="col-sm-9 text-secondary" id="projects-project_name">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Location</h6>
                        </div>
                        <div class="col-sm-9 text-secondary" id="meetings-location">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <a href="<?= base_url('/meeting/view') ?>" class="btn btn-dark">Back to List</a>
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
        const meetingId = params.get('id');

        if (meetingId) {
            $.ajax({
                url: `<?= site_url('meeting/details'); ?>/${meetingId}`,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        const meetings = data.data;
                        $('#projects-project_name').text(meetings.project_name);
                        $('#users-username').text(meetings.username);
                        $('#meetings-meeting_title').text(meetings.meeting_title);
                        $('#meetings-meeting_date').text(meetings.meeting_date);
                        $('#meetings-start_time').text(meetings.start_time);
                        $('#meetings-end_time').text(meetings.end_time);
                        $('#meetings-agenda').text(meetings.agenda);
                        $('#meetings-location').text(meetings.location);
                    } else {
                        alert(data.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error fetching Meeting details: ' + error);
                }
            });
        } else {
            alert('No Meeting ID provided.');
        }
    });
</script>

<?= $this->endSection(); ?>