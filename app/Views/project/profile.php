<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h5 class="mb-0">Project Details</h5>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Project Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary" id="projects-project_name">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Staff Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary" id="users-username">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Description</h6>
                        </div>
                        <div class="col-sm-9 text-secondary" id="projects-description">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Budget</h6>
                        </div>
                        <div class="col-sm-9 text-secondary" id="projects-budget">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Start Date</h6>
                        </div>
                        <div class="col-sm-9 text-secondary" id="projects-start_date">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">End Date</h6>
                        </div>
                        <div class="col-sm-9 text-secondary" id="projects-end_date">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Status</h6>
                        </div>
                        <div class="col-sm-9 text-secondary" id="projects-project_status">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Files</h6>
                        </div>
                        <div class="col-sm-9 text-secondary" id="projects-project_files">
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-sm-12">
                            <a href="<?= base_url('/project/view');?>" class="btn btn-dark">Back to List</a>
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
        const projectId = params.get('id');

        if (projectId) {
            $.ajax({
                url: `<?= site_url('project/details'); ?>/${projectId}`,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        const project = data.data;
                        $('#projects-project_name').text(project.project_name);
                        $('#users-username').text(project.username);
                        $('#projects-description').text(project.description);
                        $('#projects-budget').text(project.budget);
                        $('#projects-start_date').text(project.start_date);
                        $('#projects-end_date').text(project.end_date);
                        $('#projects-project_status').text(project.project_status);

                        if (project.file_urls && project.file_urls.length > 0) {
                            project.file_urls.forEach(function(url) {
                                const fileExtension = url.split('.').pop().toLowerCase();
                                if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'].includes(fileExtension)) {
                                    const imgElement = $('<img>')
                                        .attr('src', url)
                                        .css('max-width', '50%')
                                        .css('height', 'auto')
                                        .css('margin-left', '10px')
                                        .addClass('mb-2');
                                    $('#projects-project_files').append(imgElement);
                                } else {
                                    const linkElement = $('<a>')
                                        .attr('href', url)
                                        .attr('target', '_blank')
                                        .text('Download File')
                                        .addClass('d-block mb-2');
                                    $('#projects-project_files').append(linkElement);
                                }
                            });
                        }
                    } else {
                        alert(data.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error fetching project details: ' + error);
                }
            });
        } else {
            alert('No project ID provided.');
        }
    });
</script>

<?= $this->endSection(); ?>