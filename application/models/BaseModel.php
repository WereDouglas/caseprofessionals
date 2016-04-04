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
    private $_errors = [];
    private $_validation = [];

    public function __construct($tableName='', $id = null){
        parent::__construct();
        $this->tableName = $tableName;
        $this->_isNewRecord = true;
        $this->load->database();
        $this->setFromId($id);
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

    public function loadSubmitted(){
        $model = get_class($this);

        if(isset($_POST["$model"])){
            $attributes = $_POST["$model"];
            foreach($attributes as $name => $value)
                $this->{$name} = $value;
            return true;
        }

        return false;
    }

    protected function setValidationRules($scenario){}

    protected function setRuleOnAttributes($rule, $attributes){
        $this->_validation[$rule] = $attributes;
    }

    public function validate($scenario)
    {
        $passed = true;
        $this->setValidationRules($scenario);

        if(isset($this->_validation['required'])){
            foreach($this->_validation['required'] as $field){
                if(!isset($this->{$field}) || $this->{$field} == null){
                    $this->addError($field, "The field <strong>$field</strong> is required");
                    $passed = false;
                }
            }
        }

        return $passed;
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    public function addError($field, $message){
        $this->_errors[$field] = $message;
    }

    public function save(){
        if($this->validate('create'))
            return $this->db->insert($this->tableName, $this->getAttributes());

        return false;
    }

    public function getAttributes($omit = [])
    {
        $attributes = [];
        $excludedElements = array_merge($omit, ['tableName', '_isNewRecord', '_errors', '_validation', ]);
        foreach(get_object_vars($this) as $attribute => $value) {
            if(!in_array($attribute, $excludedElements))
                $attributes[$attribute] = $value;
        }

        return $attributes;
    }

    private function setFromId($id)
    {
        if($id != null){
            $model = $this->getOne(['id'=>$id]);
            if(!empty($model)){
                foreach($model as $attribute => $value)
                    $this->{$attribute} = $value;
                $this->_isNewRecord = false;
            }
        }
    }

    public function update(){
        if($this->validate('update'))
            return $this->db->update($this->tableName,
                $this->getAttributes(['id']), ['id'=>$this->{'id'}]);

        return false;
    }

    public function delete(){
        return $this->db->delete($this->tableName, ['id'=>$this->{'id'}]);
    }

}