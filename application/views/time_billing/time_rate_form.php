<?php
/**
 * @var $model TimeRate
 * @var $action string
*/
$formAttributes = [];
if(isset($action)) $formAttributes['action'] = $action;
include_once APPPATH .'helpers'.DIRECTORY_SEPARATOR.'Widget.php'?>

    <div class="col-md-offset-1">
        <p><?=validation_errors()?></p>
        <?php if(!empty($model->getErrors())):?>
            <strong>Please fix the following errors</strong>
            <ul>
                <?php foreach($model->getErrors() as $error) echo "<li>$error</li>"?>
            </ul>
        <?php endif ?>
    </div>

    <?php $form = Widget::beginForm($formAttributes)?>

        <?=$form->input($model, 'type')?>
        <?=$form->input($model, 'period', ['type'=>'number', 'step'=>0.1, 'min'=>1])?>
        <?=$form->input($model, 'rate', ['type'=>'number', 'step'=>1000, 'min'=>1000])?>

        <?=$form->submit($model->isNewRecord() ? 'Create' : 'Update')?>

    <?=$form->endForm()?>


