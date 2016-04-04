<?php

include_once __DIR__ .'/BaseWidget.php';

/**
 * @property $helper
 */
class Form extends BaseWidget
{
    private $method;
    private $action;
    private $options;

    public function __construct($config){
        $this->init($config);
    }

    private function init($config)
    {
        if(isset($config['action']))
            $this->action = $config['action'];
        else
            $this->action = current_url();
        if(isset($config['method']))
            $this->method = $config['method'];
        else
            $this->method = 'POST';

        if(isset($config['options']))
            $this->options = $config['options'];
        else
            $this->options = ['class'=>'form'];
    }

    private static function generateButton($text, $options)
    {
        $attributes = '';
        if(!isset($params['type']))
            $options['type'] = 'submit';

        if(!isset($options['class']))
            $options['class'] = 'btn btn-success';

        foreach($options as $attribute => $value)
            $attributes .= $attribute . "='$value'";

        return "<button $attributes >$text</button>";
    }

    private static function generateInput($model, $attribute, $options)
    {
        $params = [
            'name'=>get_class($model)."[$attribute]",
            'id'=>$attribute,
        ];
        $attributes = '';
        $params = array_merge($params, $options);
        if(!isset($params['type']))
            $params['type'] = 'text';

        if(!isset($params['class']))
            $params['class'] = 'form-control';

        if($model != null && isset($model->{$attribute}))
            $params['value'] = $model->{$attribute};

        foreach($params as $attribute => $value)
            $attributes .= $attribute . "='$value'";

        return "<input $attributes />";

    }

    private static function generateLabel(BaseModel $model, $attribute)
    {
        $attribute_name = $model->getAttributeName($attribute);
        return "<label for='$attribute'>$attribute_name</label>";
    }

    public function beginForm()
    {
        $params = ['action'=>$this->action, 'method'=>$this->method];
        $params = array_merge($params, $this->options);
        $attributes = '';
        foreach($params as $attribute => $value)
            $attributes .= $attribute. '="'.$value.'" ';
        return "<form $attributes>";
    }

    public function endForm()
    {
        return '</form>';
    }

    public function input(BaseModel $model, $attribute, $options = [])
    {
        $class = isset($options['div-class'])?$options['div-class']:'form-group';

        $input = "\t<div class='$class'>";
        $input .= self::generateLabel($model, $attribute);
        $input .= self::generateInput($model, $attribute, $options);
        $input .= "</div>\n";
        return $input;
    }

    public function submit($text, $options = [])
    {
        $class = isset($options['div-class'])?$options['div-class']:'form-group';

        $input = "<div class='$class'>";
        $input .= self::generateButton($text, $options);
        $input .= '</div>';
        return $input;
    }
}