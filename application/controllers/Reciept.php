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

    public function transaction() {

        $orgid = urldecode($this->uri->segment(3));
        $result = $this->Md->query("SELECT * FROM transactions WHERE org ='" . $orgid . "'");

        if ($result) {

            echo json_encode($result);
        }
    }

    public function activate() {
        $this->load->helper(array('form', 'url'));
        $id = trim($this->input->post('id'));
        $actives = trim($this->input->post('actives'));
        if ($actives == "true") {
            $active = "false";
        }
        if ($actives == "false") {
            $active = "true";
        }
        if ($this->session->userdata('level') == 1) {

            $approve = array('approved' => $active);
            $this->Md->update($id, $approve, 'transactions');
            $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
            if ($query) {
                foreach ($query as $res) {
                    $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'transactions', 'contents' => $id, 'action' => 'approve', 'oid' => $active, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                    $this->Md->save($syc, 'sync_data');
                }
            }
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-error">                                                   
                                                <strong>
                                                 You cannot carry out this action ' . '	</strong>									
						</div>');
        }
    }

    public function pay() {

        $orgid = urldecode($this->uri->segment(3));
        $result = $this->Md->query("SELECT * FROM payments WHERE org ='" . $orgid . "'");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function item() {

        $orgid = urldecode($this->uri->segment(3));
        $result = $this->Md->query("SELECT * FROM item WHERE org ='" . $orgid . "'");

        if ($result) {

            echo json_encode($result);
        }
    }

    public function file() {

        if ($this->session->userdata('username') == "") {
            $this->session->sess_destroy();
            redirect('welcome', 'refresh');
        }

        $this->load->helper(array('form', 'url'));
        $fileID = $this->uri->segment(3);
        $fileName = $this->uri->segment(4);
        $clientID = $this->uri->segment(5);
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
        $data['fileID'] = $fileID;
        $data['fileName'] = $fileName;
        $data['clientID'] = $clientID;

        $this->load->view('file-receipt', $data);
    }

    public function balance() {
        if ($this->session->userdata('username') == "") {
            $this->session->sess_destroy();
            redirect('welcome', 'refresh');
        }

        $this->load->helper(array('form', 'url'));
        $transactionID = $this->uri->segment(3);
        $query = $this->Md->query("SELECT * FROM users where org = '" . $this->session->userdata('orgid') . "' ");
        if ($query) {
            $data['users'] = $query;
        } else {
            $data['users'] = array();
        }
        $query = $this->Md->query("SELECT * FROM transactions where org = '" . $this->session->userdata('orgid') . "' AND id ='" . $transactionID . "' ");
        //  var_dump($query);
        if ($query) {
            $data['trans'] = $query;
        } else {
            $data['trans'] = array();
        }
        //  echo 'we are coming from the controller';
        $query = $this->Md->query("SELECT * FROM payments WHERE transactionID ='" . $transactionID . "' ");
        //  var_dump($query);
        if ($query) {
            $data['pay'] = $query;
        } else {
            $data['pay'] = array();
        }
        $query = $this->Md->query("SELECT * FROM item where org = '" . $this->session->userdata('orgid') . "' AND transactionID ='" . $transactionID . "'");
        //  var_dump($query);
        if ($query) {
            $data['items'] = $query;
        } else {
            $data['items'] = array();
        }
        $this->load->view('balance-page', $data);
    }

    public function view() {

        if ($this->session->userdata('username') == "") {
            $this->session->sess_destroy();
            redirect('welcome', 'refresh');
        }

        $this->load->helper(array('form', 'url'));
        $transactionID = $this->uri->segment(4);
        $paymentID = $this->uri->segment(3);
        $query = $this->Md->query("SELECT * FROM item where org = '" . $this->session->userdata('orgid') . "' AND transactionID ='" . $transactionID . "'");
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
        $query = $this->Md->query("SELECT * FROM transactions where org = '" . $this->session->userdata('orgid') . "' AND id ='" . $transactionID . "' ");
        //  var_dump($query);
        if ($query) {
            $data['trans'] = $query;
        } else {
            $data['trans'] = array();
        }
        //  echo 'we are coming from the controller';
        $query = $this->Md->query("SELECT * FROM payments WHERE id ='" . $paymentID . "' ");
        //  var_dump($query);
        if ($query) {
            $data['pay'] = $query;
        } else {
            $data['pay'] = array();
        }

        $this->load->view('view-reciept-page', $data);
    }

    public function invoice() {

        $this->load->helper(array('form', 'url'));
        $transactionID = $this->uri->segment(3);

        $query = $this->Md->query("SELECT * FROM item where org = '" . $this->session->userdata('orgid') . "' AND transactionID ='" . $transactionID . "'");
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
        $query = $this->Md->query("SELECT * FROM transactions where org = '" . $this->session->userdata('orgid') . "' AND id ='" . $transactionID . "' ");
        //  var_dump($query);
        if ($query) {
            $data['trans'] = $query;
        } else {
            $data['trans'] = array();
        }
        //  echo 'we are coming from the controller';
        $query = $this->Md->query("SELECT * FROM payments WHERE id ='" . $paymentID . "' ");
        //  var_dump($query);
        if ($query) {
            $data['pay'] = $query;
        } else {
            $data['pay'] = array();
        }

        $this->load->view('invoice-page', $data);
    }

    public function payment() {

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

        $query = $this->Md->query("SELECT * FROM transactions where org = '" . $this->session->userdata('orgid') . "' ");
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

        $this->load->view('payment-page', $data);
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
        if ($e->fileid != "") {
            $file = $e->fileid;
        }
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
        if ($no == "") {
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
                        $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'item', 'contents' => $content, 'action' => 'create', 'oid' => $itemID, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
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
                $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'payments', 'contents' => $content, 'action' => 'create', 'oid' => $paymentID, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                $this->Md->save($syc, 'sync_data');
            }
        }

        $trans = array('id' => $transactionID, 'org' => $org, 'client' => $client, 'types' => $types, 'created' => $created, 'users' => $users, 'approved' => $approved, 'total' => $total, 'file' => $file);
        $this->Md->save($trans, 'transactions');

        $content = json_encode($trans);
        $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
        if ($query) {
            foreach ($query as $res) {
                $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'transactions', 'contents' => $content, 'action' => 'create', 'oid' => $transactionID, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                $this->Md->save($syc, 'sync_data');
            }
        }
        echo 'saved';
    }

    public function bal() {

        $this->load->helper(array('form', 'url'));


        $transactionID = $this->input->post('transactionID');

        $created = $this->input->post('day');
        $users = $this->session->userdata('username');
        $org = $this->session->userdata('orgid');
        $approved = 'false';

        //$var = floatval(preg_replace('/[^\d.]/', '', $var));

        $file = ' ';
        /* payment */
        $amount = floatval(preg_replace('/[^\d.]/', '', $this->input->post('amount')));
        $balance = floatval(preg_replace('/[^\d.]/', '', $this->input->post('balance')));
        $method = $this->input->post('method');
        $no = $this->input->post('no');

        if ($users == "") {
            echo "please select the client";
            return;
        }

        if ($org == "") {
            echo "wrong entry";
            return;
        }
        if ($amount == "") {
            echo "please post information";
            return;
        }
        if ($no == "") {
            echo "please post information";
            return;
        }
        $paymentID = $this->GUID();
        $payment = array('id' => $paymentID, 'transactionID' => $transactionID, 'amount' => $amount, 'balance' => $balance, 'created' => $created, 'method' => $method, 'no' => $no, 'users' => $users, 'approved' => $approved, 'org' => $org);
        $this->Md->save($payment, 'payments');
        $content = json_encode($payment);
        $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
        if ($query) {
            foreach ($query as $res) {
                $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'payments', 'contents' => $content, 'action' => 'create', 'oid' => $paymentID, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                $this->Md->save($syc, 'sync_data');
            }
        }
        $this->session->set_flashdata('msg', '<div class="alert alert-info">                                                   
                                                <strong>
                                          Information saved	</strong>									
						</div>');
        redirect('reciept/payment', 'refresh');
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
                $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'files', 'contents' => $content, 'action' => 'update', 'oid' => $id, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                $this->Md->save($syc, 'sync_data');
            }
        }
    }
    public function delete() {

        if ($this->session->userdata('level') == 1) {
            $this->load->helper(array('form', 'url'));
            $id = $this->uri->segment(3);
            $query = $this->Md->delete($id, 'transactions');
            //cascade($id,$table,$field)
            $query = $this->Md->cascade($id, 'payments', 'transactionID');
            $query = $this->Md->cascade($id, 'item', 'transactionID');
            if ($this->db->affected_rows() > 0) {
                $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
                if ($query) {
                    foreach ($query as $res) {
                        $syc = array('object' => 'transactions', 'contents' => $id, 'action' => 'delete', 'oid' => $id, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                        $this->Md->save($syc, 'sync_data');
                    }
                }
                $this->session->set_flashdata('msg', '<div class="alert alert-error">
                                                   
                                                <strong>
                                                Information deleted	</strong>									
						</div>');
                redirect('reciept/payment', 'refresh');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-error">
                                                   
                                                <strong>
                                             Action Failed	</strong>									
						</div>');
                redirect('reciept/payment', 'refresh');
            }
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-error">                                                   
                                                <strong>
                                                 You cannot carry out this action '.'	</strong>									
						</div>');
             redirect('reciept/payment', 'refresh');
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
