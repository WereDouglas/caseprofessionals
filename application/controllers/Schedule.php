<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule extends CI_Controller {

    function __construct() {

        parent::__construct();
        error_reporting(E_PARSE);
        $this->load->model('Md');
        $this->load->library('session');
        $this->load->library('encrypt');
    }

    public function index() {
        $query = $this->Md->query("SELECT * FROM users where org = '" . $this->session->userdata('orgid') . "' ");
        //  var_dump($query);
        if ($query) {
            $data['users'] = $query;
        } else {
            $data['users'] = array();
        }

        $query = $this->Md->query("SELECT * FROM schedule where org = '" . $this->session->userdata('orgid') . "' ");
        //  var_dump($query);
        if ($query) {
            $data['sch'] = $query;
        } else {
            $data['sch'] = array();
        }
         $query = $this->Md->query("SELECT * FROM attend where org = '" . $this->session->userdata('orgid') . "'");
        //  var_dump($query);
        if ($query) {
            $data['att'] = $query;
        } else {
            $data['att'] = array();
        }

        $this->load->view('calendar-page', $data);
    }
    public function  all() {
        $query = $this->Md->query("SELECT * FROM users where org = '" . $this->session->userdata('orgid') . "' ");
        //  var_dump($query);
        if ($query) {
            $data['users'] = $query;
        } else {
            $data['users'] = array();
        }

        $query = $this->Md->query("SELECT * FROM schedule where org = '" . $this->session->userdata('orgid') . "' ");
        //  var_dump($query);
        if ($query) {
            $data['sch'] = $query;
        } else {
            $data['sch'] = array();
        }
         $query = $this->Md->query("SELECT * FROM attend where org = '" . $this->session->userdata('orgid') . "'");
        //  var_dump($query);
        if ($query) {
            $data['att'] = $query;
        } else {
            $data['att'] = array();
        }

        $this->load->view('schedule-page', $data);
    }

    public function GUID() {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public function add() {

        $this->load->helper(array('form', 'url'));

        $day = $this->input->post('day');
        $days = $this->input->post('days');

        $fileid = $this->input->post('fileid'); 
        
        $notify = $this->input->post('trig');
        $notify = 'F';
        if ($notify != "") {
            $notify = 'T';
        }
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $details = $this->input->post('details');
        $priority = $this->input->post('priority');
        $attend = $this->input->post('attend');


        if ($day != "") {

            $scheduleID = $this->GUID();

            $sch = array('id' => $scheduleID, 'dated' => $day, 'priority' => $priority, 'days' => $days, 'detail' => $details, 'org' => $this->session->userdata('orgid'), 'starts' => $start, 'ends' => $end, 'triggers' => $notify, 'types' => 'client', 'created' => date('Y-m-d'), 'meet' => $start,'file'=>$fileid);
            $id = $this->Md->save($sch, 'schedule');
            foreach ($attend as $t) {
                $schs = array('org' => $this->session->userdata('orgid'),'userID' => $t, 'scheduleID' => $scheduleID);
                $this->Md->save($schs, 'attend');
            }
            $this->session->set_flashdata('msg', '<div class="alert">                                                   
                                                <strong>
                                                 schedule added</strong>									
						</div>');
            redirect('schedule/', 'refresh');
        } else {


            echo '<div class="alert alert-error">                                                  
                                                <strong>Missing field(s): <b>' . $errors . '</b> </strong>									
						</div>';
            redirect('schedule/', 'refresh');
        }
    }

    public function delete() {
        $this->load->helper(array('form', 'url'));
        $id = $this->uri->segment(3);

        $query = $this->Md->delete($id, 'contact');
        if ($this->db->affected_rows() > 0) {

            $this->session->set_flashdata('msg', '<div class="alert alert-error">
                                                   
                                                <strong>
                                                Information deleted	</strong>									
						</div>');
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-error">
                                                   
                                                <strong>
                                             Action Failed	</strong>									
						</div>');
        }
    }

}
