<div class="span10">


     <a href="<?php echo base_url() . "index.php/schedule"; ?>" target="frame">
        <div class="infobox infobox-orange infobox-small infobox-dark">
            <div class="infobox-icon">
                <i class="icon-calendar"></i>
            </div>

            <div class="infobox-data">
                <div class="infobox-content">Schedules</div>
                 <div class="infobox-content"><?php echo count($schedules)?></div>
            </div>
        </div>
    </a>
<a href="<?php echo base_url() . "index.php/file"; ?>" target="frame">
    <div class="infobox infobox-grey infobox-small infobox-dark">
        <div class="infobox-icon">
            <i class="icon-folder-close"></i>
        </div>

        <div class="infobox-data">
            <div class="infobox-content">Files</div>
            <div class="infobox-content"><?php echo count($files)?></div>
        </div>
    </div>
</a>
 <a href="<?php echo base_url() . "index.php/reciept/payment"; ?>" target="frame">
    <div class="infobox infobox-orange infobox-small infobox-dark">
        <div class="infobox-icon">
            <i class="icon-list"></i>
        </div>

        <div class="infobox-data">
            <div class="infobox-content">Finance</div>
            <div class="infobox-content"></div>
        </div>
    </div>
</a>
    <div class="infobox infobox-blue3 infobox-small infobox-dark">
        <div class="infobox-icon">
            <i class="icon-phone"></i>
        </div>

        <div class="infobox-data">
            <div class="infobox-content">Contact</div>
            <div class="infobox-content"></div>
        </div>
    </div>
 <a href="<?php echo base_url() . "index.php/document/docs"; ?>" target="frame">
    <div class="infobox infobox-green infobox-small infobox-dark">
        <div class="infobox-icon">
            <i class="icon-file"></i>
        </div>

        <div class="infobox-data ">
            <div class="infobox-content">Documents</div>
            <div class="infobox-content"></div>
        </div>
    </div>
 </a>
    <a href="<?php echo base_url() . "index.php/TimeBilling/index"; ?>" target="frame">
        <div class="infobox infobox-blue2 infobox-small infobox-dark">
            <div class="infobox-icon">
                <i class="icon-time"></i>
            </div>

            <div class="infobox-data">
                <div class="infobox-content">Time </div>
                <div class="infobox-content"></div>
            </div>
        </div>
    </a>
     <a href="<?php echo base_url() . "index.php/user/client"; ?>" target="frame">
        <div class="infobox infobox-brown infobox-small infobox-dark">
            <div class="infobox-icon">
                <i class="icon-group"></i>
            </div>
            <div class="infobox-data">
                <div class="infobox-content">Clients</div>
                <div class="infobox-content"><?php echo count($clients)?></div>
            </div>
        </div>
    </a>

</div><!--/.page-header-->