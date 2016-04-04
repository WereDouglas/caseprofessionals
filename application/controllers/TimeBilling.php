<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include_once __DIR__ . '/BaseController.php';
class TimeBilling extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = 'time_billing/';
        $this->navigationView = 'time_billing/navigation';
    }

    public function index(){
        $this->loadView('index', []);
    }
}