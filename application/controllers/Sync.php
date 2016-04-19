<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sync extends CI_Controller {

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

    public function api() {

        $orgid = urldecode($this->uri->segment(3));
        $app = urldecode($this->uri->segment(4));
        $result = $this->Md->query("SELECT * FROM sync_data WHERE org ='" . $orgid . "' AND client ='" . $app . "'");

        if ($result) {
            echo json_encode($result);
        }
    }

    public function up() {
        $this->load->helper(array('form', 'url'));
        $object = $this->input->post('object');
        $contents = (array) json_decode($this->input->post('contents'));
        $action = $this->input->post('action');
        $oid = $this->input->post('oid');
        $created = $this->input->post('created');
        $orgID = $this->input->post('orgID');
        $senderApplication = $this->input->post('sender');
        if ($action == "create") {
            $query = $this->Md->query("SELECT * FROM client where org = '" . $orgID . "'");
            if ($query) {
                foreach ($query as $res) {
                    if ($res->name != $senderApplication) {
                        $syc = array('org' => $orgID, 'object' => $object, 'contents' => $contents, 'action' => $action, 'oid' => $oid, 'created' => $created, 'checksum' => $this->GUID(), 'client' => $res->name);
                        $this->Md->save($syc, 'sync_data');
                    }
                }
            }
            $this->Md->save($contents, $object);
            echo "true";
        }
        if ($action == "update" || $action == "edit") {

            $query = $this->Md->query("SELECT * FROM client where org = '" . $orgID . "'");
            if ($query) {
                foreach ($query as $res) {
                    if ($res->name != $senderApplication) {
                        $syc = array('org' => $orgID, 'object' => $object, 'contents' => $contents, 'action' => $action, 'oid' => $oid, 'created' => $created, 'checksum' => $this->GUID(), 'client' => $res->name);
                        $this->Md->save($syc, 'sync_data');
                    }
                }
            }
            $this->Md->update($oid, $contents, $object);
            echo "true";
            //   $this->Md->update($id, $user, 'users');            
        }
        if ($action == "delete") {
           $contents = "";
            $query = $this->Md->query("SELECT * FROM client where org = '" . $orgID . "'");
            if ($query) {
                foreach ($query as $res) {
                    if ($res->name != $senderApplication) {
                        $syc = array('org' => $orgID, 'object' => $object, 'contents' => $contents, 'action' => $action, 'oid' => $oid, 'created' => $created, 'checksum' => $this->GUID(), 'client' => $res->name);
                        $this->Md->save($syc, 'sync_data');
                    }
                }
            }
            $this->Md->delete($oid, $object);

            if ($this->db->affected_rows() > 0) {
                echo "true";
            } else {
                echo "false";
            }
        }
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
        echo 'saved';
    }

    public function GUID() {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public function delete() {
        $this->load->helper(array('form', 'url'));
        $app = urldecode($this->uri->segment(3));
        //cascade($id,$table,$field)
        $query = $this->Md->cascade($app, 'sync_data', 'client');
        if ($this->db->affected_rows() > 0) {
            echo "Pending records deleted";
        }
    }

}
