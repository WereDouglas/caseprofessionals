
<?php require_once(APPPATH . 'views/css-page.php');
 if ($this->session->userdata('orgid') == "") {

?>

<?php require_once(APPPATH . 'views/admin-header.php'); ?>

 <?php }?>
 
<div id="accordion2" class="accordion">  

    <div class="align-left">
        <h3>File Procedures</h3>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
    <div class="align-right">

        <a href="#collapseTwo" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle collapsed">

            <button class="  btn-sm">
                <i class="icon-save bigger-125"></i>
                Add
            </button></a>
        <a href="#collapseThree" data-parent="#accordion2" data-toggle="collapse" class="accordion-toggle collapsed">

            <button class=" btn-sm">
                <i class="icon-list bigger-110"></i>
                List
            </button>
        </a>
    </div>

    <div class="accordion-group">
        <div class="accordion-body collapse" id="collapseTwo">
            <div class="accordion-inner">
                <div class="box-header with-border">
                    <h3 class="box-title">Add</h3>
                </div><!-- /.box-header -->
                <form  enctype="multipart/form-data"  action='<?= base_url(); ?>index.php/procedure/add'  method="post">
                    <div class="span12">
                        <div class=" span6">
                            <div class="form-group">
                                <input class="form-control" type="text"  name="name"  placeholder="Name" />

                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text"  name="period"  placeholder="Period in days" />
                            </div>

                            <div class="span6">

                                <br>
                                <button type="submit" class="btn-primary btn btn-small">
                                    Save
                                    <i class="icon-ok icon-on-right"></i>
                                </button>
                                <button type="reset" class="btn btn-small">

                                    Reset
                                </button>
                            </div>
                        </div>

                    </div><!-- /.box -->

                </form>
            </div>
        </div>
    </div>

    <div class="accordion-group">

        <div class="accordion-body collapsed" id="collapseThree">
            <div class="accordion-inner">
                <div class="row-fluid sortable">		

                    <div class="box-body">

                        <table class="jobs table table-striped table-bordered bootstrap-datatable datatable" id="datatable">
                            <thead>
                                <tr> 

                                    <th>NAME</th>
                                    <th>PERIOD(DAYS)</th> 
                                    <th>ORGANISATION</th>     
                                    <th>ACTION</th>
                                </tr>
                            </thead>   
                            <tbody>

                                <?php
                                $count = 0;
                                if (is_array($procs) && count($procs)) {
                                    foreach ($procs as $loop) {
                                        $count++;
                                        $names = $loop->name;
                                        $period = $loop->period;
                                        $id = $loop->id;
                                        $org = $loop->org;
                                        ?>  
                                        <tr id="<?php echo $id; ?>" class="edit_tr">

                                            <td class="edit_td">
                                                <span id="names_<?php echo $id; ?>" class="text"><?php echo $names; ?></span>
                                                <input type="text" value="<?php echo $names; ?>" class="editbox" id="names_input_<?php echo $id; ?>"
                                            </td>
                                            <td class="edit_td">
                                                <span id="period_<?php echo $id; ?>" class="text"><?php echo $period; ?></span>
                                                <input type="text" value="<?php echo $period; ?>" class="editbox" id="period_input_<?php echo $id; ?>"
                                            </td>

                                            <td class="edit_td">
                                                <?php
                                                if (is_array($orgs)) {
                                                    foreach ($orgs as $orged) {
                                                        if ($orged->id == $org) {
                                                            echo $orged->name;
                                                        }
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td class="center">
                                                <a class="btn-danger btn-small icon-remove" href="<?php echo base_url() . "index.php/procedure/delete/" . $id; ?>"></a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>            

                    </div>

                </div>
            </div>

        </div>
    </div>

    <?php require_once(APPPATH . 'views/js-page.php'); ?>

    <script type="text/javascript">
        $(document).ready(function ()
        {
            $(".editbox").hide();

            $(".edit_tr").click(function ()
            {
                var ID = $(this).attr('id');
                $("#names" + ID).hide();
                $("#names_input_" + ID).show();
                $("#subject" + ID).hide();
                $("#subject_input_" + ID).show();

                $("#types" + ID).hide();
                $("#types_input_" + ID).show();

                $("#details" + ID).hide();
                $("#details_input_" + ID).show();


            }).change(function ()
            {
                var ID = $(this).attr('id');
                var name = $("#names_input_" + ID).val();
                var details = $("#details_input_" + ID).val();
                var types = $("#types_input_" + ID).val();
                var subject = $("#subject_input_" + ID).val();

                var dataString = 'id=' + ID + '&names=' + name + '&details=' + details + '&types=' + types + '&subject=' + subject;
                $("#names_" + ID).html('<img src="<?= base_url(); ?>images/loading.gif"  />'); // Loading image
                $("#details_" + ID).html('<img src="<?= base_url(); ?>images/loading.gif"  />'); // Loading image
                $("#types_" + ID).html('<img src="<?= base_url(); ?>images/loading.gif"  />');
                $("#subject_" + ID).html('<img src="<?= base_url(); ?>images/loading.gif"  />');
                if (name.length > 0)
                {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url() . "index.php/file/update/"; ?>",
                        data: dataString,
                        cache: false,
                        success: function (html)
                        {
                            $("#names_" + ID).html(name);
                            $("#details_" + ID).html(details);
                            $("#types_" + ID).html(types);
                            $("#subject_" + ID).html(subject);



                        }
                    });
                } else
                {
                    alert('Enter something.');
                }

            });

            // Edit input box click action
            $(".editbox").mouseup(function ()
            {
                return false
            });

            // Outside click action
            $(document).mouseup(function ()
            {
                $(".editbox").hide();
                $(".text").show();
            });

        });
    </script>
    <script type="text/javascript" src="<?= base_url(); ?>js/jquery.js"></script>
    <script type="text/javascript" src="<?= base_url(); ?>js/jquery.easyui.min.js"></script>
