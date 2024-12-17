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
                                <ul id="chat-box" class="chat-box"></ul>
                                <div class="sticky-bottom">
                                    <div id="file-preview" class="file-preview-container"></div>
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

                            const lastMessage = user.last_message ? user.last_message : '';

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
        let receiverId = null;

        $(document).on('click', '.person', function() {
            receiverId = $(this).data('user-id');
            $('#receiver_id').val(receiverId);
            $('.selected-user .name').text($(this).data('username'));
            loadMessages(receiverId);
        });

        function loadMessages(receiverId) {
            $.ajax({
                url: "<?= site_url('chat/getMessages'); ?>/" + receiverId,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    let messageHtml = '';
                    const currentUserId = "<?= session()->get('user_id'); ?>";

                    response.data.forEach(message => {
                        const alignment = message.sender_id == currentUserId ? 'message-right' : 'message-left';
                        const fileHtml = renderFiles(message.files);

                        messageHtml += `
                        <li class="chat-message ${alignment}">
                        <div class="message-box">
                        <p class="message-text">${message.message}</p>
                        ${fileHtml}
                        <span class="message-time">${message.sent_at}</span>
                        </div>
                        </li>`;
                    });

                    $('#chat-box').html(messageHtml);
                },
                error: function(xhr, status, error) {
                    console.error("Error loading messages:", error);
                }
            });
        }
        setInterval(function() {
            if (receiverId) {
                loadMessages(receiverId);
            }
        }, 1000);

        function renderFiles(files) {
            let fileHtml = '';
            if (files) {
                const fileArray = files.split(',');
                fileArray.forEach(file => {
                    const fileType = file.split('.').pop().toLowerCase();
                    const fileUrl = '<?= base_url('uploads/'); ?>' + file;

                    if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileType)) {
                        fileHtml += `<img src="${fileUrl}" alt="Image" class="message-image mx-2" style="height:70px;">`;
                    } else if (fileType === 'pdf') {
                        fileHtml += `<a href="${fileUrl}" target="_blank" class="file-link">View PDF</a>`;
                    } else {
                        fileHtml += `<a href="${fileUrl}" target="_blank" class="file-link">Download File</a>`;
                    }
                });
            }
            return fileHtml;
        }
        $('#file-input').on('change', function() {
            const files = $(this)[0].files;
            const fileListContainer = $('#file-preview');
            fileListContainer.empty();

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const fileType = file.type;
                const fileName = file.name;

                let fileElement;

                if (fileType.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        fileElement = `<div class="file-preview-item">
                                <img src="${e.target.result}" alt="Image" class="preview-image">
                                <p>${fileName}</p>
                               </div>`;
                        fileListContainer.append(fileElement);
                    };
                    reader.readAsDataURL(file);
                } else {
                    fileElement = `<div class="file-preview-item">
                            <p><i class="fa fa-file"></i> ${fileName}</p>
                          </div>`;
                    fileListContainer.append(fileElement);
                }
            }
        });


        $('#message-form').submit(function(e) {
            e.preventDefault();

            const formData = new FormData();
            formData.append('message', $('#message').val());
            formData.append('receiver_id', $('#receiver_id').val());

            const files = $('#file-input')[0].files;
            for (let i = 0; i < files.length; i++) {
                formData.append('files[]', files[i]);
            }

            $.ajax({
                url: "<?= site_url('chat/sendMessage'); ?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status === 'success') {
                        loadMessages($('#receiver_id').val());
                        $('#message').val('');
                    }
                }
            });
        });
    });
</script>

<?= $this->endSection(); ?>