<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller {

    function __construct() {

        parent::__construct();
        error_reporting(E_PARSE);
        $this->load->model('Md');
        $this->load->library('session');
        $this->load->library('encrypt');
        date_default_timezone_set('Africa/Kampala');
    }

    public function index() {
        $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "' ");

        if ($query) {
            $data['clients'] = $query;
        } else {
            $data['clients'] = array();
        }
        $query = $this->Md->query("SELECT * FROM sync_data where org = '" . $this->session->userdata('orgid') . "' ");

        if ($query) {
            $data['syncs'] = $query;
        } else {
            $data['syncs'] = array();
        }
        $this->load->view('server-page', $data);
    }
   
 
    public function GUID() {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }
  
    public function delete() {
        $this->load->helper(array('form', 'url'));              
        $id = urldecode($this->uri->segment(3));        
        $name = urldecode($this->uri->segment(4));
        $query = $this->Md->cascade($name,'sync_data','client');
         $query = $this->Md->delete($id, 'client');
        //cascade($id,$table,$field)
        
       if ($this->db->affected_rows() > 0) {
           
         $this->session->set_flashdata('msg', '<div class="alert alert-error">
                                                   
                                                <strong>
                                                Information deleted	</strong>									
						</div>');
            redirect('client', 'refresh');
       }
        
    }    

}
