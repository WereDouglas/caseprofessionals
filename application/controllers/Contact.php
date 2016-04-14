<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

    function __construct() {

        parent::__construct();
        error_reporting(E_PARSE);
        $this->load->model('Md');
        $this->load->library('session');
        $this->load->library('encrypt');
    }

    public function index() {

        $this->load->view('client-page');
    }

    public function GUID() {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public function add() {

        $this->load->helper(array('form', 'url'));

        $posts = $this->input->post('posts');

        // {posts: posts,period:period,department:department,unit:unit,initiative:initiative,startdate:startdate,enddate:enddate,account:account}

        if ($posts != "") {
            $contact = new stdClass();
            foreach ($posts as $key => $value) {
                switch ($value['name']) {
                    case 'userid':
                        $users = $value['value'];
                    case 'val':
                        $val = $value['value'];
                    case 'type':
                        $type = $value['value'];
                    case 'trig':
                        $trig = $value['value'];
                }
            }
            $id = $this->GUID();
            
            $result_org = $this->Md->check($vale, 'val', 'contact');

            if (!$result_org) {
                $this->session->set_flashdata('msg', '<div class="alert alert-error">                                                   
                                                <strong>
                                                 contact is already registered</strong>									
						</div>');
               
            }
            else{
                    
                 $contact = array('id' => $id, 'users' => $users, 'trig' => $trig, 'val' => $val, 'type' => $type, 'created' => date('Y-m-d'));
                 $this->Md->save($contact, 'contact');
                 $content = json_encode($contact);
                $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
                if ($query) {
                    foreach ($query as $res) {
                        $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'contact', 'contents' => $content, 'action' => 'create', 'oid' => $id, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                        $this->Md->save($syc, 'sync_data');
                    }
                }
            }
            
           
            if ($id) {
                echo '<div class="alert alert-info">   <strong>Information submitted  </strong>	</div>';
                return;
            }
            } else {


            echo '<div class="alert alert-error">                                                  
                                                <strong>Missing field(s): <b>' . $errors . '</b> </strong>									
						</div>';
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
