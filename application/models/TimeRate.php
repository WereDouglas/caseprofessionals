<?php
/**
 * @property integer $id
 * @property string $type
 * @property float $period
 * @property double $rate
*/
class TimeRate extends BaseModel
{
    public function __construct($id = null)
    {
        parent::__construct('time_rate', $id);
    }

    public function setValidationRules($scenario){
        switch($scenario) {
            case 'create':
            case 'update':
                $this->setRuleOnAttributes('required', ['type', 'period', 'rate']);
                break;
        }
    }
}