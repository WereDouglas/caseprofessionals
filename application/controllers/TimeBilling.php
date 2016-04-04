<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once __DIR__ . '/../core/BaseController.php';
/**
 * @property Client $client
 * @property TimeRate $TimeRate
 */
class TimeBilling extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = 'time_billing/';
        $this->navigationView = 'time_billing/navigation';
        $this->load->model('TimeRate');
    }

    public function index(){
        $this->loadView('index', []);
    }

    public function rates($operation = 'index', $id = null){
        switch($operation){
            case 'index':
                $this->loadView('rates', [
                    'rates'=>$this->TimeRate->getAll(),
                ]);
                break;
            case 'create':
                $rate = new TimeRate();
                if($rate->loadSubmitted() && $rate->save())
                    $this->toRoute('TimeBilling/rates');

                $this->loadView('time_rate_form', ['model'=>$rate]);
                break;
            case 'edit':
                $rate = new TimeRate($id);
                if($rate->loadSubmitted() && $rate->update())
                    $this->toRoute('TimeBilling/rates');

                $this->loadView('time_rate_form', ['model'=>$rate]);
                break;
        }
    }
}