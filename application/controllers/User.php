<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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

    public function client() {

        $query = $this->Md->query("SELECT * FROM users where types = 'client'");
        //  var_dump($query);
        if ($query) {
            $data['users'] = $query;
        } else {
            $data['users'] = array();
        }


        $this->load->view('client-page', $data);
    }

    public function exists() {
        $this->load->helper(array('form', 'url'));
        $user = trim($this->input->post('user'));
        //returns($value,$field,$table)
        $get_result = $this->Md->returns($user, 'name', 'users');
        //href= "index.php/patient/add_chronic/'.$chronic.'"
        if (!$get_result)
            echo '<span style="color:#f00"> This client <strong style="color:#555555" >' . $user . '</strong> does not exist in our database.' . '<a href= "' . $user . '" value="' . $user . '" id="myLink" style="background #555555;color:#0749BA;" onclick="NavigateToSite()">Click here to add </a></span>';
        else
            echo '' . $get_result->contact . '<br>';
        echo '' . $get_result->email . '<br>';
        echo '' . $get_result->address . '<br>';      
        echo'<span class="span-data" name="userid" id="userid" >'.$get_result->id .'</span>';
    }

    public function add_user() {

        $user = $this->input->post('name');
        //$chronic = $this->uri->segment(3);
        if ($user != "") {

            $this->load->helper(array('form', 'url'));

            //user information
            $userid = $this->GUID();
            $email = ' ';
            $name = $user;
            $password = $this->session->userdata('code');
            $email = " ";
            $contact = " ";
            $address = " ";
            $level = 1;
            $type = 'client';
            $orgid = $this->session->userdata('orgid');


            $submitted = date('Y-m-d');
            $userfile = $data['file_name'];

            $users = array('id' => $userid, 'image' => '', 'email' => '', 'name' => $name, 'org' => $orgid, 'address' => $address, 'sync' => ' ', 'oid' => '', 'contact' => '', 'password' => '', 'types' => $type, 'level' => $level, 'created' => date('Y-m-d H:i:s'), 'status' => 'T');
            $this->Md->save($users, 'users');
            $content = json_encode($users);

            $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
            if ($query) {
                foreach ($query as $res) {
                    $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'users', 'content' => $content, 'action' => 'create', 'oid' => $userid, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                    $file_id = $this->Md->save($syc, 'sync_data');
                }
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
        $contact = $this->input->post('contact');
        $email = $this->input->post('email');
        $address = $this->input->post('details');

        $user = array('name' => $name, 'address' => $address, 'contact' => $contact, 'email' => $email, 'created' => date('Y-m-d H:i:s'));
        $this->Md->update($id, $user, 'users');

        $content = json_encode($user);
        $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
        if ($query) {
            foreach ($query as $res) {
                $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'users', 'content' => $content, 'action' => 'update', 'oid' => $id, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
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

    public function user() {

        $this->load->view('client-page');
    }

    public function add_client() {


        $this->load->helper(array('form', 'url'));

        //user information
        $userid = $this->GUID();
        $email = $this->input->post('email');
        $name = $this->input->post('name');
        $password = $this->session->userdata('code');
        $email = $this->input->post('email');
        $contact = $this->input->post('contact');
        $address = $this->input->post('address');
        $level = 1;
        $type = 'client';
        $orgid = $this->session->userdata('orgid');

        if ($name != "") {
            $password = $password;
            $key = $email;
            $password = $this->encrypt->encode($password, $key);
            $result = $this->Md->check($email, 'email', 'users');

            if (!$result) {
                $this->session->set_flashdata('msg', '<div class="alert alert-error">                                                   
                                                <strong>
                                                 email already in use please try again	</strong>									
						</div>');
                redirect('/user/client', 'refresh');
            }

            ///organisation image uploads
            $file_element_name = 'userfile';

            $config['upload_path'] = 'uploads/';
            // $config['upload_path'] = '/uploads/';
            $config['allowed_types'] = '*';
            $config['encrypt_name'] = FALSE;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload($file_element_name)) {
                $status = 'error';
                $msg = $this->upload->display_errors('', '');
                $this->session->set_flashdata('msg', '<div class="alert alert-error">                                                   
                                                <strong>' . $msg . '</strong></div>');
            }
            $data = $this->upload->data();

            $submitted = date('Y-m-d');
            $userfile = $data['file_name'];

            $users = array('id' => $userid, 'image' => $userfile, 'email' => $email, 'name' => $name, 'org' => $orgid, 'address' => $address, 'sync' => $sync, 'oid' => $oid, 'contact' => $contact, 'password' => $password, 'types' => $type, 'level' => $level, 'created' => date('Y-m-d H:i:s'), 'status' => 'T');
            $file_id = $this->Md->save($users, 'users');
            $content = array('id' => $userid, 'image' => $userfile, 'email' => $email, 'name' => $name, 'org' => $orgid, 'address' => $address, 'sync' => $sync, 'oid' => $oid, 'contact' => $contact, 'password' => $password, 'types' => $type, 'level' => $level, 'created' => date('Y-m-d H:i:s'), 'status' => 'T');

            $content = json_encode($content);

            $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
            if ($query) {
                foreach ($query as $res) {
                    $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'users', 'content' => $content, 'action' => 'create', 'oid' => $userid, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                    $file_id = $this->Md->save($syc, 'sync_data');
                }
            }
            $this->session->set_flashdata('msg', '<div class="alert alert-success">
                                   <strong>New client saved</strong>									
						</div>');

            redirect('/user/client', 'refresh');
        }
        $this->client();
    }

}
