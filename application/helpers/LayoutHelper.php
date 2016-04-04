<?php


class LayoutHelper
{
    const JS_TYPE_LINK = 'link';
    const JS_TYPE_SCRIPT_LINK = 'script_include';
    const JS_TYPE_CODE_BLOCK = 'code_block';

    public static function getJsType($js)
    {
        require_once __DIR__ . '/StringHelper.php';
        if(StringHelper::startsWith($js, '<script'))
            return LayoutHelper::JS_TYPE_SCRIPT_LINK;

        if(StringHelper::startsWith($js, 'http'))
            return LayoutHelper::JS_TYPE_LINK;

        return LayoutHelper::JS_TYPE_CODE_BLOCK;
    }

    /**
     * @param string $js
     * @return array
     */
    public static function getJsEntry($js)
    {
        $entry['type'] = LayoutHelper::getJsType($js);
        $entry['resource'] = $js;
        return $entry;
    }

    /**
     * @param $js_list
     * @return array
     */
    public static function getJsEntries($js_list)
    {
        $entries = [];
        foreach($js_list as $js)
            $entries[] = LayoutHelper::getJsEntry($js);

        return $entries;
    }

    public static function generateTitle($viewName, CI_Controller $controller)
    {
        $parts = preg_split("(\\|/)", $viewName);
        $view = end($parts);
        $controller_name = get_class($controller);
        require_once __DIR__ . '/../helpers/StringHelper.php';
        return StringHelper::friendlyString($view). ' ' . $controller_name ;
    }
}