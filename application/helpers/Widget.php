<?php

class Widget
{
    public static function grid($config){
        include_once __DIR__. '/widgets/Grid.php';
        self::validate($config, 'config', ['data', 'attributes', 'columns']);

        $options = [
            'class'=>isset($config['options']['class']) ? $config['options']['class'] : [],
            'id'=>isset($config['options']['id']) ? $config['options']['id'] : 'grid'.Grid::$count++,
        ];

        return Grid::create([
            'data'=> $config['data'],
            'attributes'=> $config['attributes'],
            'columns'=> $config['columns'],
            'options'=> $options,
        ]);
    }

    /**
     * @param $collection
     * @param $collection_name
     * @param array $keys
     * @throws Exception
     */
    private static function validate($collection, $collection_name, $keys)
    {
        foreach($keys as $key)
            if(!isset($collection[$key]) || ($collection[$key] === null))
                throw new Exception("The value of $key and it's value are required in $collection_name");
    }

    /**
     * @param array $config
     * @return Form
     * @internal param $form_helper
     */
    public static function beginForm($config = [])
    {
        include_once __DIR__ . '/widgets/Form.php';
        $form = new Form($config);
        echo $form->beginForm();
        return $form;
    }
}