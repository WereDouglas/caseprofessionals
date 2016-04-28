<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Document extends CI_Controller {

    function __construct() {
        parent::__construct();
        error_reporting(E_PARSE);
        $this->load->model('Md');
        $this->load->library('session');
        $this->load->library('encrypt');
    }

    public function index() {
        $data['users'] = array();
        $query = $this->Md->query("SELECT * FROM user");
        if ($query)
            $data['users'] = $query;
        $this->load->view('employee-page', $data);
    }

    public function docs() {
        $this->load->view('doc-page');
    }

    public function doc() {

        $files = $this->Md->query("SELECT * FROM files");
        $total = array();
        foreach ($files as $file) {
            $departmentObject = new stdClass();
            $departmentObject->id = $file->id;
            $departmentObject->name = $file->name;
            $documents = $this->Md->query("SELECT * FROM files INNER JOIN document ON files.id=document.cases WHERE document.cases='" . $file->id . "'");
            $departmentObject->children = array();
            foreach ($documents as $doc) {

                $userObject = new stdClass();
                $userObject->id = $doc->id;
                $userObject->names = $doc->name;
                $userObject->created = $doc->created;

                array_push($departmentObject->children, $userObject);
            }
            array_push($total, $departmentObject);
        }

        echo json_encode($total);
    }

    public function all() {
        $query = $this->Md->query("SELECT *  FROM user ORDER BY name DESC");
        echo json_encode($query);
    }

    public function api() {

        $orgid = urldecode($this->uri->segment(3));
        $result = $this->Md->query("SELECT * FROM document WHERE org ='" . $orgid . "'");

        if ($result) {

            echo json_encode($result);
        }
    }
     public function notes() {

        $orgid = urldecode($this->uri->segment(3));
        $result = $this->Md->query("SELECT * FROM note WHERE org ='" . $orgid . "'");

        if ($result) {

            echo json_encode($result);
        }
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
        echo'<span class="span-data" name="userid" id="userid" style="visibility:hidden" >' . $get_result->id . '</span>';
    }

    public function GUID() {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public function update() {
        if ($this->session->userdata('level') == 1 || $this->session->userdata('level') == 2) {
            $this->load->helper(array('form', 'url'));
            $id = $this->input->post('id');
            $name = $this->input->post('name');
            $contact = $this->input->post('contact');
            //$email = $this->input->post('email');
            $address = $this->input->post('address');

            $user = array('id' => $id, 'name' => $name, 'address' => $address, 'contact' => $contact, 'created' => date('Y-m-d H:i:s'));

            $content = json_encode($user);
            $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
            if ($query) {
                foreach ($query as $res) {
                    $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'users', 'contents' => $content, 'action' => 'update', 'oid' => $id, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                    $this->Md->save($syc, 'sync_data');
                }
            }
            $this->Md->update($id, $user, 'users');
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-error">                                                   
                                                <strong>
                                                 You cannot carry out this action ' . '	</strong>									
						</div>');
            redirect('/user', 'refresh');
        }
    }

    public function delete() {

        if ($this->session->userdata('level') == 1) {
            $this->load->helper(array('form', 'url'));
            $id = $this->uri->segment(3);
            $this->Md->remove($id, 'users', 'image');
            $query = $this->Md->cascade($id, 'contact', 'users');
            $query = $this->Md->delete($id, 'users');
            if ($this->db->affected_rows() > 0) {

                $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
                if ($query) {
                    foreach ($query as $res) {
                        $syc = array('object' => 'users', 'contents' => '', 'action' => 'delete', 'oid' => $id, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                        $this->Md->save($syc, 'sync_data');
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
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-error">                                                   
                                                <strong>
                                                 You cannot carry out this action ' . '	</strong>									
						</div>');
            redirect('/user', 'refresh');
        }
    }

    public function generateRandomString($length = 6) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
