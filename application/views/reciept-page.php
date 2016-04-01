
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

<script src="<?php echo base_url(); ?>assets/reciept.js"></script>


<div class="align-left">  
    <?php echo $this->session->flashdata('msg'); ?>
</div>
<!--<form  enctype="multipart/form-data"  action='<?= base_url(); ?>index.php/reciept/save'  method="post">-->
    <div class=" jobs span12">
        <?php
        $no = $this->session->userdata('code') . "/" . date('y') . "/" . date('m') . (int) date('d') . (int) date('H') . (int) date('i') . (int) date('s');
        ?>
        <header>
            <h1>RECEIPT</h1>
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
                <input class="chron" name="user" id="user" type="text" value="" placeholder="select client.....">
                <small> <span id="loading"  name ="loading"><img src="<?= base_url(); ?>images/loading.gif" alt="loading......" /></span></small>

            </address>

            <table class="meta">
                <tr>
                    <th><span contenteditable>RCT/CHQ #</span></th>
                    <td > <span class="span-data" name="no" id="no" type="text" value="" ><?php echo $no; ?></span></td>
                </tr>
                <tr>
                    <th><span contenteditable>Date</span></th>
                    <td ><span class="span-data" name="day" id="day" type="text" value="" /><?php echo date('Y-m-d') ?></span></td>
                </tr>
                <tr>
                    <th><span contenteditable>Amount Due</span></th>
                    <td ><span class="span-data" name="sum" id="sum" contenteditable></span><input hidden id="prefix"  /><span ></span></td>
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
                    <tr>
                        <td class="item" name="item"><a class="cut">-</a><span class="span-datas" id="item" contenteditable></span></td>
                        <td class="descript" name="descript"><span class="span-datas" id="descript" contenteditable></span></td>
                        <td class="rate" name="rate"><span  data-prefix></span><span contenteditable class="span-datas" id="rate">.00</span></td>
                        <td class="qty" name="qty"><span  data-prefix></span><span class="span-datas" id="qty" contenteditable >0</span></td>
                        <td class="price" name="price"><span  data-prefix></span><span class="span-datas" id="price">.00</span></td>
                    </tr>
                </tbody>
            </table>
            <a class="add">+</a>
            <table class="balance">
                <tr>
                    <th>PAID BY:</th>
                    <td>  
                        <select id="method" name="method" class="method"  >
                            <option value="Cheque" >Cheque</option>
                            <option value="Cash">Cash</option>
                            <option value="EFT">EFT</option>
                            <option value="RTGS">RTGS</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><span contenteditable>Total</span></th>
                    <td class="span-data" id="total" name="total"><span data-prefix></span><span contenteditable>0.00</span></td>                </tr>
                <tr>
                    <th><span contenteditable>Amount Paid</span></th>
                    <td class="span-data" id="paid" name="paid"><span data-prefix></span><span contenteditable>0.00</span></td>
                </tr>
                <tr>
                    <th><span contenteditable>Balance Due</span></th>
                    <td class="span-data" id="balance" name="balance"><span data-prefix></span><span>0.00</span></td>
                </tr>
            </table>
        </article>

        <div class="span6">

            <br>
            <button type="submit" class="btn-primary btn btn-small">
                Save
                <i class="icon-ok icon-on-right"></i>
            </button>
            <button id="jpush" class="btn-primary btn btn-small">
                Submit
                <i class="icon-ok icon-on-right"></i>
            </button>
            <button type="reset" class="btn btn-small">
                Reset
            </button>
        </div>
    </div>
<!--</form> -->

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
            $.post("<?php echo base_url() ?>index.php/reciept/save", {
                name: post_this
            }, function (response) {
                alert("items submitted !" +response);
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
<script type="text/javascript" src="<?= base_url(); ?>assets/shieldui-all.min.js"></script>



