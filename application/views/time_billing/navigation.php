<?php
$action = $this->router->fetch_method();
$param1 = $this->uri->segment(3);
$param2 = $this->uri->segment(4);
/**
 * @var $controllerName string
 */?>
<div class="header clearfix">
    <nav>
        <ul class="nav nav-pills pull-right">
            <li role="presentation" class=<?=(($action=='index')?"'active'":null)?>>
                <a href="<?=base_url("index.php/$controllerName/index")?>">Home</a>
            </li>
            <li role="presentation" class=<?=(($action=='rates')?"'active'":null)?>>
                <a href="<?=base_url("index.php/$controllerName/rates")?>">Rates</a>
            </li>
        </ul>
    </nav>
    <h3 class="text-muted">Time and Billing</h3>
    <hr>
</div>