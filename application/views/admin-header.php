 <a href="<?php echo base_url() . "index.php/admin"; ?>" >
        <div class="infobox infobox-orange infobox-small infobox-dark">
            <div class="infobox-icon">
                <i class="icon-calendar"></i>
            </div>

            <div class="infobox-data">
                <div class="infobox-content">Organisations</div>
                 <div class="infobox-content"><?php echo count($orgs)?></div>
            </div>
        </div>
    </a>
<a href="<?php echo base_url() . "index.php/admin/users"; ?>" >
    <div class="infobox infobox-grey infobox-small infobox-dark">
        <div class="infobox-icon">
            <i class="icon-folder-close"></i>
        </div>

        <div class="infobox-data">
            <div class="infobox-content">Users</div>
            <div class="infobox-content"><?php echo count($users)?></div>
        </div>
    </div>
</a>
<a href="<?php echo base_url() . "index.php/admin/procedures"; ?>" >
    <div class="infobox infobox-grey infobox-small infobox-dark">
        <div class="infobox-icon">
            <i class="icon-beaker"></i>
        </div>

        <div class="infobox-data">
            <div class="infobox-content">Procedures</div>
            <div class="infobox-content"><?php echo count($procs)?></div>
        </div>
    </div>
</a>