
<link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" />
<link href="<?= base_url(); ?>assets/css/bootstrap-responsive.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/font-awesome.min.css" />

<!--[if IE 7]>
  <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css" />
<![endif]-->

<!--page specific plugin styles-->

<!--fonts-->

<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />

<!--ace styles-->

<link rel="stylesheet" href="<?= base_url(); ?>assets/css/ace.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/ace-responsive.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/ace-skins.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/easyui.css?date=<?php echo date('Y-m-d') ?>">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/icon.css?date=<?php echo date('Y-m-d') ?>">



<div class="row-fluid">
    <div class="span12">
        <div class="widget-box transparent" id="recent-box">
            <div class="widget-header">
                <h4 class="lighter smaller">
                    <i class="icon-rss orange"></i>
                    MAIL
                </h4>

                <div class="widget-toolbar no-border">
                    <ul class="nav nav-tabs" id="recent-tab">
                        <li class="active">
                            <a data-toggle="tab" href="#task-tab">E-MAILS</a>
                        </li>

                        <li>
                            <a data-toggle="tab" href="#member-tab">COLLEAGUES</a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#comment-tab">SEND MAIL</a>
                        </li>



                    </ul>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main padding-4">
                    <div class="tab-content padding-8 overflow-visible">
                        <div id="task-tab" class="tab-pane active">
                            <h4 class="smaller lighter green">
                                <i class="icon-list"></i>
                                Sortable Lists
                            </h4>

                            <ul id="tasks" class="item-list">

                                <?php
                                foreach ($mails as $loop) {
                                    ?>

                                    <li class="item-red clearfix">
                                        <label class="inline">
                                            <input type="checkbox" />
                                            TO:
                                            <a href="#" class="green">
                                                <?= $loop->reciever ?>
                                            </a>
                                            <a href="#" class="blue">MESSAGE:</a>
                                            <span class="lbl"><?= $loop->message ?></span>
                                        </label>

                                        <div class="pull-right action-buttons">
                                            <strong> SENT:</strong> 
                                            <a href="#" class="blue">
                                                <?= $loop->sent ?>
                                            </a>



                                            <span class="vbar"></span>

                                            <a href="<?php echo base_url() . "index.php/message/delete/" . $loop->id; ?>" class="red">
                                                <i class="icon-trash bigger-130"></i>
                                            </a>

                                            <span class="vbar"></span>

                                        </div>
                                    </li>


                                    <?php
                                }
                                ?>

                            </ul>
                        </div>

                        <div id="member-tab" class="tab-pane">
                            <div class="clearfix">


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


                                        <div class="itemdiv memberdiv">
                                            <div class="user">
                                                <img alt="<?php echo $loop->name; ?>" src="<?= base_url(); ?>uploads/<?php echo $loop->image; ?>" />
                                            </div>

                                            <div class="body">
                                                <div class="name">
                                                    <a href="#"><?php echo $loop->name; ?></a>
                                                </div>

                                                <div class="time">
                                                    <i class="icon-phone"></i>
                                                    <span class="green"><?php echo $loop->contact; ?></span>
                                                </div>
                                                 <div class="time">
                                                    <i class="icon-user"></i>
                                                    <span class="pink"><?php echo $loop->types; ?></span>
                                                </div>
                                                 <div class="time">
                                                    <i class="icon-folder"></i>
                                                    <span class="pink"><?php echo $loop->email; ?></span>
                                                </div>

                                            </div>
                                        </div>                               


                                        <?php
                                    }
                                }
                                ?>

                            </div>



                            <div class="hr hr-double hr8"></div>
                        </div><!--member-tab-->

                        <div id="comment-tab" class="tab-pane">
                            <div class="comments container">
                                <form  role="form" action='<?= base_url(); ?>index.php/message/save' method="post" enctype='multipart/form-data'>
                                    <div class="row">
                                        <div class="col-sm-6 control-label">
                                            <h3>SEND MESSAGE</h3>


                                            <div class="form-control-group">

                                                <label class="label-top">TO:</label>
                                                <input class="easyui-combobox" name="ccs[]" style="width:100%;height:26px" data-options="
                                                       url:'<?php echo base_url() ?>index.php/message/users',
                                                       method:'get',
                                                       valueField:'email',
                                                       textField:'email',

                                                       multiple:true,
                                                       panelHeight:'auto'
                                                       ">

                                            </div>

                                            <div class="form-control-group">
                                                <label class="control-label" for="name">Message Subject</label>
                                                <div class="controls">
                                                    <input type="text" class="form-control" name="subject" id="subject">
                                                </div>
                                            </div>
                                            <div class="row"><hr></div>
                                            <div class="form-control-group">
                                                <label class="control-label" for="description">Message</label>
                                                <div class="controls">
                                                    <textarea class="form-control" name="message"  id="message" rows="3"></textarea>
                                                </div>
                                                <label class="control-label" for="description">Date Schedule</label>
                                                <div class="control-group">
                                                    <div class="controls">
                                                        <input class="easyui-datebox form" name="starts" id="starts" width="100px" data-options="formatter:myformatter,parser:myparser" ></input>
                                                    </div>
                                                </div>
                                                <div class="alert-error">  <?php echo $info; ?>  </div>
                                                <br>
                                                <div class="">
                                                    <button type="submit" id="sender" class="btn btn-success">Send</button>
                                                    <a href="<?= base_url(); ?>index.php/Message" class="btn btn-primary">Cancel</a>
                                                </div>



                                            </div>

                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="hr hr8"></div>


                            <div class="hr hr-double hr8"></div>
                        </div>
                    </div>
                </div><!--/widget-main-->
            </div><!--/widget-body-->
        </div><!--/widget-box-->
    </div><!--/span-->


</div><!--/row-->
<?php require_once(APPPATH . 'views/js-page.php'); ?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>js/jquery.easyui.min.js"></script>
<script type="text/javascript">


    function myformatter(date) {
        var y = date.getFullYear();
        var m = date.getMonth() + 1;
        var d = date.getDate();
        return y + '-' + (m < 10 ? ('0' + m) : m) + '-' + (d < 10 ? ('0' + d) : d);
    }
    function myparser(s) {
        if (!s)
            return new Date();
        var ss = (s.split('-'));
        var y = parseInt(ss[0], 10);
        var m = parseInt(ss[1], 10);
        var d = parseInt(ss[2], 10);
        if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
            return new Date(y, m - 1, d);
        } else {
            return new Date();
        }
    }
</script>