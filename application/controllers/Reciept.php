<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reciept extends CI_Controller {

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

        $this->load->view('reciept-page', $data);
    }

    public function save() {

        $this->load->helper(array('form', 'url'));
        $transactionID = $this->GUID();
        $values = $this->input->post('name');
        $e = json_decode($values);


        $client = $e->userid;
        $types = 'credit';
        $created = $e->day;
        $users = $this->session->userdata('username');
        $org = $this->session->userdata('orgid');
        $approved = 'false';
        $total = $e->total;
        $file = ' ';
        /* payment */
        $amount = $e->paid;
        $balance = $e->balance;
        $method = $e->method;
        $no = $e->no;

        if ($users == "") {
            echo "please select the client";
            return;
        }
         if ($total <= 0) {
            echo "invalid sum value";
            return;
        }
        if ($org == "") {
            echo "wrong entry";
            return;
        }
        if ($values == "") {
            echo "please post information";
            return;
        }

        /* items */
        $items = (array) $e->items;
        $ts = 0;
        //$n = count($items);
        foreach ($items as $t) {

            // echo $t. "\n";
            if ($ts == 0) {
                $name = $t;
            }
            if ($ts == 1) {
                $description = $t;
            }
            if ($ts == 2) {
                $rate = $t;
            }
            if ($ts == 3) {
                $qty = $t;
            }
            if ($ts == 4) {
                $price = $t;
                $ts = 0;
                $itemID = $this->GUID();
                $itema = array('id' => $itemID, 'name' => $name, 'transactionID' => $transactionID, 'description' => $description, 'rate' => $rate, 'qty' => $qty, 'price' => $price, 'org' => $org);
                $this->Md->save($itema, 'item');

                $content = json_encode($itema);
                $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
                if ($query) {
                    foreach ($query as $res) {
                        $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'item', 'content' => $content, 'action' => 'create', 'oid' => $itemID, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                        $this->Md->save($syc, 'sync_data');
                    }
                }
            } else {

                $ts++;
            }
        }
        $paymentID = $this->GUID();
        $payment = array('id' => $paymentID, 'transactionID' => $transactionID, 'amount' => $amount, 'balance' => $balance, 'created' => $created, 'method' => $method, 'no' => $no, 'users' => $users, 'approved' => $approved, 'org' => $org);
        $this->Md->save($payment, 'payments');
        $content = json_encode($payment);
        $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
        if ($query) {
            foreach ($query as $res) {
                $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'payments', 'content' => $content, 'action' => 'create', 'oid' => $paymentID, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                $this->Md->save($syc, 'sync_data');
            }
        }

        $trans = array('id' => $transactionID, 'org' => $org, 'client' => $client, 'types' => $types, 'created' => $created, 'users' => $users, 'approved' => $approved, 'total' => $total, 'file' => $file);
        $this->Md->save($trans, 'transactions');

        $content = json_encode($trans);
        $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
        if ($query) {
            foreach ($query as $res) {
                $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'transactions', 'content' => $content, 'action' => 'create', 'oid' => $transactionID, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                $this->Md->save($syc, 'sync_data');
            }
        }
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
        $subject = $this->input->post('subject');

        $file = array('name' => $name, 'types' => $types, 'details' => $details, 'subject' => $subject, 'created' => date('Y-m-d H:i:s'));
        $this->Md->update($id, $file, 'files');

        $content = json_encode($file);
        $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
        if ($query) {
            foreach ($query as $res) {
                $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'files', 'content' => $content, 'action' => 'update', 'oid' => $id, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
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
                    $syc = array('object' => 'files', 'content' => '', 'action' => 'delete', 'oid' => $id, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
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
        $no = $this->session->userdata('code') . "/" . $app . "/" . date('y') . "/" . date('m') . (int) date('d') . (int) date('H') . (int) date('i') . (int) date('s');

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
