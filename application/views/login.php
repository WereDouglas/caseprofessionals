<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Case Professional</title>

        <meta name="description" content="User login page" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!--basic styles-->

        <link href="<?= base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?= base_url(); ?>assets/css/bootstrap-responsive.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?= base_url(); ?>assets/css/font-awesome.min.css" />
        <link rel="stylesheet" href="<?= base_url(); ?>assets/mine.css" />

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

        <!--[if lte IE 8]>
          <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
        <![endif]-->

        <!--inline styles related to this page-->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
    <body class="login-layout">
        <div class="main-container container-fluid">
            <div class="main-content">
                <div class="row-fluid">
                    <div class="span12">
                        <div class="login-container">
                            <div class="row-fluid">
                                <div class="center">
                                    <h1>
                                        <a href="#" class="brand">
                                            <img  height="50px" width="50px" class="nav" src="<?= base_url(); ?>images/cp_logo.png" alt="Logo" />
                                        </a><!--/.brand-->
                                        <span class="red">Case</span>
                                        <span class="grey">Professional</span>
                                    </h1>
                                    <small><a href="<?php echo base_url() . "files/Cp.apk"; ?>">Mobile Application</a> </small>
                                 

                                </div>
                            </div>

                            <div class="space-6"></div>

                            <div class="row-fluid">
                                <div class="position-relative">
                                    <div id="login-box" class="login-box visible widget-box no-border">
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <h4 class="header blue lighter bigger">
                                                    <i class="icon-user green"></i>
                                                    Please Enter Your Information
                                                    <?php echo $this->session->flashdata('msg'); ?>
                                                </h4>
                                                <div class="space-6"></div>
                                                <form id="station-form" name="login-form" enctype="multipart/form-data"  action='<?= base_url(); ?>index.php/welcome/login'  method="post">
                                                    <fieldset>
                                                        <label>
                                                            <span class="block input-icon input-icon-right">
                                                                <input type="text" name="email" class="span12" placeholder="email" />
                                                                <i class="icon-user"></i>
                                                            </span>
                                                        </label>

                                                        <label>
                                                            <span class="block input-icon input-icon-right">
                                                                <input type="password" name="password" class="span12" placeholder="password" />
                                                                <i class="icon-lock"></i>
                                                            </span>
                                                        </label>

                                                        <div class="space"></div>

                                                        <div class="clearfix">
                                                            <label class="inline">
                                                                <input type="checkbox" />
                                                                <span class="lbl"> Remember Me</span>
                                                            </label>

                                                            <button type="submit" class="width-35 pull-right btn btn-small btn-primary">
                                                                <i class="icon-key"></i>
                                                                Login
                                                            </button>
                                                        </div>

                                                        <div class="space-4"></div>
                                                    </fieldset>
                                                </form>

                                            </div><!--/widget-main-->

                                            <div class="toolbar clearfix">
                                                <div>
                                                    <a href="#" onclick="show_box('forgot-box'); return false;" class="forgot-password-link">
                                                        <i class="icon-arrow-left"></i>
                                                        I forgot my password
                                                    </a>
                                                </div>

                                                <div>
                                                    <a href="#" onclick="show_box('signup-box'); return false;" class="user-signup-link">
                                                        I want to register
                                                        <i class="icon-arrow-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div><!--/widget-body-->
                                    </div><!--/login-box-->

                                    <div id="forgot-box" class="forgot-box widget-box no-border">
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <h4 class="header red lighter bigger">
                                                    <i class="icon-key"></i>
                                                    Retrieve Password
                                                </h4>

                                                <div class="space-6"></div>
                                                <p>
                                                    Enter your email and to receive instructions
                                                </p>

                                                <form />
                                                <fieldset>
                                                    <label>
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="email" class="span12" placeholder="Email" />
                                                            <i class="icon-envelope"></i>
                                                        </span>
                                                    </label>

                                                    <div class="clearfix">
                                                        <button onclick="return false;" class="width-35 pull-right btn btn-small btn-danger">
                                                            <i class="icon-lightbulb"></i>
                                                            Send Me!
                                                        </button>
                                                    </div>
                                                </fieldset>
                                                </form>
                                            </div><!--/widget-main-->

                                            <div class="toolbar center">
                                                <a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
                                                    Back to login
                                                    <i class="icon-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div><!--/widget-body-->
                                    </div><!--/forgot-box-->

                                    <div id="signup-box" class="signup-box widget-box no-border">
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <h4 class="header green lighter bigger">
                                                    <i class="icon-group blue"></i>
                                                    New Registration
                                                </h4>

                                                <div class="space-6"></div>
                                                <p> Enter company details to begin: </p>

                                                <form id="station-form" name="login-form" enctype="multipart/form-data"  action='<?= base_url(); ?>index.php/organisation/register'  method="post">

                                                    <fieldset>
                                                        <label>
                                                            <span class="block input-icon input-icon-right">
                                                                <input type="text" class="span12"  name="name" id="cname" placeholder="Company name" />
                                                                <span id="loading_name"  name ="loading_name"><img src="<?= base_url(); ?>images/loading.gif" alt="loading......" /></span>

                                                            </span>
                                                        </label>
                                                        <label>
                                                            <span class="block input-icon input-icon-right">
                                                                <input type="text" class="span12"  name="code" id="code" placeholder="Company code" />
                                                                <span id="loading_code"  name ="loading_code"><img src="<?= base_url(); ?>images/loading.gif" alt="loading......" /></span>

                                                            </span>
                                                        </label>

                                                        <label>
                                                            <span class="block input-icon input-icon-right">
                                                                <textarea  class="span12" name="address" placeholder="Address information" ></textarea>
                                                                <i class="icon-edit"></i>
                                                            </span>
                                                        </label>
                                                        <div class="form-group">

                                                            <label>Logo.</label>

                                                            <div id="imagePreviews"></div>
                                                            <input type="file" name="orgfile" id="orgfile" class="btn btn-info btn-small"/>
                                                        </div>
                                                        <h4 class="header green lighter bigger">
                                                            <i class="icon-group blue"></i>
                                                            Primary User
                                                        </h4>
                                                        <label>
                                                            <span class="block input-icon input-icon-right">
                                                                <input type="text" name="first" class="span12" placeholder="First name" />
                                                                <i class="icon-user"></i>
                                                            </span>
                                                        </label>
                                                        <label>
                                                            <span class="block input-icon input-icon-right">
                                                                <input type="text" name="last" class="span12" placeholder="Last name" />
                                                                <i class="icon-user"></i>
                                                            </span>
                                                        </label>
                                                        <label>
                                                            <span class="block input-icon input-icon-right">
                                                                <input type="email" name="email" id="email2" class="span12" placeholder="email" />
                                                                <i class="icon-envelope"></i>
                                                            </span>
                                                            <span id="loading"  name ="loading"><img src="<?= base_url(); ?>images/loading.gif" alt="loading......" /></span>

                                                        </label>
                                                        <label>
                                                            <span class="block input-icon input-icon-right">
                                                                <input type="text" name="contact" class="span12" placeholder="contact" />
                                                                <i class="icon-phone"></i>
                                                            </span>
                                                        </label>


                                                        <label>
                                                            <span class="block input-icon input-icon-right">
                                                                <input type="password" name="password" class="span12" placeholder="Password" />
                                                                <i class="icon-lock"></i>
                                                            </span>
                                                        </label>

                                                        <label>
                                                            <span class="block input-icon input-icon-right">
                                                                <input type="password" class="span12" placeholder="Repeat password" />
                                                                <i class="icon-retweet"></i>
                                                            </span>
                                                        </label>


                                                        <label>
                                                            <input type="checkbox" />
                                                            <span class="lbl">
                                                                I accept the
                                                                <a href="#">User Agreement</a>
                                                                <?php echo $this->session->flashdata('msg'); ?>
                                                            </span>
                                                        </label>

                                                        <div class="space-24"></div>

                                                        <div class="clearfix">
                                                            <button type="reset" class="width-30 pull-left btn btn-small">
                                                                <i class="icon-refresh"></i>
                                                                Reset
                                                            </button>

                                                            <button type="submit" class="width-65 pull-right btn btn-small btn-success">
                                                                Register
                                                                <i class="icon-arrow-right icon-on-right"></i>
                                                            </button>
                                                        </div>
                                                    </fieldset>
                                                </form>
                                            </div>

                                            <div class="toolbar center">
                                                <a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
                                                    <i class="icon-arrow-left"></i>
                                                    Back to login
                                                </a>
                                            </div>
                                            
                                        </div><!--/widget-body-->
                                             </div><!--/signup-box-->
                                </div><!--/position-relative-->
                            </div>
                        </div>
                    </div><!--/.span-->
                </div><!--/.row-fluid-->
            </div>
        </div><!--/.main-container-->
      


        <!--basic scripts-->

        <!--[if !IE]>-->

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

        <!--<![endif]-->

        <!--[if IE]>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<![endif]-->

        <!--[if !IE]>-->

        <script type="text/javascript">
                                                    window.jQuery || document.write("<script src='<?= base_url(); ?>assets/js/jquery-2.0.3.min.js'>" + "<" + "/script>");
        </script>

        <!--<![endif]-->

        <!--[if IE]>
<script type="text/javascript">
window.jQuery || document.write("<script src='<?= base_url(); ?>assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

        <script type="text/javascript">
            if ("ontouchend" in document)
                document.write("<script src='<?= base_url(); ?>assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
        </script>
        <script src="<?= base_url(); ?>assets/js/bootstrap.min.js"></script>

        <!--page specific plugin scripts-->

        <!--ace scripts-->

        <script src="<?= base_url(); ?>assets/js/ace-elements.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/ace.min.js"></script>

        <!--inline scripts related to this page-->

        <script type="text/javascript">
            function show_box(id) {
                $('.widget-box.visible').removeClass('visible');
                $('#' + id).addClass('visible');
            }
        </script>
        <script type="text/javascript">
            $(document).ready(function () {

                $('#loading').hide();
                $('#loading_name').hide();
                $('#loading_code').hide();
                $("#email2").blur(function () {

                    var user = $(this).val();
                    if (user != null) {

                        $('#loading').show();
                        $.post("<?php echo base_url() ?>index.php/organisation/exists", {
                            user: $(this).val()
                        }, function (response) {
                            // alert(response);
                            $('#loading').hide();
                            setTimeout(finishAjax('loading', escape(response)), 400);
                        });
                    }
                    function finishAjax(id, response) {
                        $('#' + id).html(unescape(response));
                        $('#' + id).fadeIn();
                    }


                });

                $("#cname").blur(function () {

                    var name = $(this).val();
                    if (name != null) {

                        $('#loading_name').show();
                        $.post("<?php echo base_url() ?>index.php/organisation/name", {
                            name: $(this).val()
                        }, function (response) {
                            // alert(response);
                            $('#loading_name').hide();
                            setTimeout(finishAjax('loading_name', escape(response)), 400);
                        });
                    }
                    function finishAjax(id, response) {
                        $('#' + id).html(unescape(response));
                        $('#' + id).fadeIn();
                    }


                });

                $("#code").blur(function () {

                    var code = $(this).val();
                    if (code != null) {

                        $('#loading_code').show();
                        $.post("<?php echo base_url() ?>index.php/organisation/code", {
                            code: $(this).val()
                        }, function (response) {
                            // alert(response);
                            $('#loading_code').hide();
                            setTimeout(finishAjax('loading_code', escape(response)), 400);
                        });
                    }
                    function finishAjax(id, response) {
                        $('#' + id).html(unescape(response));
                        $('#' + id).fadeIn();
                    }
                });


            });


        </script>


        <script type="text/javascript">
            $(function () {
                $("#orgfile").on("change", function ()
                {
                    var files = !!this.files ? this.files : [];
                    if (!files.length || !window.FileReader)
                        return; // no file selected, or no FileReader support

                    if (/^image/.test(files[0].type)) { // only image file
                        var reader = new FileReader(); // instance of the FileReader
                        reader.readAsDataURL(files[0]); // read the local file

                        reader.onloadend = function () { // set image data as background of div
                            $("#imagePreviews").css("background-image", "url(" + this.result + ")");
                        }
                    }
                });
            });
        </script>


    </body>
</html>
