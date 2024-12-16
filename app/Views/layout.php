<!doctype html>
<html class="no-js" lang="en">

<head>
    <?= $this->include('admin/header_link'); ?>
    <title>Project Management System</title>
</head>

<body>
    <div class="wrapper">
        <?= $this->include('admin/header.php'); ?>

        <div class="page-wrap">
            <?= $this->include('admin/sidebar.php'); ?>

            <div class="main-content">
                <?= $this->renderSection('content'); ?>
            </div>

            <?= $this->include('admin/footer.php'); ?>
        </div>
    </div>
    <?= $this->include('admin/footer_link.php'); ?>

</body>

</html>