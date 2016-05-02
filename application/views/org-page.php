
<?php require_once(APPPATH . 'views/css-page.php'); ?>
      <div class="box-body">

                    <table class="jobs table table-striped table-bordered bootstrap-datatable datatable" id="datatable">
                        <thead>
                            <tr> 
                                <th>#</th>
                                <th>NAME</th>
                                <th>STARTS</th>
                                <th>KEY</th>
                                <th>CODE</th>                                           
                                <th>EXPIRE:</th>
                                <th>VIEW</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>   
                        <tbody>

                            <?php
                            if (is_array($orgs) && count($orgs)) {
                                foreach ($orgs as $loop) {
                                    $name = $loop->name;
                                    $code = $loop->code;
                                    $keys = $loop->keys;
                                    $id = $loop->id;
                                    $starts = $loop->starts;
                                    $ends = $loop->ends;
                                    ?>  
                                    <tr id="<?php echo $id; ?>" class="edit_tr">
                                        <td> 
                                           <?php
                                            if ($loop->image != "") {
                                                ?>
                                                <img  height="50px" width="50px"  src="<?= base_url(); ?>uploads/<?php echo $loop->image; ?>" alt="logo" />
                                                <?php
                                            } else {
                                                ?>
                                                <img  height="50px" width="50px"  src="<?= base_url(); ?>images/cp_logo.png" alt="logo" />
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td class="edit_td">
                                            <span id="name_<?php echo $id; ?>" class="text"><?php echo $name; ?></span>
                                            <input type="text" value="<?php echo $name; ?>" class="editbox" id="name_input_<?php echo $id; ?>"
                                        </td>

                                        <td class="edit_td">
                                            <span id="starts_<?php echo $id; ?>" class="text"><?php echo $starts; ?></span>
                                            <input type="text" value="<?php echo $starts; ?>" class="editbox" id="starts_input_<?php echo $id; ?>"
                                        </td>
                                        <td class="edit_td">
                                            <span id="keys_<?php echo $id; ?>" class="text"><?php echo $keys; ?></span>
                                            <input type="text" value="<?php echo $keys; ?>" class="editbox" id="keys_input_<?php echo $id; ?>"
                                        </td>
                                        <td class="edit_td">
                                            <span id="code_<?php echo $id; ?>" class="text"><?php echo $code; ?></span>
                                            <input type="text" value="<?php echo $code; ?>" class="editbox" id="code_input_<?php echo $id; ?>"
                                        </td>

                                        <td class="edit_td">
                                            <span id="ends_<?php echo $id; ?>" class="text"><?php echo $ends; ?></span>
                                            <input type="text" value="<?php echo $ends; ?>" class="editbox" id="ends_input_<?php echo $id; ?>"
                                        </td>  
                                         <td class="center">
                                            <a class="btn-small icon-user" href="<?php echo base_url() . "index.php/user/view/" . $id; ?>"></a>
                                        </td>

                                        <td class="center">
                                            <a class="btn-small icon-remove" href="<?php echo base_url() . "index.php/organisation/delete/" . $id; ?>"></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>            

                </div>
<?php require_once(APPPATH . 'views/js-page.php'); ?>

<script type="text/javascript">
    $(document).ready(function ()
    {
        $(".editbox").hide();

        $(".edit_tr").click(function ()
        {
            var ID = $(this).attr('id');
            $("#name" + ID).hide();
            $("#name_input_" + ID).show();

            $("#starts" + ID).hide();
            $("#starts_input_" + ID).show();

            $("#keys" + ID).hide();
            $("#keys_input_" + ID).show();

            $("#code" + ID).hide();
            $("#code_input_" + ID).show();


        }).change(function ()
        {
            var ID = $(this).attr('id');
            var name = $("#name_input_" + ID).val();
            var code = $("#code_input_" + ID).val();
            var starts = $("#starts_input_" + ID).val();
            var keys = $("#keys_input_" + ID).val();



            var dataString = 'id=' + ID + '&name=' + name + '&code=' + code + '&starts=' + starts + '&keys=' + keys;
            $("#name_" + ID).html('<img src="<?= base_url(); ?>images/loading.gif"  />'); // Loading image
            $("#code_" + ID).html('<img src="<?= base_url(); ?>images/loading.gif"  />'); // Loading image
            $("#keys_" + ID).html('<img src="<?= base_url(); ?>images/loading.gif"  />');
            $("#starts_" + ID).html('<img src="<?= base_url(); ?>images/loading.gif"  />');
            if (name.length > 0)
            {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . "index.php/organisation/updates/"; ?>",
                    data: dataString,
                    cache: false,
                    success: function (html)
                    {
                        $("#name_" + ID).html(name);
                        $("#code_" + ID).html(code);
                        $("#starts_" + ID).html(starts);
                        $("#keys_" + ID).html(keys);


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
