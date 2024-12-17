<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="card">
        <div class="card-header row">
            <h3 class="mx-3">All Meetings</h3>
            <?php if (session()->get('role') == 1) : ?>
                <a class="staff" href="<?= base_url('/meeting'); ?>" role="button">
                    <button type="button" class="btn btn-dark btn-rounded">Add Meeting</button>
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <table id="myTable" class="table table-striped table-hover table-active">
                <thead>
                    <tr>
                        <th class="table-dark text-light">Title</th>
                        <th class="table-dark text-light">Date</th>
                        <th class="table-dark text-light">Start Time</th>
                        <th class="table-dark text-light">End Time</th>
                        <th class="table-dark text-light">Project</th>
                        <th class="table-dark text-light">Staff</th>
                        <th class="table-dark text-light">Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script> -->
<script>
    $(document).ready(function() {
        function loadMeetings() {
            $.ajax({
                url: "<?= site_url('meeting/fetch'); ?>",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    var rows = '';
                    $.each(data, function(index, meetings) {
                        let actionButtons = '';
                        <?php if (session()->get('role') == 1) : ?>
                            actionButtons = `
                            <a href="<?= base_url('/meeting') ?>?id=${meetings.id}">
                                <i class='ik ik-edit f-18 mr-15 text-green'></i>
                            </a>
                            <a href="javascript:void(0);" class="delete-btn" data-id="${meetings.id}">
                                <i class='ik ik-trash-2 f-18 mr-15 text-red'></i>
                            </a>
                        `;
                        <?php endif; ?>

                        rows += `
                        <tr id="meetings-${meetings.id}">
                            <td>${meetings.meeting_title}</td>
                            <td>${meetings.meeting_date}</td>
                            <td>${meetings.start_time}</td>
                            <td>${meetings.end_time}</td>
                            <td>${meetings.project_name}</td>
                            <td>${meetings.username}</td>
                            <td>
                                <a href="<?= base_url('/meeting/profile') ?>?id=${meetings.id}">
                                    <i class='ik ik-eye f-18 mr-15 text-blue'></i>
                                </a>
                                ${actionButtons} <!-- Edit and delete buttons only for role 1 -->
                            </td>
                        </tr>`;
                    });
                    $('#myTable tbody').html(rows);
                    feather.replace();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data: ' + error);
                }
            });
        }

        loadMeetings();

        $('#myTable').on('click', '.delete-btn', function() {
            const meetingId = $(this).data('id');
            if (confirm('Are you sure you want to delete this meeting?')) {
                $.ajax({
                    url: `<?= site_url('meeting/delete'); ?>/${meetingId}`,
                    type: "POST",
                    success: function(response) {
                        if (response.success) {
                            $(`#meetings-${meetingId}`).remove();
                            loadMeetings();
                            alert(response.message);
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error deleting record: ' + error);
                    }
                });
            }
        });
    });
</script>

<?= $this->endSection(); ?>