<header class="header-top" header-theme="light">
    <div class="container-fluid">
        <div class="d-flex justify-content-between">
            <div class="top-menu d-flex align-items-center">
                <button type="button" class="btn-icon mobile-nav-toggle d-lg-none"><span></span></button>
                <div class="header-search">
                    <div class="input-group">
                        <span class="input-group-addon search-close"><i class="ik ik-x"></i></span>
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-addon search-btn"><i class="ik ik-search"></i></span>
                    </div>
                </div>
            </div>

            <div class="top-menu d-flex align-items-center">
                <h6 class="mt-3 me-3 text-dark">
                    <?= esc(session()->get('username') ?? 'User'); ?>
                </h6>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="avatar rounded-circle" src="<?= base_url('uploads/' . (session()->get('profile_image') ?? 'default.png')); ?>" alt="Profile Image" width="40" height="40">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="<?= base_url('/admin/profile'); ?>"><i class="ik ik-user dropdown-icon"></i> Profile</a>
                        <a class="dropdown-item" href="<?= base_url('/admin/changePass'); ?>"><i class="ik ik-lock dropdown-icon"></i> Change Password</a>
                        <a class="dropdown-item" href="<?= base_url('logout'); ?>"><i class="ik ik-power dropdown-icon"></i> Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>