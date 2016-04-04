
<?php require_once(APPPATH . 'views/css-page.php'); ?>

<div id="accordion2" class="accordion">  

    <div class="align-left">
        <h3>File management</h3>
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
                    <h3 class="box-title">Add File</h3>
                </div><!-- /.box-header -->
                <form  enctype="multipart/form-data"  action='<?= base_url(); ?>index.php/file/add'  method="post">
                    <div class="span12">
                        <div class=" span6">
                            <div class="form-group">
                                <input class="form-control" type="text"  name="named"  placeholder="Name" />

                            </div>
                            <div class="form-group">
                                <input class="form-control" type="text"  name="subject"  placeholder="Subject" />

                            </div>
                            <div class="row-fluid">
                                <label for="form-field-select-4">Choose Client</label>
                                <select  name="client"  data-placeholder="Choose client...">
                                    <option value="" />
                                    <?php
                                    if (is_array($users) && count($users)) {
                                        foreach ($users as $loop) {
                                            ?>  
                                            <option value="<?php echo $loop->id; ?>" /><?php echo $loop->name; ?>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="row-fluid">
                                <label for="form-field-select-4">Choose Type</label>
                                <select  name="types"  data-placeholder="Choose Type...">
                                    <option value="" />                                    
                                    <option value="Litigation" />Litigation
                                    <option value="General" />General

                                </select>
                            </div>
                            <label for="form-field-select-4">Details</label>
                            <div class="form-group">        
                                <textarea  class="form-control" name="details" class="" placeholder="details" ></textarea>
                            </div>
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
                </form> 
            </div><!-- /.box -->


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
                                <th>#</th>
                                <th>No.</th>
                                <th>NAME</th>
                                <th>SUBJECT</th>
                                <th>CLIENT</th>
                                <th>TYPE</th>
                                <th>DETAILS</th>                                           
                                <th>CREATED:</th>
                                <th>VIEW</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>   
                        <tbody>

                            <?php
                            $count = 0;
                            if (is_array($files) && count($files)) {
                                foreach ($files as $loop) {
                                    $count++;
                                    $names = $loop->name;
                                    $no = $loop->no;
                                    $details = $loop->details;
                                    $client = $loop->users;
                                    $id = $loop->id;
                                    $types = $loop->types;
                                    $subject = $loop->subject;
                                    $created = $loop->created;
                                    $status = $loop->status;
                                    ?>  
                                    <tr id="<?php echo $id; ?>" class="edit_tr">
                                        <td class="edit_td">
                                            <?php echo $count; ?>
                                        </td>
                                        <td class="edit_td">
                                            <?php echo $no; ?>
                                        </td>
                                        <td class="edit_td">
                                            <span id="names_<?php echo $id; ?>" class="text"><?php echo $names; ?></span>
                                            <input type="text" value="<?php echo $names; ?>" class="editbox" id="names_input_<?php echo $id; ?>"
                                        </td>
                                        <td class="edit_td">
                                            <span id="subject_<?php echo $id; ?>" class="text"><?php echo $subject; ?></span>
                                            <input type="text" value="<?php echo $subject; ?>" class="editbox" id="subject_input_<?php echo $id; ?>"
                                        </td>

                                        <td class="edit_td">
                                            <?php
                                            if (is_array($users)) {
                                                foreach ($users as $user) {
                                                    if ($user->id == $client) {
                                                        echo $user->name . '  ' . $user->contact . '<br>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td class="edit_td">
                                            <span id="types_<?php echo $id; ?>" class="text"><?php echo $types; ?></span>
                                            <input type="text" value="<?php echo $types; ?>" class="editbox" id="types_input_<?php echo $id; ?>"
                                        </td>
                                        <td class="edit_td">
                                            <span id="details_<?php echo $id; ?>" class="text"><?php echo $details; ?></span>
                                            <input type="text" value="<?php echo $details; ?>" class="editbox" id="details_input_<?php echo $id; ?>"
                                        </td>

                                        <td class="edit_td">
                                            <?php echo $created; ?>
                                        </td>  
                                        <td class="center">
                                              <a class="btn-small icon-user" href="<?php echo base_url() . "index.php/file/view/" . $id; ?>"></a> |<a class=" btn-small icon-calendar" href="<?php echo base_url() . "index.php/file/schedule/" . $id; ?>"></a>
                                        </td>

                                        <td class="center">
                                            <a class="btn-flat btn-small icon-archive" href="<?php echo base_url() . "index.php/reciept/file/" .$id."/".$names."/".$client; ?>">receipt</a> |<a class="btn-danger btn-small icon-remove" href="<?php echo base_url() . "index.php/file/delete/" . $id; ?>"></a>
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
