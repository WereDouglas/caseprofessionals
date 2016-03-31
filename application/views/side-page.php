
<div class="sidebar" id="sidebar">

    <ul class="nav nav-list">
        <h4>
            <?php echo $this->session->userdata('name'); ?>
        </h4>
        <a href="#">
            <img  height="50px" width="100px" class="" src="<?= base_url(); ?>uploads/<?php echo $this->session->userdata('orgimage'); ?>" alt="logo" />
        </a>
         <li>
            <a href="<?php echo base_url() . "index.php/schedule/all"; ?>" target="frame">
                <i class="icon-calendar-empty"></i>
                <span class="menu-text">All Schedules </span>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url() . "index.php/management/tracks"; ?>" target="frame">
                <i class="icon-file"></i>
                <span class="menu-text"> Receipt</span>                
            </a>

        </li>

        <li>
            <a href="tables.html">
                <i class="icon-book"></i>
                <span class="menu-text"> Voucher</span>
            </a>
        </li>           

        <li>
            <a href="<?php echo base_url() . "index.php/user/users"; ?>" target="frame">
                <i class="icon-user"></i>

                <span class="menu-text">
                   Manage users
                    <span class="badge badge-transparent tooltip-error" title="2&nbsp;Important&nbsp;Events">

                    </span>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url() . "index.php/log/"; ?>" target="frame">
                <i class="icon-cloud"></i>
                <span class="menu-text"> Synchronisation logs </span>
            </a>
        </li>

        <li>
            <a href="gallery.html">
                <i class="icon-cogs"></i>
                <span class="menu-text"> Registration </span>
            </a>
        </li>

        <li>
            <a href="#" class="dropdown-toggle">
                <i class="icon-warning-sign"></i>
                <span class="menu-text"> Help </span>

            </a>          
        </li>      
    </ul><!--/.nav-list-->

    <div class="sidebar-collapse" id="sidebar-collapse">
        <i class="icon-double-angle-left"></i>
    </div>
</div>

