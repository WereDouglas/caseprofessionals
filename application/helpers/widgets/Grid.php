<?php

include_once __DIR__ .'/BaseWidget.php';

class Grid extends BaseWidget
{
    public static $count = 1;

    /**
     * @param array $config
     * @return string
     */
    public static function create($config)
    {
        $index = self::generateIndex($config['columns']);
        $headers = self::getHeaders($index, $config['columns'], $config['attributes']);
        $rows = self::generateRows($index, $config['columns'], $config['data']);
        $options = [
            'class' => $config['options']['class'],
            'id' => $config['options']['id'],
        ];

        $table = self::generateTable($index, $headers, $rows, $options);
        return $table;
    }

    private static function getHeaders($index, $columns, $attributes)
    {
        $headers = [];

        for ($i = 0; $i < count($index); $i++) {
            if (is_array($columns[$i])) {
                if (!isset($columns[$i]['header']))
                    throw new Exception('Header is required');
                else
                    $headers[$index[$i]] = $columns[$i]['header'];
            } elseif (is_string($columns[$i]))
                $headers[$index[$i]] = self::resolveHeader($index[$i], $attributes);
        }
        return $headers;
    }

    private static function generateIndex($columns)
    {
        $headerColumns = [];
        foreach ($columns as $column) {
            if (is_array($column)) {
                if (!isset($column['header']))
                    throw new Exception('Header is required');
                else
                    $headerColumns[] = $column['header'];

            } elseif (is_string($column))
                $headerColumns[] = $column;
        }
        return $headerColumns;
    }

    private static function generateRows($index, $columns, $data)
    {
        $rows = [];
        $baseUrl = current_url();

        foreach ($data as $entry) {
            $row = [];
            for ($i = 0; $i < count($index); $i++) {
                if (isset($entry[$index[$i]]))
                    $row[$index[$i]] = $entry[$index[$i]];
                elseif (isset($columns[$i])) {
                    if (in_array(strtolower($index[$i]), ['actions','action'])) {
                        $id = $entry['id'];
                        $actions = [
                            'edit' => "<a href='$baseUrl/edit/$id'><i class='glyphicon glyphicon-edit'></i></a>",
                            'delete' => "<a href='$baseUrl/delete/$id' onclick='confirm(\"Are you sure You want to delete this record\")'>
                                            <i class='glyphicon glyphicon-trash'></i></a>",
                        ];
                        $action_config = isset($columns[$i]['value']) ? $columns[$i]['value'] : null;
                        $actions = self::resolveActions($actions, $action_config);
                        $row[$index[$i]] = $actions;
                    } elseif (in_array(strtolower($index[$i]), ['searchable'])) {
                        $id = $entry['id'];
                        $options = '';
                        if(isset($columns[$i]['options'])){
                            $opts = [];
                            foreach ($columns[$i]['options'] as $name=>$option)
                                $opts[] = $name . '="' .str_replace('{id}', $id, $option).'"';
                            $options = implode(' ', $opts);
                        }
                        $searchable = (isset($entry['searchable']) && ($entry['searchable'] == 'yes'))
                            ? 'checked'
                            : null;
                        $row[$index[$i]] = "<input type='checkbox' $options $searchable>";
                    } elseif (isset($columns[$i]['value']))
                        $row[$index[$i]] = $columns[$i]['value'];
                    else
                        $row[$index[$i]] = null;
                }
            }
            $rows[] = $row;
        }

        return $rows;
    }

    private static function generateTable($index, $headers, $rows, $options = [])
    {
        $classes = 'table ' . (is_array($options['class']) ? implode(' ', $options['class']) : $options['class']);
        $classes = trim($classes);

        $id = $options['id'];

        $table = "<table id='$id' class='$classes'>";

        if (!empty($headers)) {
            $table .= '<thead><tr>';
            foreach ($index as $key)
                $table .= "<th>{$headers[$key]}</th>";
            $table .= '</tr></thead>';

            if (!empty($rows)) {
                $table .= '<tbody>';
                foreach ($rows as $row) {
                    $table .= '<tr>';
                    foreach ($index as $key)
                        $table .= '<td>' . $row[$key] . '</td>';
                    $table .= '</tr>';
                }
                $table .= '</tbody>';
            }
        }

        $table .= '</table>';

        return $table;
    }

    /**
     * @param $column string
     * @param $attributes array
     * @return string
     */
    private static function resolveHeader($column, $attributes)
    {
        include_once APPPATH . 'helpers' . DIRECTORY_SEPARATOR . 'StringHelper.php';
        if (isset($attributes[$column]))
            return $attributes[$column];

        return StringHelper::friendlyString($column);
    }

    private static function resolveActions($actions, $config_string)
    {
        require_once APPPATH . 'helpers/StringHelper.php';
        $actions_prefix = 'actions:';
        $gridActions = [];

        if (!in_array($config_string, ['', null]) && StringHelper::startsWith($config_string, $actions_prefix)) {
            $action_methods = str_replace($actions_prefix, '', $config_string);
            $action_list = explode(';', $action_methods);
            foreach ($action_list as $key)
                if (isset($actions[$key]))
                    $gridActions[$key] = $actions[$key];
        } else
            $gridActions = $actions;

        return implode(' | ', $gridActions);
    }
}