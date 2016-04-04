
<?php
foreach ($pay as $p) {

    $method = $p->method;
    $no = $p->no;
    $balance = number_format($p->balance);
    $amount = $p->amount;
}
?>

<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/shieldui-all.min.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/all.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/reciept.css">

<input type="button" class="printdiv-btn" value="print" />
<div class="align-left">  
    <?php echo $this->session->flashdata('msg'); ?>
</div>
<?php
if (is_array($trans) && count($trans)) {
    foreach ($trans as $loop) {
        ?>  
                                                                                <!--<form  enctype="multipart/form-data"  action='<?= base_url(); ?>index.php/reciept/save'  method="post">-->
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
                </address>

                <table class="meta">
                    <tr>
                        <th><span contenteditable>RCT/CHQ #</span></th>
                        <td > <span class="span-data" name="no" id="no" type="text" value="" ><?php echo $no; ?></span></td>
                    </tr>
                    <tr>
                        <th><span contenteditable>Date</span></th>
                        <td ><span class="span-data" name="day" id="day" type="text" value="" /> <?php echo $loop->created; ?></span></td>
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
                            <?php echo $method; ?>
                        </td>
                    </tr>
                    <tr>
                        <th><span contenteditable>Total</span></th>
                        <td class="span-data" id="total" name="total"><span data-prefix></span><span contenteditable><?php echo $loop->total; ?></span></td>  </tr>
                    <tr>
                        <th><span contenteditable>Amount Paid</span></th>
                        <td class="span-data" id="paid" name="paid"><span data-prefix></span><span contenteditable> <?php echo $amount; ?></span></td>
                    </tr>
                    <tr>
                        <th><span contenteditable>Balance Due</span></th>
                        <td class="span-data" id="balance" name="balance"><span data-prefix></span><span> <?php echo $balance; ?></span></td>
                    </tr>
                </table>
            </article>


        </div>
        <?php
    }
}
?>
<script src="<?= base_url(); ?>assets/jquery.js"></script>

<script src="<?= base_url(); ?>assets/jquery-ui.js"></script>




