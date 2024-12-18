<div class="app-sidebar colored">
    <div class="sidebar-header">
        <a class="header-brand" href="<?= base_url('/admin'); ?>">
            <div class="logo-img">
                <img src="<?= base_url('public/assets/src/img/brand-white.svg'); ?>" class="header-brand-img" alt="lavalite">
            </div>
            <span class="text">ThemeKit</span>
        </a>
    </div>

    <div class="sidebar-content bg-dark">
        <div class="nav-container">
            <nav id="main-menu-navigation" class="navigation-main">
                <div class="nav-item">
                    <a href="<?= base_url('/admin'); ?>"><i class="ik ik-bar-chart-2"></i><span>Dashboard</span></a>
                </div>

                <?php if (session()->get('role') == 1) : ?>
                    <div class="nav-item has-sub">
                        <a href="javascript:void(0)"><i class="ik ik-users"></i><span>Users</span></a>
                        <div class="submenu-content bg-dark">
                            <a href="<?= base_url('/staff/view'); ?>" class="menu-item">All Staff</a>
                            <a href="<?= base_url('/staff'); ?>" class="menu-item">Add Staff</a>
                        </div>
                    </div>

                    <div class="nav-item has-sub">
                        <a href="#"><i class="ik ik-box"></i><span>Projects</span></a>
                        <div class="submenu-content bg-dark">
                            <a href="<?= base_url('/project/view'); ?>" class="menu-item">All Projects</a>
                            <a href="<?= base_url('/project'); ?>" class="menu-item">Add Projects</a>
                        </div>
                    </div>

                    <div class="nav-item has-sub">
                        <a href="#"><i class="ik ik-briefcase"></i><span>Meetings</span></a>
                        <div class="submenu-content bg-dark">
                            <a href="<?= base_url('/meeting/view'); ?>" class="menu-item">All Meetings</a>
                            <a href="<?= base_url('/meeting'); ?>" class="menu-item">Add Meeting</a>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (session()->get('role') == 2) : ?>
                    <div class="nav-item has-sub">
                        <a href="#"><i class="ik ik-box"></i><span>Projects</span></a>
                        <div class="submenu-content bg-dark">
                            <a href="<?= base_url('/project/view'); ?>" class="menu-item">View Projects</a>
                        </div>
                    </div>

                    <div class="nav-item has-sub">
                        <a href="#"><i class="ik ik-briefcase"></i><span>Meetings</span></a>
                        <div class="submenu-content bg-dark">
                            <a href="<?= base_url('/meeting/view'); ?>" class="menu-item">View Meetings</a>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="nav-item">
                    <a href="<?= base_url('/chat'); ?>"><i class="ik ik-airplay"></i><span>Chat</span></a>
                </div>

            </nav>
        </div>
    </div>
</div>