
<?php require_once(APPPATH . 'views/css-page.php'); ?>
<?php require_once(APPPATH . 'views/admin-header.php'); ?>
<div class="box-body">

    <table class="jobs table table-striped table-bordered bootstrap-datatable datatable" id="datatable">
        <thead>
            <tr> 
                <th>#</th>
                <th>NAME</th>
                <th>CONTACT</th>
                <th>ADDRESS</th>
                <th>EMAIL</th>
                 <th>RESET PASSWORD</th>
                <th>CREATED:</th>
                <th>ACTION</th>
            </tr>
        </thead>   
        <tbody>

            <?php
            if (is_array($users) && count($users)) {
                foreach ($users as $loop) {
                    $name = $loop->name;
                    $address = $loop->address;
                    $email = $loop->email;
                    $id = $loop->id;
                    $contact = $loop->contact;
                    $created = $loop->created;
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
                                <img  height="50px" width="50px"  src="<?= base_url(); ?>images/user_place.png" alt="logo" />
                                <?php
                            }
                            ?>
                        </td>
                        <td class="edit_td">
                            <span id="name_<?php echo $id; ?>" class="text"><?php echo $name; ?></span>
                            <input type="text" value="<?php echo $name; ?>" class="editbox" id="name_input_<?php echo $id; ?>"
                        </td>

                        <td class="edit_td">
                            <span id="contact_<?php echo $id; ?>" class="text"><?php echo $contact; ?></span>
                            <input type="text" value="<?php echo $contact; ?>" class="editbox" id="contact_input_<?php echo $id; ?>"

                        </td>
                        <td class="edit_td">
                            <span id="address_<?php echo $id; ?>" class="text"><?php echo $address; ?></span>
                            <input type="text" value="<?php echo $address; ?>" class="editbox" id="address_input_<?php echo $id; ?>"
                        </td>
                        <td>
                            <a href="#"  value="<?php echo $loop->id; ?>"  id="myLink" onclick="NavigateToSite(this)" class="tooltip-error text-danger" data-rel="tooltip" title="reset">
                                <span class="red">
                                    <i class="icon-lock bigger-120 text-danger"></i>
                                    Reset
                                </span>
                            </a>
                        </td>
                        <td >
                            <?php echo $email; ?>
                        </td>                                        

                        <td class="edit_td">
                            <span id="created_<?php echo $id; ?>" class="text"><?php echo $created; ?></span>
                            <input type="text" value="<?php echo $created; ?>" class="editbox" id="created_input_<?php echo $id; ?>"
                        </td>   

                        <td class="center">
                            <a class="btn-danger btn-small icon-remove" href="<?php echo base_url() . "index.php/user/delete/" . $id; ?>"></a>
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
        function NavigateToSite(ele) {
        var selectedVal  = $(ele).attr("value");
        //var selectedVal = document.getElementById("myLink").getAttribute('value');
        //href= "index.php/patient/add_user/'
        $.post("<?php echo base_url() ?>index.php/admin/reset", {
            id: selectedVal
        }, function (response) {
            alert(response);
        });

    }
        

    });
</script>
