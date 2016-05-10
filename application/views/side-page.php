
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

        <?php
        if ($this->session->userdata('level') == 1 || $this->session->userdata('level') == 2) {
            ?>
            <li>
                <a href="<?php echo base_url() . "index.php/reciept/"; ?>" target="frame">
                    <i class="icon-file"></i>
                    <span class="menu-text"> Receipt</span>                
                </a>

            </li> 
            <li>
                <a href="<?php echo base_url() . "index.php/voucher"; ?>" target="frame">
                    <i class="icon-foursquare"></i>
                    <span class="menu-text"> Voucher</span>
                </a>
            </li> 

        <?php } ?>

        <li>
            <a href="<?php echo base_url() . "index.php/report/"; ?>" target="frame">
                <i class="icon-bar-chart"></i>
                <span class="menu-text"> Graphical </span>
            </a>
        </li>

        <li>
            <a href="<?php echo base_url() . "index.php/user/users"; ?>" target="frame">
                <i class="icon-user"></i>

                <span class="menu-text">
                    Manage users
                    <span class="badge badge-transparent tooltip-error" title="2&nbsp;Important&nbsp;Events">

                    </span> </span>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url() . "index.php/procedure/"; ?>" target="frame">
                <i class="icon-beaker"></i>

                <span class="menu-text">
                    Procedures
                    <span class="badge badge-transparent tooltip-error" title="2&nbsp;Important&nbsp;Events">

                    </span> </span>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url() . "index.php/client/"; ?>" target="frame">
                <i class="icon-globe"></i>
                <span class="menu-text"> Data Clients </span>
            </a>
        </li>
        <li>
            <a href="<?php echo base_url() . "index.php/log/"; ?>" target="frame">
                <i class="icon-cloud"></i>
                <span class="menu-text"> Synchronisation Logs </span>
            </a>
        </li>

        <li>
            <a href="<?php echo base_url() . "index.php/welcome/info"; ?>" target="frame">
                <i class="icon-cogs"></i>
                <span class="menu-text"> Registration information</span>
            </a>
        </li>

        <li>
            <a href="<?php echo base_url() . "index.php/welcome/help"; ?>" target="frame">
                <i class="icon-warning-sign"></i>
                <span class="menu-text"> Help </span>

            </a>          
        </li> 
        <li> <a href="<?php echo base_url() . "files/Cp.msi"; ?>"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Desktop(WINDOWS INSTALLER)</b> </a> </li>
        <li> <a href="https://www.microsoft.com/en-us/download/details.aspx?id=40779"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>NET 4.5.1(Online)</b> </a> </li>

        <li> <a href="<?php echo base_url() . "files/NET4.5.1.zip"; ?>"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>NET 4.5.1(zip)</b> </a> </li>


        <li> <a href="<?php echo base_url() . "files/Cp.apk"; ?>"> <span>&nbsp;</span> <i class="fa fa-circle"></i> <b>Mobile</b> </a> </li>

    </ul><!--/.nav-list-->

    <div class="sidebar-collapse" id="sidebar-collapse">
        <i class="icon-double-angle-left"></i>
    </div>
</div>

