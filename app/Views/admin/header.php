<header class="header-top" header-theme="light">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <div class="top-menu d-flex align-items-center">
                <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>
                <div class="header-search">
                    <div class="input-group">
                        <span class="input-group-addon search-close"><i class="ik ik-x"></i></span>
                        <input type="text" class="form-control">
                        <span class="input-group-addon search-btn"><i class="ik ik-search"></i></span>
                    </div>
                </div>
                <!-- <button type="button" id="navbar-fullscreen" class="nav-link"><i class="ik ik-maximize"></i></button> -->
            </div>
            <div class="top-menu d-flex align-items-center">
                <h6 class="mt-3"> </h6>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        <img class="avatar" src=" " alt="User Profile Image">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="profile_admin.php"><i class="ik ik-user dropdown-icon"></i> Profile</a>
                        <a class="dropdown-item" href="change_pass.php"><i class="ik ik-lock dropdown-icon"></i> Change Password</a>

                        <a class="dropdown-item" href="settings.php"><i class="ik ik-settings dropdown-icon"></i> Settings</a>
                        <a class="dropdown-item" href="messages.php"><i class="ik ik-navigation dropdown-icon"></i> Message</a>

                        <a class="dropdown-item" href="<?= base_url('/logout')?>"><i class="ik ik-power dropdown-icon"></i> Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>