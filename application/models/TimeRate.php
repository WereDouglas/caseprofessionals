<?php
/**
 * @property integer $id
 * @property string $type
 * @property float $period
 * @property double $rate
*/
class TimeRate extends BaseModel
{
    public function __construct()
    {
        parent::__construct('time_rate');
    }
}