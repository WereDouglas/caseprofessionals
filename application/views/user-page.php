
<?php require_once(APPPATH . 'views/css-page.php'); ?>

<div id="accordion2" class="accordion">  

    <div class="align-left">
        <h3>Users</h3>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>
    <?php
    if ($this->session->userdata('level') == 1) {
        ?>
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
    <?php } ?>
    <div class="accordion-group">
        <div class="accordion-body collapse" id="collapseTwo">
            <div class="accordion-inner">
                <div class="box-header with-border">
                    <h3 class="box-title">Add New User</h3>
                </div><!-- /.box-header -->
                <form  enctype="multipart/form-data"  action='<?= base_url(); ?>index.php/user/save'  method="post">
                    <div class="span12">
                        <div class=" span6">
                            <div class="form-group">
                                <input class="form-control" type="text"  name="name"  placeholder="Name" />

                            </div>
                            <div class="form-group">
                                <input class="form-control" type="email"  name="email"  placeholder="email" />

                            </div>
                            <div class="form-group">
                                <label> Title/Role </label>
                                <select  data-placeholder="Choose a title" name="types" id="types">
                                    <option value="Partner" />Partner
                                    <option value="Associate" />Associates
                                    <option value="Contract lawyer" />Contract lawyer
                                    <option value="Of counsel" />Of counsel
                                    <option value="Law clerks" />Law clerks
                                    <option value="Paralegals" />Paralegals
                                    <option value="Administrative " />Administrative 
                                </select>

                            </div>
                            <div class="form-group">
                                <label> Access level</label>
                                <select  data-placeholder="Choose level of authority" name="level" id="level">
                                    <option value="1" />level-1(Full access/approvals)
                                    <option value="2" />level-2(input access)
                                    <option value="3" />level-3(views only)
                                    <option value="4" />level-4(member)
                                    <option value="5" />level-5(member)
                                </select>

                            </div>
                            <div class="form-group">

                                <input type="text" class="form-control" name="contact"  placeholder="contact" />

                            </div>
                            <div class="form-group">

                                Password:<input type="password" id="password"  name="password" /></span>
                                Confirm Password:<input type="password"  id="password2" name="password2" /></span>

                            </div>

                            <div class="form-group">        
                                <textarea  class="form-control" name="address" class="" placeholder="Address information" ></textarea>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="form-group">                    
                                <label>Logo.</label>                                   
                                <input type="file" name="userfile" id="userfile" class="btn-default btn-small"/>
                                <div id="imagePreview" ></div>                      
                            </div>
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
                                <th>NAME</th>
                                <th>CONTACT</th>
                                <th>ADDRESS</th>
                                <th>EMAIL</th>
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
            $("#name" + ID).hide();
            $("#name_input_" + ID).show();

            $("#contact" + ID).hide();
            $("#contact_input_" + ID).show();

            $("#email" + ID).hide();
            $("#email_input_" + ID).show();

            $("#address" + ID).hide();
            $("#address_input_" + ID).show();


        }).change(function ()
        {
            var ID = $(this).attr('id');
            var name = $("#name_input_" + ID).val();
            var details = $("#details_input_" + ID).val();
            var contact = $("#contact_input_" + ID).val();
            var email = $("#email_input_" + ID).val();
            var address = $("#address_input_" + ID).val();



            var dataString = 'id=' + ID + '&name=' + name + '&address=' + address + '&details=' + details + '&contact=' + contact + '&email=' + email;
            $("#name_" + ID).html('<img src="<?= base_url(); ?>images/loading.gif"  />'); // Loading image
            $("#details_" + ID).html('<img src="<?= base_url(); ?>images/loading.gif"  />'); // Loading image
            $("#email_" + ID).html('<img src="<?= base_url(); ?>images/loading.gif"  />');
            $("#contact_" + ID).html('<img src="<?= base_url(); ?>images/loading.gif"  />');
            $("#address_" + ID).html('<img src="<?= base_url(); ?>images/loading.gif"  />');
            if (name.length > 0)
            {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . "index.php/user/update/"; ?>",
                    data: dataString,
                    cache: false,
                    success: function (html)
                    {
                        $("#name_" + ID).html(name);
                        $("#details_" + ID).html(details);
                        $("#contact_" + ID).html(contact);
                        $("#email_" + ID).html(email);
                        $("#address_" + ID).html(address);


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
