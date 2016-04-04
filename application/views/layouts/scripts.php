<?php
if(!empty($js))
    foreach($js as $link){
        switch($link['type']){
            case LayoutHelper::JS_TYPE_LINK;
                echo "<script type='text/javascript' src='{$link['resource']}'></script>\n";
                break;
            case LayoutHelper::JS_TYPE_SCRIPT_LINK;
                echo $link['resource'] . "\n";
                break;
            case LayoutHelper::JS_TYPE_CODE_BLOCK;
                echo "<script type='text/javascript'>{$link['resource']}</script>\n";
                break;
        }
    }


