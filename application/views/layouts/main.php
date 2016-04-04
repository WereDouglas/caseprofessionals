<?php
/**
 * @var $title string
 * @var $controller BaseController
 * @var $view string
 * @var $navigationView string
 * @var $data array
 */?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?=$title?> - CasePro</title>

        <!-- Project CSS -->
        <link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/3.3.5/css/bootstrap.min.css"); ?>" />
        <link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/3.3.5/css/bootstrap-theme.min.css"); ?>" />

        <?php $controller->load->view('layouts/head', ['css'=>$controller->css]); ?>
    </head>

    <body>
        <div class="container col-md-12">
            <?php $controller->load->view($navigationView, ['controllerName'=>get_class($controller)]); ?>

            <div id="content" class="content-wrapper">
                <?php $controller->load->view($view, $data)?>
            </div>

            <?php //$controller->load->view('layouts/footer'); ?>

            <!-- Project JS -->
            <script src="<?php echo base_url("assets/jquery/1.11.3/jquery-min.js"); ?>"></script>
            <script src="<?php echo base_url("assets/bootstrap/3.3.5/js/bootstrap.min.js"); ?>"></script>

            <?php $controller->load->view('layouts/scripts', ['js'=>$controller->js]); ?>
        </div>
    </body>
</html>
