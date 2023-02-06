<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="treeview <?php if ('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']===base_url().'admin') echo 'active-bg'; ?>">
                <a href="<?php echo base_url() ?>admin">
                    <i class="fas fa-chart-bar"></i><span>Thống kê</span>
                </a>
            </li>
            <li class="header">QUẢN LÝ CỬA HÀNG</li>
            <li class="treeview <?php if (strpos($_SERVER['REQUEST_URI'],'admin/content')) echo 'active-bg'; ?>">
                <a href="<?php echo base_url() ?>admin/content">
                    <i class="fas fa-newspaper"></i><span>Tin tức</span>
                </a>
            </li>
            <li class="treeview <?php if (strpos($_SERVER['REQUEST_URI'],'admin/product')) echo 'active-bg'; ?>">
                <a href="<?php echo base_url()?>admin/product">
                    <i class="fas fa-boxes"></i><span>Sản phẩm</span>
                </a>
            </li>
            <li class="treeview <?php if (strpos($_SERVER['REQUEST_URI'],'admin/category')) echo 'active-bg'; ?>">
                <a href="<?php echo base_url()?>admin/category">
                    <i class="fas fa-box"></i><span>Loại sản phẩm</span>
                </a>
            </li>
            <li class="treeview <?php if (strpos($_SERVER['REQUEST_URI'],'admin/producer')) echo 'active-bg'; ?>">
                <a href="<?php echo base_url()?>admin/producer">
                    <i class="fa fa-gift"></i><span>Nhà cung cấp</span>
                </a>
            </li>
            <li class="header">QUẢN LÝ BÁN HÀNG</li>
            <li class="treeview <?php if (strpos($_SERVER['REQUEST_URI'],'admin/coupon')) echo 'active-bg'; ?>">
                <a href="<?php echo base_url() ?>admin/coupon">
                    <i class="fas fa-ticket-alt"></i><span>Mã giảm giá</span>
                </a>
            </li>
            <li class="treeview <?php if (strpos($_SERVER['REQUEST_URI'],'admin/contact')) echo 'active-bg'; ?>">
                <a href="<?php echo base_url() ?>admin/contact">
                    <i class="fas fa-address-card"></i><span>Liên hệ</span>
                </a>
            </li>
            <li class="treeview <?php if (strpos($_SERVER['REQUEST_URI'],'admin/orders')) echo 'active-bg'; ?>">
                <a href="<?php echo base_url() ?>admin/orders">
                    <i class="fa fa-shopping-cart"></i> <span>Đơn hàng</span>
                </a>
            </li>
            <li class="treeview <?php if (strpos($_SERVER['REQUEST_URI'],'admin/customer')) echo 'active-bg'; ?>">
                <a href="<?php echo base_url() ?>admin/customer">
                    <i class="fa fa-user"></i><span>Khách hàng</span>
                </a>
            </li>
            <li class="treeview <?php if (strpos($_SERVER['REQUEST_URI'],'admin/sliders')) echo 'active-bg'; ?>">
             <a href="<?php echo base_url() ?>admin/sliders">
                 <i class="fas fa-wrench"></i><span>Giao diện</span>
            </a>
        </li>
        <li class="header">CÀI ĐẶT</li>
        <li class="treeview <?php if (strpos($_SERVER['REQUEST_URI'],'admin/configuration/update/')|| strpos($_SERVER['REQUEST_URI'],'admin/useradmin')) echo 'active'; ?>">
            <a href="#">
                <i class="fa fa-cogs"></i><span>Hệ thống</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu <?php if (strpos($_SERVER['REQUEST_URI'],'admin/configuration/update/')|| strpos($_SERVER['REQUEST_URI'],'admin/useradmin')) echo 'menu-open'; ?>">
                <li class="<?php if (strpos($_SERVER['REQUEST_URI'],'admin/configuration/update/')) echo 'active-bg'; ?>">
                    <a href="<?php echo base_url() ?>admin/configuration/update/">
                        <i class="fas fa-cogs"></i><span>Cấu hình</span>
                    </a>
                </li>
                <?php if($user['role'] == 1){ ?>
                <li class="<?php if (strpos($_SERVER['REQUEST_URI'],'admin/useradmin')) echo 'active-bg'; ?>">
                    <a href="admin/useradmin">
                        <i class="fa fa-users"></i><span>Nhân viên</span>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </li>
        <li>
            <a href="admin/user/logout">
                <i class="fas fa-times"></i>
                <span>Thoát</span>
            </a>
        </li>
    </ul>
</section>
<!-- /.sidebar -->
</aside>