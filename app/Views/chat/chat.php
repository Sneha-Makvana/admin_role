<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<link rel="stylesheet" href="<?= base_url('public/assets/style.css'); ?>">

<div class="mainn">
    <div class="content-wrapper">
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card m-0">
                    <div class="row no-gutters">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-3 col-3">
                            <div class="users-container">
                                <div class="chat-search-box">
                                    <div class="input-group">
                                        <input class="form-control" placeholder="Search">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-info">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <ul class="users" id="users"></ul>
                            </div>
                        </div>
                        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-9 col-9">
                            <div class="selected-user">
                                <span>To: <span class="name">Select User</span></span>
                            </div>

                            <div class="chat-container">
                                <ul id="chat-box" class="chat-box chatContainerScroll"></ul>
                                <div class="sticky-bottom">
                                    <form id="message-form" class="form-group mt-3 mb-0 position-relative" enctype="multipart/form-data">
                                        <div class="d-flex">
                                            <textarea class="form-control" id="message" name="message" placeholder="Type your message here..." style="padding-right: 40px;"></textarea>
                                            <input type="hidden" id="receiver_id" name="receiver_id">
                                            <input type="file" id="file-input" name="files[]" multiple accept="image/*,application/pdf" class="d-none">
                                            <label for="file-input" class="btn btn-secondary mx-2">
                                                <i class="fa fa-paperclip"></i>
                                            </label>
                                        </div>
                                        <button type="submit" id="send-btn" class="btn btn-primary send-icon">
                                            <i class="fa fa-paper-plane"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
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
        fetchUsers();

        $(document).on('click', '.person', function() {
            const receiverId = $(this).data('user-id');
            const receiverName = $(this).data('username');

            $('#receiver_id').val(receiverId);
            $('.selected-user .name').text(receiverName);
            $('#chat-box').empty();
            loadMessages(receiverId);
        });

        function fetchUsers() {
            $.ajax({
                url: "<?= site_url('chat/getUsers'); ?>",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        const users = response.data;
                        let userHtml = '';
                        users.forEach(user => {
                            const profileImage = user.profile_image ?
                                '<?= base_url('uploads/'); ?>' + user.profile_image :
                                'https://www.bootdey.com/img/Content/avatar/avatar1.png';

                            const lastMessage = user.last_message ? user.last_message : 'No messages yet';

                            userHtml += `
                            <li class="person" data-user-id="${user.id}" data-username="${user.name}">
                                <div class="user">
                                    <img src="${profileImage}" alt="${user.name}">
                                </div>
                                <p class="name-time">
                                    <span class="name">${user.name}</span>
                                    <span class="time">${lastMessage}</span>
                                </p>
                            </li>`;
                        });
                        $('#users').html(userHtml);
                    } else {
                        alert("Failed to fetch users");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching users:", error);
                }
            });
        }

        function loadMessages(receiverId) {
            $.ajax({
                url: "<?= site_url('chat/getMessages'); ?>/" + receiverId,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        const messages = response.data;
                        let messageHtml = '';
                        messages.forEach(message => {
                            messageHtml += `
                            <li class="chat-message">
                                <div class="message">${message.message}</div>
                            </li>`;
                        });
                        $('#chat-box').html(messageHtml);
                    } else {
                        alert("Failed to load messages");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error loading messages:", error);
                }
            });
        }

        $('#message-form').submit(function(event) {
            event.preventDefault();

            const message = $('#message').val();
            const receiver_id = $('#receiver_id').val();

            if (!message || !receiver_id) {
                alert('Please select a user and type a message.');
                return;
            }

            $.ajax({
                url: "<?= site_url('chat/sendMessage'); ?>",
                type: "POST",
                data: {
                    message: message,
                    receiver_id: receiver_id,
                    files: $('#file-input')[0].files
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === 'success') {
                        $('#message').val('');
                        $('#file-input').val('');
                        loadMessages(receiver_id);
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error sending message:", error);
                }
            });
        });
    });
</script>

<?= $this->endSection(); ?>