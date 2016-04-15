<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Organisation extends CI_Controller {

    function __construct() {

        parent::__construct();
        // error_reporting(E_PARSE);
        $this->load->model('Md');
        $this->load->library('session');
        $this->load->library('encrypt');
    }

    public function index() {
        $this->load->view('login');
    }

    public function update() {

        if ($this->session->userdata('level') == 1) {

            $this->load->helper(array('form', 'url'));
            $id = $this->input->post('id');
            $name = $this->input->post('name');
            $address = $this->input->post('address');
            $code = $this->input->post('code');

            $org = array('id' => $id, 'name' => $name, 'address' => $address,'code'=>$code);

            $content = json_encode($org);
            $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
            if ($query) {
                foreach ($query as $res) {
                    $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'org', 'contents' => $content, 'action' => 'update', 'oid' => $id, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                    $this->Md->save($syc, 'sync_data');
                }
            }
            $this->Md->update($id, $org, 'organisation');
            $this->session->set_flashdata('msg', '<div class="alert alert-error">                                                   
                                                <strong>
                                                 You may need to re-login for these changes to be carried out' . '	</strong>									
						</div>');
            redirect('welcome/info', 'refresh');
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-error">                                                   
                                                <strong>
                                                 You cannot carry out this action ' . '	</strong>									
						</div>');
            redirect('welcome/info', 'refresh');
        }
    }

    public function api() {

        $orgname = urldecode($this->uri->segment(3));
        $verification = urldecode($this->uri->segment(4));
        if ($orgname != "" || $verification != "") {
            $query = $this->Md->query("SELECT * FROM organisation WHERE  name ='" . $orgname . "' AND `keys` = '" . $verification . "'");
            if ($query) {
                foreach ($query as $res) {
                    $clientname = $res->code . "-DESKTOP" . date('y') . "-" . date('m') . (int) date('d') . (int) date('H') . (int) date('i') . (int) date('s');
                    $orgid = $res->id;
                }
                $client = array('org' => $orgid, 'active' => 'T', 'name' => $clientname, 'created' => date('Y-m-d H:i:s'));
                $this->Md->save($client, 'client');
                $temp = json_encode($query);  //$json={"var1":"value1","var2":"value2"}   
                $temp = substr($temp, 0, -2);
                $temp.=',"oid":"' . $clientname . '"}]';
                echo $temp;
            }
        } else {
            echo "";
        }
    }

    public function GUID() {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public function generate_key_string() {

        $tokens = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $segment_chars = 5;
        $num_segments = 4;
        $key_string = '';

        for ($i = 0; $i < $num_segments; $i++) {

            $segment = '';

            for ($j = 0; $j < $segment_chars; $j++) {
                $segment .= $tokens[rand(0, 35)];
            }

            $key_string .= $segment;

            if ($i < ($num_segments - 1)) {
                $key_string .= '-';
            }
        }

        return $key_string;
    }

    public function register() {
//organisation information
        $this->load->helper(array('form', 'url'));
        $name = $this->input->post('name');
        $code = $this->input->post('code');
        $license = $this->generate_key_string();
        $address = $this->input->post('address');
        $active = 'T';
        $starts = date('Y-m-d');
        $yourDate = date('Y-m-d');
        $mydate = date('Y-m-d', strtotime('+6 month', strtotime($yourDate)));
        $ends = $mydate;
        $sync = "";
        $oid = '';
        $action = '';
        $key = '';
        $version = '';
        $orgid = $this->GUID();

        //user information
        $userid = $this->GUID();
        $email = $this->input->post('email');
        $first = $this->input->post('first');
        $last = $this->input->post('last');
        $username = $first . ' ' . $last;
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $contact = $this->input->post('contact');
        $gender = "";
        $level = 5;
        $type = 'administrator';



        if ($first != "" && $last != "") {

            $password = $password;
            $key = $email;
            $password = $this->encrypt->encode($password, $key);
            $result = $this->Md->check($email, 'email', 'users');

            if (!$result) {
                $this->session->set_flashdata('msg', '<div class="alert alert-error">                                                   
                                                <strong>
                                                 email already in use please try again	</strong>									
						</div>');
                redirect('/organisation/register', 'refresh');
            }

            $result_org = $this->Md->check($code, 'code', 'organisation');

            if (!$result_org) {
                $this->session->set_flashdata('msg', '<div class="alert alert-error">                                                   
                                                <strong>
                                                 organisation code already registered</strong>									
						</div>');
                redirect('/organisation/register', 'refresh');
            }

            $result_org = $this->Md->check($name, 'name', 'organisation');

            if (!$result_org) {
                $this->session->set_flashdata('msg', '<div class="alert alert-error">                                                   
                                                <strong>
                                                 organisation name already registered</strong>									
						</div>');
                redirect('/organisation/register', 'refresh');
            }


            ///organisation image uploads
            $file_element_name = 'userfile';
            $file_element_organisation = 'orgfile';
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
            if (!$this->upload->do_upload($file_element_organisation)) {
                $status = 'error';
                $msg = $this->upload->display_errors('', '');
                $this->session->set_flashdata('msg', '<div class="alert alert-error">                                                  
                                                <strong>' . $msg . '</strong></div>');
            }
            $data = $this->upload->data();

            ///user image uploads

            $submitted = date('Y-m-d');
            $orgfile = $data['file_name'];
            $userfile = $data['file_name'];

            $users = array('id' => $userid, 'image' => '', 'email' => $email, 'name' => $username, 'org' => $orgid, 'addresss' => $address, 'sync' => $sync, 'oid' => $oid, 'contact' => $contact, 'password' => $password, 'types' => $type, 'level' => $level, 'created' => date('Y-m-d H:i:s'), 'status' => 'T');
            $file_id = $this->Md->save($users, 'users');

            // $client = array('org' => $orgid,'name' => 'web', 'active' => 'T', 'created' =>  date('Y-m-d H:i:s'));
            //$file_id = $this->Md->save($client, 'client');
            ///syncs
            $content = array('id' => $userid, 'image' => $userfile, 'email' => $email, 'name' => $username, 'org' => $orgid, 'address' => $address, 'sync' => $sync, 'oid' => $oid, 'contact' => $contact, 'password' => $password, 'types' => $type, 'level' => $level, 'created' => date('Y-m-d H:i:s'), 'status' => 'T');
            $content = json_encode($content);

            $query = $this->Md->query("SELECT * FROM client where org = '" . $orgid . "'");
            if ($query) {
                foreach ($query as $res) {
                    $syc = array('object' => 'users', 'contents' => $content, 'action' => 'create', 'oid' => $userid, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                    $file_id = $this->Md->save($syc, 'sync_data');
                }
            }
            /*             * */
            $org = array('id' => $orgid, 'image' => $orgfile, 'name' => $name, 'ends' => $ends, 'starts' => $starts, 'sync' => $sync, 'active' => $active, 'oid' => $oid, 'action' => $address, 'keys' => $license, 'version' => $version, 'code' => $code);
            $file_id = $this->Md->save($org, 'organisation');



            $this->session->set_flashdata('msg', '<div class="alert alert-success">
                                   <strong>information submitted</strong>									
						</div>');
            $newdata = array(
                'id' => $res->id,
                'username' => $username,
                'name' => $name,
                'email' => $email,
                'orgimage' => $orgfile,
                'orgid' => $orgid,
                'userimage' => $userfile,
                'starts' => $starts,
                'ends' => $ends,
                'code' => $code,
                'license' => $license,
                'level' => $level,
                'status' => $status,
                'logged_in' => TRUE
            );

            $this->session->set_userdata($newdata);
            redirect('/welcome/home', 'refresh');
        }
        $this->index();
    }

    public function logout() {

        $this->session->sess_destroy();
        redirect('welcome/logout', 'refresh');
    }

    public function login() {


        $this->load->helper(array('form', 'url'));
        $email = $this->input->post('email');
        $password_now = $this->input->post('password');
        $key = $email;

        $get_student = $this->Md->check($email, 'email', 'student');
        $get_user = $this->Md->check($email, 'email', 'user');


        if (!$get_student || !$get_user) {
            if (count($get_student) > 0) {

                $result = $this->Md->get('email', $email, 'student');
                // var_dump($result);
                foreach ($result as $res) {
                    $key = $email;
                    $password = $this->encrypt->decode($res->password, $key);

                    if ($password_now == $password) {
                        $status = $res->status;
                        $newdata = array(
                            'id' => $res->id,
                            'name' => $res->fname . ' ' . $res->lname . ' ' . $res->other,
                            'email' => $res->email,
                            'image' => $res->image,
                            'contact' => $res->contact,
                            'country' => $res->country,
                            'cohort' => $res->cohort,
                            'level' => 'student',
                            'status' => $res->status,
                            'logged_in' => TRUE
                        );

                        $this->session->set_userdata($newdata);

                        $cty = $this->session->userdata('country');
                        $country = $this->Md->get('name', $cty, 'country');
                        foreach ($country as $res) {
                            $county = $res->image;
                        }
                        $this->session->set_userdata('flag', $county);

                        $name = $this->session->userdata('name');
                        $query = $this->Md->get('reciever', $name, 'chat');
                        //  var_dump($query);
                        if ($query) {
                            $data['chats'] = $query;
                        } else {
                            $data['chats'] = array();
                        }
                        $query = $this->Md->query("SELECT * FROM outbreak where country = '" . $cty . "'");
                        //  var_dump($query);
                        if ($query) {
                            $data['outbreaks'] = $query;
                        } else {
                            $data['outbreaks'] = array();
                        }

                        $query = $this->Md->query("SELECT * FROM publication where country = '" . $cty . "'");
                        //  var_dump($query);
                        if ($query) {
                            $data['pubs'] = $query;
                        } else {
                            $data['pubs'] = array();
                        }

                        $query = $this->Md->show('event');
                        //  var_dump($query);
                        if ($query) {
                            $data['events'] = $query;
                        } else {
                            $data['events'] = array();
                        }
                        $query = $this->Md->show('event');
                        //  var_dump($query);
                        if ($query) {
                            $data['events'] = $query;
                        } else {
                            $data['events'] = array();
                        }
                        $query = $this->Md->show('student');
                        //  var_dump($query);
                        if ($query) {
                            $data['students'] = $query;
                        } else {
                            $data['students'] = array();
                        }

                        $query = $this->Md->query("SELECT * FROM student where status = 'false'");
                        //  var_dump($query);
                        if ($query) {
                            $data['student_cnt_false'] = $query;
                        } else {
                            $data['student_cnt_false'] = array();
                        }

                        $query = $this->Md->query("SELECT * FROM publication where verified = 'false'");
                        //  var_dump($query);
                        if ($query) {
                            $data['publication_cnt_review'] = $query;
                        } else {
                            $data['publication_cnt_review'] = array();
                        }
                        $query = $this->Md->query("SELECT * FROM publication where accepted = 'no'");
                        //  var_dump($query);
                        if ($query) {
                            $data['publication_cnt_accepted'] = $query;
                        } else {
                            $data['publication_cnt_accepted'] = array();
                        }

                        $query = $this->Md->query("SELECT * FROM presentation where accepted = 'no'");
                        //  var_dump($query);
                        if ($query) {
                            $data['present_cnt_accepted'] = $query;
                        } else {
                            $data['present_cnt_accepted'] = array();
                        }
                        if ($status != 'false') {
                            $this->load->view('center_page', $data);
                        } else {
                            $this->session->set_flashdata('msg', '<div class="alert alert-error">
                                                   
                                                <strong>
                                                your account has not yet been activated</strong>									
						</div>');
                            redirect('welcome/register', 'refresh');
                        }
                    } else {
                        $this->session->set_flashdata('msg', '<div class="alert alert-error">
                                                   
                                                <strong>
                                                 invalid password for student</strong>									
						</div>');
                        redirect('welcome/register', 'refresh');
                    }
                }
            }

            if (count($get_user) > 0) {
                $get_result = $this->Md->check($email, 'email', 'user');
                if (!$get_result) {
                    //$this->session->set_flashdata('msg', 'Welcome'.$email);
                    //get($field,$value,$table)
                    $result = $this->Md->get('email', $email, 'user');
                    // var_dump($result);
                    foreach ($result as $res) {
                        $key = $email;
                        $password = $this->encrypt->decode($res->password, $key);

                        if ($password_now == $password) {

                            $newdata = array(
                                'id' => $res->id,
                                'name' => $res->fname . ' ' . $res->lname . ' ',
                                'email' => $res->email,
                                'contact' => $res->contact,
                                'country' => $res->country,
                                'image' => $res->image,
                                'status' => $res->status,
                                'level' => $res->level,
                                'logged_in' => TRUE
                            );
                            $this->session->set_userdata($newdata);

                            if ($this->session->userdata('level') > 0) {
                                $cty = $this->session->userdata('country');
                                $country = $this->Md->get('name', $cty, 'country');
                                foreach ($country as $res) {
                                    $county = $res->image;
                                }
                                $this->session->set_userdata('flag', $county);

                                redirect('welcome/management/', 'refresh');
                                return;
                            }


                            redirect('welcome/management/', 'refresh');
                        } else {
                            $this->session->set_flashdata('msg', '<div class="alert alert-error"> <strong>! invalid password</strong></div>');
                            redirect('welcome/register', 'refresh');
                        }
                    }
                }
            }
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-error">  <strong>  ! invalid login credentials</div>');
            redirect('welcome/register', 'refresh');
        }
    }

    public function student() {
        $this->load->view('private');
    }

    public function management() {

        $cty = $this->session->userdata('country');

        $name = $this->session->userdata('name');
        $query = $this->Md->get('reciever', $name, 'chat');
        //  var_dump($query);
        if ($query) {
            $data['chats'] = $query;
        } else {
            $data['chats'] = array();
        }
        $query = $this->Md->query("SELECT * FROM outbreak where country = '" . $cty . "'");
        //  var_dump($query);
        if ($query) {
            $data['outbreaks'] = $query;
        } else {
            $data['outbreaks'] = array();
        }

        $query = $this->Md->query("SELECT * FROM publication where country = '" . $cty . "'");
        //  var_dump($query);
        if ($query) {
            $data['pubs'] = $query;
        } else {
            $data['pubs'] = array();
        }
        $query = $this->Md->query("SELECT * FROM student where status = 'false'");
        //  var_dump($query);
        if ($query) {
            $data['student_cnt_false'] = $query;
        } else {
            $data['student_cnt_false'] = array();
        }

        $query = $this->Md->query("SELECT * FROM publication where verified = 'false'");
        //  var_dump($query);
        if ($query) {
            $data['publication_cnt_review'] = $query;
        } else {
            $data['publication_cnt_review'] = array();
        }
        $query = $this->Md->query("SELECT * FROM publication where accepted = 'no'");
        //  var_dump($query);
        if ($query) {
            $data['publication_cnt_accepted'] = $query;
        } else {
            $data['publication_cnt_accepted'] = array();
        }

        $query = $this->Md->query("SELECT * FROM presentation where accepted = 'no'");
        //  var_dump($query);
        if ($query) {
            $data['present_cnt_accepted'] = $query;
        } else {
            $data['present_cnt_accepted'] = array();
        }


        $this->load->view('center_page', $data);
    }

    public function projects() {

        $query = $this->Md->show('project');
        if ($query) {
            $data['projects'] = $query;
        } else {
            $data['projects'] = array();
        }


        $this->load->view('projects', $data);
    }

    public function services() {

        $query = $this->Md->show('service');
        if ($query) {
            $data['services'] = $query;
        } else {
            $data['services'] = array();
        }
        $this->load->view('services', $data);
    }

    public function profile() {

        $query = $this->Md->show('profile');
        if ($query) {
            $data['profiles'] = $query;
        } else {
            $data['profiles'] = array();
        }
        $this->load->view('profile', $data);
    }

    public function contact() {
        $this->load->view('contact');
    }

    public function project() {
        $this->load->view('project');
    }

}
