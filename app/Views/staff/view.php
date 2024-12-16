<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="container-fluid">

    <div class="card">
        <div class="card-header row">
            <h3 class="mx-3">All Staffs</h3>
            <a class="staff" href="<?= base_url('/staff');?>" role="button"><button type="button" class="btn btn-dark btn-rounded">Add Staff</button></a>
        </div>
        <div class="card-body">
            <table id="myTable" class="table table-striped table-hover table-active table-bordered">
                <thead>
                    <tr>
                        <th class="table-dark text-light">Profile</th>
                        <th class="table-dark text-light">Name</th>
                        <th class="table-dark text-light">Email</th>
                        <th class="table-dark text-light">Address</th>
                        <th class="table-dark text-light">Phone No.</th>
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
<script>
    $(document).ready(function() {
        function loadCustomers() {
            $.ajax({
                url: "<?= site_url('staff/fetch'); ?>",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    var rows = '';
                    $.each(data, function(index, users) {

                        const profileImageUrl = users.profile_image ? `<?= base_url('uploads/'); ?>${users.profile_image}` : '<?= base_url('public/uploads/customers/default-avatar.jpg'); ?>';

                        rows += `
                        <tr id="users_info-${users.id}">
                            <td><img src="${profileImageUrl}" alt="Profile Image" class="img-fluid rounded-circle" width="40" height="40" /></td>
                            <td>${users.name}</td>
                            <td>${users.email}</td>
                            <td>${users.address}</td>
                            <td>${users.phone_no}</td>
                            <td>
                                <a href="<?= base_url('/staff/profile') ?>?id=${users.id}">
                                <i class='ik ik-eye f-18 mr-15 text-blue'></i>
                                </a>
                                <a href="<?= base_url('/staff') ?>?id=${users.id}">
                                <i class='ik ik-edit f-18 mr-15 text-green'></i>
                                </a>
                                <a href="javascript:void(0);" class="delete-btn" data-id="${users.id}">
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

        loadCustomers();

        $('#myTable').on('click', '.delete-btn', function() {
            const staffId = $(this).data('id');
            if (confirm('Are you sure you want to delete this staff?')) {
                $.ajax({
                    url: `<?= site_url('staff/delete'); ?>/${staffId}`,
                    type: "POST",
                    success: function(response) {
                        if (response.success) {
                            $(`#users_info-${staffId}`).remove();
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