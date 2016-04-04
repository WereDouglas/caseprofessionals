<?php

/**
 * @property CI_Loader $load
 * @property  CI_Input $input
 * @property CI_Form_validation $form_validation
 * @property  CI_DB_mysql_driver $db
 */
class BaseModel extends CI_Model
{
    private $tableName;
    private $_isNewRecord;

    public function __construct($tableName=''){
        parent::__construct();
        $this->tableName = $tableName;
        $this->_isNewRecord = true;
        $this->load->database();
    }

    public function getAttributeName($attribute)
    {
        if(method_exists($this, 'attributes'))
            if(isset($this->attributes()[$attribute]))
                return $this->attributes()[$attribute];

        include_once APPPATH . 'helpers' .DIRECTORY_SEPARATOR . 'StringHelper.php';
        return StringHelper::friendlyString($attribute);
    }

    public function load_submitted_values()
    {
        if(!empty($_POST)){
            foreach($_POST as $property => $value)
                $this->{$property} = $value;
        }
    }

    /**
     * @param string|array $rule
     * @param array $attributes
     */
    public function generateFormValidationRules($rule, $attributes){
        if(!empty($attributes))
            foreach($attributes as $attribute)
                $this->form_validation->set_rules(
                    $attribute,
                    $this->getAttributeName($attribute),
                    $rule);
    }

    public function getOne($conditions=null){
        if(!empty($conditions))
            return $this->db->get_where($this->tableName, $conditions)->row_array();

        return $this->db->get($this->tableName)->row_array();
    }

    public function getAll($conditions=null){
        if(!empty($conditions))
            return $this->db->get_where($this->tableName, $conditions)->result_array();

        return $this->db->get($this->tableName)->result_array();
    }

    public function isNewRecord(){
        return $this->_isNewRecord;
    }
}