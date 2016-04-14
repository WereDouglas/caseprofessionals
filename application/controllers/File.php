<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class File extends CI_Controller {

    function __construct() {

        parent::__construct();
        error_reporting(E_PARSE);
        $this->load->model('Md');
        $this->load->library('session');
        $this->load->library('encrypt');
        date_default_timezone_set('Africa/Kampala');
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

    public function api() {

        $orgid = urldecode($this->uri->segment(3));
        $result = $this->Md->query("SELECT * FROM files WHERE org ='" . $orgid . "'");

        if ($result) {

            echo json_encode($result);  
        }
    }

    public function view() {

        $this->load->helper(array('form', 'url'));
        $fileid = $this->uri->segment(3);

        $query = $this->Md->query("SELECT * FROM files where id = '" . $fileid . "'");
        if ($query) {
            foreach ($query as $res) {
                $data['name'] = $res->name;
                $data['details'] = $res->details;
                $data['types'] = $res->types;
                $data['no'] = $res->no;
                $data['created'] = $res->created;
                $data['subject'] = $res->subject;
            }
        }
        $query = $this->Md->query("SELECT * FROM item where org = '" . $this->session->userdata('orgid') . "' ");
        //  var_dump($query);
        if ($query) {
            $data['items'] = $query;
        } else {
            $data['items'] = array();
        }
        $query = $this->Md->query("SELECT * FROM users where org = '" . $this->session->userdata('orgid') . "' ");
        //  var_dump($query);
        if ($query) {
            $data['users'] = $query;
        } else {
            $data['users'] = array();
        }

        $query = $this->Md->query("SELECT * FROM transactions where org = '" . $this->session->userdata('orgid') . "' AND file = '" . $fileid . "' ");
        //  var_dump($query);
        if ($query) {
            $data['trans'] = $query;
        } else {
            $data['trans'] = array();
        }
        //  echo 'we are coming from the controller';
        $query = $this->Md->query("SELECT * FROM payments where org = '" . $this->session->userdata('orgid') . "'");
        //  var_dump($query);
        if ($query) {
            $data['pay'] = $query;
        } else {
            $data['pay'] = array();
        }
        $query = $this->Md->query("SELECT * FROM schedule where org = '" . $this->session->userdata('orgid') . "' AND file= '" . $fileid . "' ");
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
        $data['fileid'] = $fileid;

        $this->load->view('file-view', $data);
    }

    public function schedule() {

        $this->load->helper(array('form', 'url'));
        $fileid = $this->uri->segment(3);

        $query = $this->Md->query("SELECT * FROM files where id = '" . $fileid . "'");
        if ($query) {
            foreach ($query as $res) {
                $data['name'] = $res->name;
                $data['details'] = $res->details;
                $data['types'] = $res->types;
                $data['no'] = $res->no;
                $data['created'] = $res->created;
                $data['subject'] = $res->subject;
            }
        }

        $query = $this->Md->query("SELECT * FROM schedule where org = '" . $this->session->userdata('orgid') . "' AND file='" . $fileid . "' ");
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
        $data['fileid'] = $fileid;

        $this->load->view('calendar-file', $data);
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
        $name = $this->input->post('names');
        $types = $this->input->post('types');
        $details = $this->input->post('details');
        $subject = $this->input->post('subject');

        $file = array('name' => $name, 'types' => $types, 'details' => $details, 'subject' => $subject, 'created' => date('Y-m-d H:i:s'));
        $this->Md->update($id, $file, 'files');
       $files = array('id'=>$id,'name' => $name, 'types' => $types, 'details' => $details, 'subject' => $subject, 'created' => date('Y-m-d H:i:s'));
       
        $content = json_encode($files);
        $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
        if ($query) {
            foreach ($query as $res) {
                $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'files', 'contents' => $content, 'action' => 'update', 'oid' => $id, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                $this->Md->save($syc, 'sync_data');
           }
        }
    }

    public function delete() {
        $this->load->helper(array('form', 'url'));
        $id = $this->uri->segment(3);
        $query = $this->Md->delete($id, 'files');
        if ($this->db->affected_rows() > 0) {

            $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
            if ($query) {
                foreach ($query as $res) {
                    $syc = array('object' => 'files', 'contents' => '', 'action' => 'delete', 'oid' => $id, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                    $this->Md->save($syc, 'sync_data');
                }
            }
            $this->session->set_flashdata('msg', '<div class="alert alert-error">
                                                   
                                                <strong>
                                                Information deleted	</strong>									
						</div>');
            redirect('file', 'refresh');
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-error">
                                                   
                                                <strong>
                                             Action Failed	</strong>									
						</div>');
            redirect('file', 'refresh');
        }
    }

    public function add() {

        $this->load->helper(array('form', 'url'));
        //user information
        $fileid = $this->GUID();
        $users = $this->input->post('client');
        $details = $this->input->post('details');
        $names = $this->input->post('named');
        $types = $this->input->post('types');
        $subject = $this->input->post('subject');
        $app = "O";
        switch ($types) {
            case Litigation:
                $app = "L";
                break;
            case General:
                $app = "G";
                break;
        }
        $no = $this->session->userdata('code') . "/" . $app . "/" . date('y') . "/" . date('m') . (int) date('d') . (int) date('H') . (int) date('i') . (int) date('ss');

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


            $files = array('id' => $fileid, 'users' => $users, 'org' => $orgid, 'details' => $details, 'name' => $names, 'types' => $types, 'created' => date('Y-m-d H:i:s'), 'status' => 'T', 'no' => $no, 'subject' => $subject);
            $this->Md->save($files, 'files');
            $contents = array('id' => $fileid, 'users' => $users, 'org' => $orgid, 'details' => $details, 'name' => $names, 'types' => $types, 'created' => date('Y-m-d H:i:s'), 'status' => 'T', 'no' => $no, 'subject' => $subject);

            $content = json_encode($contents);

            $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
            if ($query) {
                foreach ($query as $res) {
                    $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'files', 'contents' => $content, 'action' => 'create', 'oid' => $fileid, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
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
