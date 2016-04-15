<!-- Content Header (Page header) -->
<link href="<?php echo base_url(); ?>dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<section class="content-header">
    <h3>About </h3> 
    <hr>
    <h3><?php echo $this->session->userdata('name'); ?></h3>
     Starts: <?php echo $this->session->userdata('starts'); ?><br>
     Ending: <?php echo $this->session->userdata('ends'); ?><br>
     Code:<?php echo $this->session->userdata('code'); ?><br>
     License:<?php echo $this->session->userdata('license'); ?><br>
     Address: <?php echo $this->session->userdata('address'); ?><br>
</section>
<!-- Main content -->
<section class="content">
    
      <div class="row-fluid">
                    

                 
</div>
                   

</section><!-- /.content -->


<script src="<?php echo base_url(); ?>plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- iCheck -->

</body>

<script src="<?php echo base_url(); ?>js/moment-with-locales.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap-datetimepicker.js"></script>
</head>
<script src='<?= base_url(); ?>js/jquery.dataTables.min.js'></script>

<script src="<?= base_url(); ?>js/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
<!-- Page script -->
<link id="base-style-responsive" href="<?php echo base_url(); ?>css/mine.css" rel="stylesheet">


