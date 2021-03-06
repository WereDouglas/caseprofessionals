
<?php require_once(APPPATH . 'views/css-page.php'); ?>

<div id="accordion2" class="accordion">  

    <div class="align-left">
        <h3>INVOICES</h3>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>  

    <div class="row-fluid sortable">		

        <div class="box-body">

            <table class="jobs table table-striped table-bordered bootstrap-datatable datatable" id="datatable">
                <thead>
                    <tr> 
                        <th>VERIFY?</th>
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
                            <tr>
                                
                                                    <td >

                                                        <?php
                                                        if ($loop->approved == "false") {
                                                            ?>
                                                            <div class="btn-group" data-toggle="buttons" data-toggle-default-class="btn-default">
                                                                <label class="btn btn-small btn-default" data-toggle-class="btn-success" value="<?= $loop->id; ?>">
                                                                    <input type="radio" name="status" id="<?= $loop->approved; ?>" value="<?= $loop->id; ?>" />
                                                                    true
                                                                </label>
                                                                <label class="btn btn-small btn-danger active" data-toggle-class="btn-danger" value="<?= $loop->id; ?>">
                                                                    <input type="radio" name="status" id="<?= $loop->approved; ?>" value="<?= $loop->id; ?>" checked />
                                                                    false
                                                                </label>
                                                            </div> 
                                                        <?php } ?>

                                                        <?php
                                                        if ($loop->approved == "true") {
                                                            ?>
                                                            <div class="btn-group" data-toggle="buttons" data-toggle-default-class="btn-default">
                                                                <label class="btn btn-small btn-success active" data-toggle-class="btn-success">
                                                                    <input type="radio" name="status" id="<?= $loop->approved; ?>" value="<?= $loop->id; ?>" checked />
                                                                    true
                                                                </label>
                                                                <label class="btn btn-small btn-default " data-toggle-class="btn-danger">
                                                                    <input type="radio" name="status" id="<?= $loop->approved; ?>" value="<?= $loop->id; ?>"  />
                                                                    false
                                                                </label>
                                                            </div> 
                                                        <?php } ?>

                                                    </td>

                                           
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


    <?php require_once(APPPATH . 'views/js-page.php'); ?>



<script>


    $('.btn-group[data-toggle=buttons]').each(function (i, e) {
        var default_class = $(e).data('toggle-default-class') || 'btn-default';

        $(e).find('label')
                .click(function (event) {
                    $(e).find('label')
                            .each(function (i, e) {
                                if (!(e == event.target)) {
                                    $(e).removeClass($(e).data('toggle-class'))
                                            .addClass(default_class);

                                    $(e).find('input').removeAttr('checked');
                                    console.log($(e).find("input").attr("id"));


                                    $.post("<?php echo base_url() ?>index.php/reciept/activate", {
                                        id: $(e).find("input").val(),
                                        actives: $(e).find("input").attr("id")

                                    }, function (response) {
                                        location.reload();
                                    });
                                    // alert("active");

                                } else {
                                    $(e).removeClass(default_class)
                                            .addClass($(e).data('toggle-class'));

                                    $(e).find('input')
                                            .attr('checked', 1);

                                }
                            });
                });
    });

</script>