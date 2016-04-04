<?php
/**
 * @var $rates array
 * @var $controller TimeBilling
*/
$links = [
  'create'=>base_url('index.php/TimeBilling/rates/create'),
];
include_once APPPATH .'helpers'.DIRECTORY_SEPARATOR.'Widget.php'
?>
<div class="container">
    <?php if(empty($rates)){?>
        <h4>No rates have been configured. Please add rates to use this feature</h4>
        <?php $controller->load->view('time_billing\time_rate_form', [
            'model'=>new TimeRate(),
            'action'=>$links['create']
        ])?>
    <?php }else{?>
        <h4>
            Billing Types
            <a class="pull-right btn btn-info" href="<?=$links['create']?>"><i class="glyphicon glyphicon-plus"></i> Add Billing Type</a>
        </h4>
        <?=Widget::grid([
            'data'=>$rates,
            'attributes'=>$controller->TimeRate->getAttributes(),
            'columns'=>[
                'type',
                'period',
                'rate',
                ['header'=>'Actions', 'value'=>'actions:edit;delete']
            ]
        ])?>
    <?php }?>
</div>
