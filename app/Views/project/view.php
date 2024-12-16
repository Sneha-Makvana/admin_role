<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid">

    <div class="card">
        <div class="card-header row">
            <h3 class="mx-3">All Projects</h3>

            <a class="staff" href="<?= base_url('/project'); ?>" role="button"><button type="button" class="btn btn-dark btn-rounded">Add Project</button></a>

        </div>
        <div class="card-body">
            <table id="myTable" class="table table-striped table-hover table-active">
                <thead>
                    <tr>
                        <th class="table-dark text-light">Project Name</th>
                        <th class="table-dark text-light">Budget</th>
                        <th class="table-dark text-light">Start date</th>
                        <th class="table-dark text-light">End date</th>
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
        function loadProjects() {
            $.ajax({
                url: "<?= site_url('project/fetch'); ?>",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    var rows = '';
                    $.each(data, function(index, projects) {

                        const projectFileUrl = projects.profile_image ? `<?= base_url('uploads/'); ?>${projects.project_files}` : '<?= base_url('public/uploads/customers/default-avatar.jpg'); ?>';

                        rows += `
                        <tr id="projects-${projects.id}">
                            <td>${projects.project_name}</td>
                            <td>${projects.budget}</td>
                            <td>${projects.start_date}</td>
                            <td>${projects.end_date}</td>
                            <td>${projects.username}</td>
                            <td>
                                <a href="<?= base_url('/project/profile') ?>?id=${projects.id}">
                                <i class='ik ik-eye f-18 mr-15 text-blue'></i>
                                </a>
                                <a href="<?= base_url('/project') ?>?id=${projects.id}">
                                <i class='ik ik-edit f-18 mr-15 text-green'></i>
                                </a>
                                <a href="javascript:void(0);" class="delete-btn" data-id="${projects.id}">
                                <i class='ik ik-trash-2 f-18 mr-15 text-red'></i>
                                </a>
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

        loadProjects();

        $('#myTable').on('click', '.delete-btn', function() {
            const projectId = $(this).data('id');
            if (confirm('Are you sure you want to delete this project?')) {
                $.ajax({
                    url: `<?= site_url('project/delete'); ?>/${projectId}`,
                    type: "POST",
                    success: function(response) {
                        if (response.success) {
                            $(`#projects-${projectId}`).remove();

                            loadProjects();

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