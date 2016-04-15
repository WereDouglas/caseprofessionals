<?php require_once(APPPATH . 'views/css-page.php'); ?>

<div class="row-fluid">
       <img  height="50px" width="150px" class="" src="<?= base_url(); ?>uploads/<?php echo $image; ?>" alt="logo" />
       <h3><?php echo $name?></h3>
    
    <div class="span6">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#home">
                        <i class="green icon-home bigger-110"></i>
                        Home
                    </a>
                </li>

                <li>
                    <a data-toggle="tab" href="#profile">
                        Contacts
                       
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#transactions">
                        Financials
                        <span class="badge badge-important"><?php echo count($trans); ?></span>
                    </a>
                </li>


            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane in active">
                   <h3><?php echo $name ?></h3>
                    <h3><small>ADDRESS:</small><?php echo $address ?></h3>
                    <h3><small>CREATED ON:</small><?php echo $created ?></h3>
                    <h3><small>CONTACT:</small><?php echo $contact ?></h3>
                    <h3><small>E-MAIL:</small><?php echo $email ?></h3>
                </div>

                <div id="profile" class="tab-pane">
                    <form id="contact-form"  enctype="multipart/form-data"  action='<?= base_url(); ?>index.php/contact/add'  method="post">
                        <div class="span12">
                                <div class="form-group">
                                    <input class="form-control" type="hidden"  name="userid"  value="<?php echo $userid; ?>" />
                                  <label>CONTACT:</label>  <input  type="text"  name="val"  placeholder="Contact" />

                                    <label>TYPE:</label>
                                    <select id="type" name="type" >                                                         

                                        <option value="Phone" >Phone</option>
                                        <option value="Email">E-mail</option>
                                    </select>
                                   
                                    <label>ACTIVE:</label>  
                                     <select id="type" name="trig" >                                                         

                                        <option value="TRUE" >TRUE</option>
                                        <option value="FALSE">FALSE</option>
                                    </select>
                                    
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


                <table class=" table table-striped table-bordered bootstrap-datatable datatable" id="datatable">
                    <thead>
                        <tr>                          
                            <th>CONTACT</th>
                            <th>TYPE</th>
                            <th>ACTIVE</th>                                                                  
                            <th>CREATED:</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>   
                    <tbody>

                        <?php
                        if (is_array($contacts) && count($contacts)) {
                            foreach ($contacts as $loop) {
                                $val = $loop->val;
                                $type = $loop->type;     
                                 $trig = $loop->trig;     
                                $id = $loop->id;                               
                                $created = $loop->created;
                                ?>  
                                <tr id="<?php echo $id; ?>" class="edit_tr">
                                    
                                    <td class="edit_td">
                                        <span id="val_<?php echo $id; ?>" class="text"><?php echo $val; ?></span>
                                        <input type="text" value="<?php echo $val; ?>" class="editbox" id="val_input_<?php echo $id; ?>"
                                    </td>

                                    <td class="edit_td">
                                        <span id="type_<?php echo $id; ?>" class="text"><?php echo $type; ?></span>
                                        <input type="text" value="<?php echo $type; ?>" class="editbox" id="type_input_<?php echo $id; ?>"
                                    </td>  
                                     <td class="edit_td">
                                        <span id="trig_<?php echo $id; ?>" class="text"><?php echo $trig; ?></span>
                                        <input type="text" value="<?php echo $trig; ?>" class="editbox" id="trig_input_<?php echo $id; ?>"
                                    </td>  
                                    <td class="edit_td">
                                       <?php echo $created; ?>
                                    </td>
                                    <td class="center">
                                        <a class="btn-danger btn-small icon-remove" href="<?php echo base_url() . "index.php/contact/delete/" . $id; ?>"></a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>      
            </div>

            <div id="transactions" class="tab-pane">
                 <table class="jobs table table-striped table-bordered bootstrap-datatable datatable" id="datatable">
                        <thead>
                            <tr> 
                                <th>DATE</th>
                                <th>TOTAL</th>
                                <th>BAL</th>
                                <th>CLIENT</th>
                                <th>TYPE</th>
                                <th>CREATED BY</th>
                                <th>APPROVED</th>
                                <th>ITEMS</th>
                                <th>PAYMENTS</th>
                                <th>ACTION</th>
                            </tr>
                        </thead>   
                        <tbody>

                            <?php
                            if (is_array($trans) && count($trans)) {
                                foreach ($trans as $loop) {
                                    ?>  
                                    <tr >
                                        <td> 
                                            <?php echo $loop->created; ?>
                                        </td>
                                        <td> 
                                            <?php echo $loop->total; ?>
                                        </td>
                                        <td> 

                                            <?php
                                            $sum = 0;
                                            foreach ($pay as $p) {
                                                if ($p->transactionID == $loop->id) {
                                                    $sum += floatval(preg_replace('/[^\d.]/', '', $p->amount));
                                                }
                                            }
                                            echo number_format(floatval(preg_replace('/[^\d.]/', '', $loop->total)) - $sum);
                                            ?>
                                        </td>
                                        <td> 
                                            <?php
                                            foreach ($users as $user) {
                                                if ($user->id == $loop->client) {
                                                    echo $user->name;
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td> 
                                            <?php echo $loop->types; ?>
                                        </td>
                                        <td> 
                                            <?php echo $loop->users; ?>
                                        </td>
                                        <td> 
                                            <?php echo $loop->approved; ?>
                                        </td>
                                        <td> 
                                            <?php
                                            $str = "";
                                            $ct = 1;

                                            foreach ($items as $item) {
                                                if ($item->transactionID == $loop->id) {
                                                    $str .= $ct++ . ' ' . $item->name . ' ' . $item->price . '<br>';
                                                }
                                            }
                                            echo $str;
                                            ?>
                                        </td>
                                        <td> 
                                            <?php
                                            $str = "";
                                            $ct = 1;
                                            foreach ($pay as $p) {
                                                if ($p->transactionID == $loop->id) {
                                                    $str .= $ct++ . ' <a href="' . base_url() . "index.php/reciept/view/" . $p->id . "/" . $p->transactionID . '">' . $p->no . '</a> ' . '<br>';
                                                }
                                            }
                                            echo $str;
                                            ?>

                                        </td>


                                        <td class="center">
                                            <a class="btn-flat btn-small icon-archive" href="<?php echo base_url() . "index.php/reciept/balance/" . $loop->id; ?>">receipt</a> | <a class="btn-flat btn-small icon-barcode" href="<?php echo base_url() . "index.php/reciept/invoice/" . $loop->id; ?>">view</a> | <a class="btn-danger btn-small icon-remove" href="<?php echo base_url() . "index.php/reciept/delete/" . $loop->id; ?>"></a>
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
</div><!--/span-->
<div class="vspace-6"></div>


</div><!--/row-->

<div class="accordion-group">


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

            $("#details" + ID).hide();
            $("#details_input_" + ID).show();


        }).change(function ()
        {
            var ID = $(this).attr('id');
            var name = $("#name_input_" + ID).val();
            var details = $("#details_input_" + ID).val();
            var contact = $("#contact_input_" + ID).val();
            var email = $("#email_input_" + ID).val();



            var dataString = 'id=' + ID + '&name=' + name + '&details=' + details + '&contact=' + contact + '&email=' + email;
            $("#name_" + ID).html('<img src="<?= base_url(); ?>images/loading.gif"  />'); // Loading image
            $("#details_" + ID).html('<img src="<?= base_url(); ?>images/loading.gif"  />'); // Loading image
            $("#email_" + ID).html('<img src="<?= base_url(); ?>images/loading.gif"  />');
            $("#contact_" + ID).html('<img src="<?= base_url(); ?>images/loading.gif"  />');
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
        
        
        
    $('#loading').hide();
    $("#contact-form").submit(function (e) {
        e.preventDefault();
        // console.log($(this).serializeArray());
        $('#loading').show();
        var posts = $(this).serializeArray();


        if (posts.length > 0) {

            $.post("<?php echo base_url() ?>index.php/contact/add", {posts: posts}
            , function (response) {
                //#emailInfo is a span which will show you message
                console.log(response);
                $('#loading').hide();
                setTimeout(finishAjax('loading', escape(response)), 200);

            }); //end change
        } else {
            alert("Please insert missing information");
            $('#loading').hide();
        }

        function finishAjax(id, response) {
            $('#' + id).html(unescape(response));
            $('#' + id).fadeIn();
        }
        
         });

    });
</script>
