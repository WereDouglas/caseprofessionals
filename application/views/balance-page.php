<?php
foreach ($trans as $t) {

    $transactionID = $t->method;
    $total = $t->total;
}
?>

<?php
foreach ($pay as $p) {
    $sum += floatval(preg_replace('/[^\d.]/', '', $p->amount));
}
// $sum = number_format(floatval(preg_replace('/[^\d.]/', '', $sum)));
$balance = floatval(preg_replace('/[^\d.]/', '', $total)) - $sum;
?>

<style>
    .outerDiv
    {
        max-width: 600px;
        content: ".";
        display: block;
        overflow: hidden;
        margin-left: auto;
        margin-right: auto;
    }
    .innerDiv
    {
        display: inline-block;
        margin: 10px;
    }
    .innerDiv label
    {
        font-style: italic;
        font-size: 1.1em;
    }
    .imageDiv
    {
        display: inline-block;
        max-width: 300px;
        margin: 10px;
    }
    .innerDiv .sui-combobox
    {
        font-family: Arial, sans-serif;
        font-size: 14px;
        margin-bottom: 10px;
    }
</style>
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/shieldui-all.min.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/all.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/reciept.css">


<input type="button" class="printdiv-btn" value="print" />
<div class="align-left">  
    <?php echo $this->session->flashdata('msg'); ?>
</div>

<?php echo $this->session->flashdata('msg'); ?>
</div>
<?php
if (is_array($trans) && count($trans)) {

    foreach ($trans as $loop) {
        ?>  

        <form  enctype="multipart/form-data"  action='<?= base_url(); ?>index.php/reciept/bal'  method="post">
            <div class=" jobs span12" class="printableArea">

                <?php
                $no = $this->session->userdata('code') . "/" . date('y') . "/" . date('m') . (int) date('d') . (int) date('H') . (int) date('i') . (int) date('s');
                ?>
                <header>
                    <?php if ($loop->types == 'credit') { ?>
                        <h1>RECEIPT</h1>
                    <?php } ?>
                    <?php if ($loop->types == 'debit') { ?>
                        <h1>PAYMENT VOUCHER</h1>
                    <?php } ?>
                    <address contenteditable>
                        <p><?php echo $this->session->userdata('name'); ?></p>
                        <p><?php echo $this->session->userdata('address'); ?></p>

                    </address>
                    <span> <img  height="50px" width="100px" class="" src="<?= base_url(); ?>uploads/<?php echo $this->session->userdata('orgimage'); ?>" alt="logo" />
                    </span>
                </header>
                <article>
                    <h1>Recipient</h1>
                    <address contenteditable>              
                        <?php
                        foreach ($users as $user) {
                            if ($user->id == $loop->client) {
                                echo $user->name;
                            }
                        }
                        ?>
                        <input  class="span-data" name="transactionID" id="transactionID" type="hidden" value="<?php echo $loop->id; ?>" >
                    </address>

                    <table class="meta">
                        <tr>
                            <th><span contenteditable>RCT/CHQ #</span></th>
                            <td > <input class="span-data" name="no" id="no" type="text" value="<?php echo $no; ?>" /></td>
                        </tr>
                        <tr>
                            <th><span contenteditable>Date</span></th>
                            <td ><input class="span-data" name="day" id="day" type="text" value="<?php echo date('Y-m-d') ?>" /></td>
                        </tr>

                    </table>
                    <table class="inventory">
                        <thead>
                            <tr>
                                <th><span contenteditable>Item</span></th>
                                <th><span contenteditable>Description</span></th>
                                <th><span contenteditable>Rate</span></th>
                                <th><span contenteditable>Quantity</span></th>
                                <th><span contenteditable>Price</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($items as $item) {
                                ?>
                                <tr>
                                    <td class="item" name="item"><a class="cut"></a><span class="span-datas" id="item" contenteditable><?php echo $item->name; ?></span></td>
                                    <td class="descript" name="descript"><span class="span-datas" id="descript" contenteditable><?php echo $item->description; ?></span></td>
                                    <td class="rate" name="rate"><span  data-prefix></span><span contenteditable class="span-datas" id="rate"><?php echo $item->rate; ?></span></td>
                                    <td class="qty" name="qty"><span  data-prefix></span><span class="span-datas" id="qty" contenteditable ><?php echo $item->qty; ?></span></td>
                                    <td class="price" name="price"><span  data-prefix></span><span class="span-datas" id="price"><?php echo $item->price; ?></span></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>


                    <table class="balance">
                        <tr>
                            <th>PAID BY:</th>
                            <td>  
                                <select id="selectedmethod" name="method"  >
                                    <option value="Cheque">Cheque</option>
                                    <option value="Cash" >Cash</option>
                                    <option value="EFT"  >EFT</option>
                                    <option value="RTGS"  >RTGS</option>
                                </select>
            <!--                    <input class="span-data" data-prefix  name="method" type="hidden" id="method" >-->
                            </td>
                        </tr>
                        <tr>
                            <th><span contenteditable>Total Cost</span></th>
                            <td ><input  name="total" id="total" type="text" value="<?php echo $total ?>" /></td>            
                        </tr>
                        <tr>

                        <tr>
                            <th><span contenteditable>Paid:</span></th>
                            <td ><input  name="amount" id="amount" type="text" value="" /></td>
                        </tr>
                        <tr>
                            <th><span contenteditable>Balance Due</span></th>
                            <td><input  name="balances" id="balances" type="text" value="<?php echo $balance; ?>" /></td>
                        </tr>
                        <tr>
                            <th><span contenteditable></span></th>
                            <td><input  name="balance" id="balance" type="text" value="" /></td>
                        </tr>
                    </table>
                </article>

                <div class="span6">

                    <br>

                    <button type="submit" class="btn-primary btn btn-small">
                        Submit
                        <i class="icon-ok icon-on-right"></i>
                    </button>
                    <button type="reset" class="btn btn-small">
                        Reset
                    </button>
                </div>
            </div>
        </form>
        <?php
    }
}
?>
<script src="<?= base_url(); ?>assets/jquery.js"></script>

<script src="<?= base_url(); ?>assets/jquery-ui.js"></script>
<script type="text/javascript">
    var users = [
<?php
if (is_array($users) && count($users)) {
    foreach ($users as $loops) {
        echo "'" . $loops->name . "',";
    }
}
?>

    ];

    jQuery(function ($) {
        $('#loading').hide();

        $("#jpush").on("click", function (e) {
            var items = {};
            var i = 0;
            $('.span-datas').each(function () {
                console.log(i);

                items[$(this).attr("id") + "_" + i] = $(this).text();
                i++;
            });
            var values = {};
            values["items"] = items;
            console.log($('.span-data text').serialize());
            $('.span-data').each(function () {
                values[$(this).attr("id")] = $(this).text();
                //console.log($(this).attr("id")+" "+$(this).text());
            });
            //
            console.log(JSON.stringify(values));
            var post_this = JSON.stringify(values)
            $.post("<?php echo base_url() ?>index.php/reciept/bal", {
                name: post_this
            }, function (response) {
                alert("" + response);
                var myspan = document.getElementById('no');

                if (myspan.innerText) {
                    myspan.innerText = "";
                } else
                if (myspan.textContent) {
                    myspan.textContent = "";
                }

            });


        });


        $("#user").shieldComboBox({
            dataSource: {
                data: users
            },
            autoComplete: {
                enabled: true
            },
            events: {
                blur: function (e) {
                    // $('#Loading_user').hide();
                    var user = $("#user").val();

                    if (user != null) {           // show loader 

                        $('#loading').show();
                        $.post("<?php echo base_url() ?>index.php/user/exists", {
                            user: user
                        }, function (response) {
                            //#emailInfo is a span which will show you message
                            $('#loading').hide();
                            setTimeout(finishAjax('loading', escape(response)), 400);
                        });
                    }
                    function finishAjax(id, response) {
                        $('#' + id).html(unescape(response));
                        $('#' + id).fadeIn();
                    }
                }
            }

        });

    });
    function NavigateToSite() {

        var selectedVal = document.getElementById("myLink").getAttribute('value');
        //href= "index.php/patient/add_user/'
        $.post("<?php echo base_url() ?>index.php/user/add_user", {
            name: selectedVal

        }, function (response) {
            alert("User Added");
        });

        //window.location = selectedVal;
    }

</script>
<script>


    $("input[id*='amount']").on('keyup', function () {
        var bal = parseFloat($('input[name="balances"]').val());
        var paid = parseFloat($('input[name="amount"]').val());
        var newbal = bal - paid;
        console.log(bal);
        console.log(paid);
        console.log(newbal);
        document.getElementById("balance").value = newbal;

    });

    $(document).on('click', '.printdiv-btn', function (e) {
        e.preventDefault();

        var $this = $(this);
        var originalContent = $('body').html();
        var printArea = $this.parents('.printableArea').html();

        $('body').html(printArea);
        window.print();
        $('body').html(originalContent);
    });

</script>

<script type="text/javascript" src="<?= base_url(); ?>assets/shieldui-all.min.js"></script>



