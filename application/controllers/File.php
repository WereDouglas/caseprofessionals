<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class File extends CI_Controller {

    function __construct() {

        parent::__construct();
       error_reporting(E_PARSE);
        $this->load->model('Md');
        $this->load->library('session');
        $this->load->library('encrypt');
    }

    public function index() {
         $query = $this->Md->query("SELECT * FROM users where org = '" . $this->session->userdata('orgid') . "' ");
       
        if ($query) {
            $data['users'] = $query;
        } else {
            $data['users'] = array();
        }
         $query = $this->Md->query("SELECT * FROM files where org = '" . $this->session->userdata('orgid') . "' ");
      
        if ($query) {
            $data['files'] = $query;
        } else {
            $data['files'] = array();
        }

        $this->load->view('file-page', $data);
    }

  

    public function view() {

        $this->load->helper(array('form', 'url'));
        $userid = $this->uri->segment(3);
        $query = $this->Md->query("SELECT * FROM contact where users = '" . $userid . "'");
        $data['userid'] = $userid;

        if ($query) {
            $data['contacts'] = $query;
        } else {
            $data['contacts'] = array();
        }
        $query = $this->Md->query("SELECT * FROM users where id = '" . $userid . "'");
        if ($query) {
            foreach ($query as $res) {
                $data['name'] = $res->name;
                $data['address'] = $res->address;
                $data['image'] = $res->image;
                $data['email'] = $res->email;
            }
        }



        $this->load->view('client-view', $data);
    }

    public function users() {
        $query = $this->Md->query("SELECT * FROM users where types <>'client'");
        //  var_dump($query);
        if ($query) {
            $data['users'] = $query;
        } else {
            $data['users'] = array();
        }
        $this->load->view('user-page', $data);
    }

    public function GUID() {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public function update() {

        $this->load->helper(array('form', 'url'));
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $types = $this->input->post('types');      
        $details = $this->input->post('details');

        $file = array('name' => $name, 'types' => $types, 'details' => $details,  'created' => date('Y-m-d H:i:s'));
        $this->Md->update($id, $file, 'files');

        $content = json_encode($file);
        $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
        if ($query) {
            foreach ($query as $res) {
                $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'files', 'content' => $content, 'action' => 'update', 'oid' => $id, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                $file_id = $this->Md->save($syc, 'sync_data');
            }
        }
    }

    public function delete() {
        $this->load->helper(array('form', 'url'));
        $id = $this->uri->segment(3);
        $this->Md->remove($id, 'users', 'image');
        $query = $this->Md->delete($id, 'users');
        if ($this->db->affected_rows() > 0) {

            $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
            if ($query) {
                foreach ($query as $res) {
                    $syc = array('object' => 'users', 'content' => '', 'action' => 'delete', 'oid' => $id, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                    $file_id = $this->Md->save($syc, 'sync_data');
                }
            }
            $this->session->set_flashdata('msg', '<div class="alert alert-error">
                                                   
                                                <strong>
                                                Information deleted	</strong>									
						</div>');
            redirect('user/client', 'refresh');
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-error">
                                                   
                                                <strong>
                                             Action Failed	</strong>									
						</div>');
            redirect('user/client', 'refresh');
        }
    }

   

    public function add() {


        $this->load->helper(array('form', 'url'));

        //user information
        $fileid = $this->GUID();
        $users = $this->input->post('client');
        $details = $this->input->post('details');
        $names = $this->session->userdata('names');
        $types = $this->input->post('types');
           
        $orgid = $this->session->userdata('orgid');

        if ($names != "") {
            
            $result = $this->Md->check($names, 'name', 'files');

            if (!$result) {
                $this->session->set_flashdata('msg', '<div class="alert alert-error">                                                   
                                                <strong>
                                                File name in use please </strong>									
						</div>');
              redirect('/file', 'refresh');
            }        

           
            $files = array('id' => $fileid, 'users' => $users, 'org' => $orgid, 'details' => $details, 'name' => $names, 'types' => $types, 'created' => date('Y-m-d H:i:s'), 'status' => 'T');
            $file_id = $this->Md->save($files, 'files');
            $content = array('id' => $fileid, 'users' => $users, 'org' => $orgid, 'details' => $details, 'name' => $names, 'types' => $types, 'created' => date('Y-m-d H:i:s'), 'status' => 'T');
           
            $content = json_encode($content);

            $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
            if ($query) {
                foreach ($query as $res) {
                    $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'files', 'content' => $content, 'action' => 'create', 'oid' => $fileid, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                    $file_id = $this->Md->save($syc, 'sync_data');
                }
            }
            $this->session->set_flashdata('msg', '<div class="alert alert-success">
                                   <strong>New File Saved</strong>									
						</div>');

           redirect('/file', 'refresh');
        }
       redirect('/file', 'refresh');
    }

}
