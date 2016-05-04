<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Procedure extends CI_Controller {

    function __construct() {

        parent::__construct();
        error_reporting(E_PARSE);
        $this->load->model('Md');
        $this->load->library('session');
        $this->load->library('encrypt');
        date_default_timezone_set('Africa/Kampala');
    }

    public function index() {
        $data['procs'] = array();
        $data['orgs'] = array();
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
        if ($this->session->userdata('orgid') != "") {
            $query = $this->Md->query("SELECT * FROM procedures where org = '" . $this->session->userdata('orgid') . "' OR org=''");
        } else {
            $query = $this->Md->query("SELECT * FROM procedures");
        }

        if ($query) {
            $data['procs'] = $query;
        }
        $query = $this->Md->query("SELECT * FROM organisation");
        if ($query) {
            $data['orgs'] = $query;
        }

        $this->load->view('procedure-page', $data);
    }

    public function clients() {
        $query = $this->Md->query("SELECT * FROM users  where org = '" . $this->session->userdata('orgid') . "' AND types='client' ORDER BY name DESC");
        echo json_encode($query);
    }

    public function user() {
        $query = $this->Md->query("SELECT * FROM users  where org = '" . $this->session->userdata('orgid') . "' AND types<>'client' ORDER BY name DESC");
        echo json_encode($query);
    }

    public function api() {

        $orgid = urldecode($this->uri->segment(3));
        $result = $this->Md->query("SELECT * FROM procedures WHERE org ='".$orgid."' OR org=''");

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
        $query = $this->Md->query("SELECT * FROM document where org = '" . $this->session->userdata('orgid') . "' AND cases = '" . $fileid . "' ");
        //  var_dump($query);
        if ($query) {
            $data['docs'] = $query;
        } else {
            $data['docs'] = array();
        }
        $query = $this->Md->query("SELECT * FROM note where org = '" . $this->session->userdata('orgid') . "' AND fileID= '" . $fileid . "' ");
        //  var_dump($query);
        if ($query) {
            $data['notes'] = $query;
        } else {
            $data['notes'] = array();
        }
        $query = $this->Md->query("SELECT * FROM bill where org = '" . $this->session->userdata('orgid') . "' AND fileID= '" . $fileid . "' ");
        //  var_dump($query);
        if ($query) {
            $data['bills'] = $query;
        } else {
            $data['bills'] = array();
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
        $files = array('id' => $id, 'name' => $name, 'types' => $types, 'details' => $details, 'subject' => $subject, 'created' => date('Y-m-d H:i:s'));

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
        $query = $this->Md->delete($id, 'procedures');
        if ($this->db->affected_rows() > 0) {

            $query = $this->Md->query("SELECT * FROM client ");
            if ($query) {
                foreach ($query as $res) {
                    $syc = array('object' => 'files', 'procedures' => '', 'action' => 'delete', 'oid' => $id, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                    $this->Md->save($syc, 'sync_data');
                }
            }
            $this->session->set_flashdata('msg', '<div class="alert alert-error">
                                                   
                                                <strong>
                                                Information deleted	</strong>									
						</div>');
            redirect('procedure', 'refresh');
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-error">
                                                   
                                                <strong>
                                             Action Failed	</strong>									
						</div>');
            redirect('procedure', 'refresh');
        }
    }

    public function add() {

        $this->load->helper(array('form', 'url'));
        //user information
        $id = $this->GUID();
        $name = $this->input->post('name');
        $period = $this->input->post('period');

        $org = $this->session->userdata('orgid');
        if ($this->session->userdata('orgid') != "") {
            $org = $this->session->userdata('orgid');
        } else {
            $org = "";
        }
        if ($name != "") {

            $proc = array('id' => $id, 'name' => $name, 'org' => $org, 'period' => $period);
            $this->Md->save($proc, 'procedures');
            $contents = array('id' => $id, 'name' => $name, 'org' => $org, 'period' => $period);
            $content = json_encode($contents);


            if ($this->session->userdata('orgid') != "") {
                $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
            } else {
                $query = $this->Md->query("SELECT * FROM client");
            }
            if ($query) {
                foreach ($query as $res) {
                    $syc = array('org' => $org, 'object' => 'procedures', 'contents' => $content, 'action' => 'create', 'oid' => $id, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                    $this->Md->save($syc, 'sync_data');
                }
            }
            $this->session->set_flashdata('msg', '<div class="alert alert-success">
                                   <strong>New Procedure Saved</strong>									
						</div>');

            redirect('/procedure', 'refresh');
        }
        redirect('/procedure', 'refresh');
    }

    public function defaults() {

        $this->load->helper(array('form', 'url'));
        //user information
        $id = $this->GUID();
        $name = $this->input->post('name');
        $period = $this->input->post('period');
        $org = "";

        if ($name != "") {

            $proc = array('id' => $id, 'name' => $name, 'org' => $org, 'period' => $period);
            $this->Md->save($proc, 'procedures');
            $contents = array('id' => $id, 'name' => $name, 'org' => $org, 'period' => $period);
            $content = json_encode($contents);

            $query = $this->Md->query("SELECT * FROM client");
            if ($query) {
                foreach ($query as $res) {
                    $syc = array('org' => '', 'object' => 'procedures', 'contents' => $content, 'action' => 'create', 'oid' => $id, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                    $this->Md->save($syc, 'sync_data');
                }
            }
            $this->session->set_flashdata('msg', '<div class="alert alert-success">
                                   <strong>New Procedure Saved</strong>									
						</div>');

            redirect('admin/procedures', 'refresh');
        }
        redirect('admin/procedures', 'refresh');
    }

}
