<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct() {

        parent::__construct();
        error_reporting(E_PARSE);
        $this->load->model('Md');
        $this->load->library('session');
        $this->load->library('encrypt');
    }

    public function index() {
        $this->load->view('login');
    }

    public function home() {
        if ($this->session->userdata('username') != "") {
            $this->load->view('home');
        } else {

            $this->session->sess_destroy();
            redirect('welcome', 'refresh');
        }
    }

    public function page() {

        $this->load->view('page');
    }

    public function logout() {

        $this->session->sess_destroy();
        redirect('welcome', 'refresh');
    }

    public function login() {


        $this->load->helper(array('form', 'url'));
        $email = $this->input->post('email');
        $password_now = $this->input->post('password');
        $get_user = $this->Md->check($email, 'email', 'users');

        if (!$get_user) {

            $results = $this->Md->get('email', $email, 'users');
            // var_dump($results);
            foreach ($results as $resv) {
                $key = $email;
                $password = $this->encrypt->decode($resv->password, $key);
                $org = $res->org;

                $orgs = $this->Md->get('id', $resv->org, 'organisation');
                foreach ($orgs as $res) {
                    $name = $res->name;
                    $orgimage = $res->image;
                    $starts = $res->starts;
                    $ends = $res->ends;
                    $code = $res->code;
                    $license = $res->license;
                    $address = $res->address;
                }
                $this->session->set_userdata('name', $name);
                $this->session->set_userdata('orgimage', $orgimage);
                $this->session->set_userdata('address', $address);
                $this->session->set_userdata('starts', $starts);
                $this->session->set_userdata('ends', $ends);
                $this->session->set_userdata('code', $code);
                $this->session->set_userdata('license', $license);
                $this->session->set_userdata('username', $resv->name);
                $this->session->set_userdata('orgid', $resv->org);

                $newdata = array(
                    'id' => $resv->id,
                    'email' => $resv->email,
                    'userimage' => $resv->image,
                    'title' => $resv->types,
                    'level' => $resv->level,
                    'status' => $resv->status,
                    'logged_in' => TRUE
                );
                $this->session->set_userdata($newdata);
            }

            if ($password_now == $password) {


                redirect('/welcome/home', 'refresh');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-error">  <strong>  ! invalid login credentials</div>');
                redirect('welcome', 'refresh');
            }
        } else {

            $this->session->set_flashdata('msg', '<div class="alert alert-error">  <strong>  ! This user does not exist</div>');
            redirect('welcome', 'refresh');
        }
    }

    public function student() {
        $this->load->view('private');
    }

    public function register() {
        $this->load->helper(array('form', 'url'));

        $fname = $this->input->post('fname');
        $lname = $this->input->post('lname');
        $password = $this->input->post('password1');


        if ($fname != "" && $lname != "") {


            $email = $this->input->post('email');
            $password = $password;
            $key = $email;

            $password = $this->encrypt->encode($password, $key);

            $get_result = $this->Md->check($email, 'email', 'student');

            if (!$get_result) {
                $this->session->set_flashdata('msg', '<div class="alert alert-error">
                                                   
                                                <strong>
                                                 Email already in use	</strong>									
						</div>');
                redirect('/management/student', 'refresh');
            }


            $file_element_name = 'userfile';



            $config['upload_path'] = 'uploads/';
// $config['upload_path'] = '/uploads/';
            $config['allowed_types'] = '*';
            $config['encrypt_name'] = FALSE;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload($file_element_name)) {
                $status = 'error';
                echo $msg = $this->upload->display_errors('', '');
            } else {

                $data = $this->upload->data();
                $other = $this->input->post('other');
                $gender = $this->input->post('gender');
                $dob = date('Y-m-d', strtotime($this->input->post('dob')));
                $country = $this->input->post('country');
                if ($this->session->userdata('level') == 1) {

                    $country = $this->session->userdata('country');
                }
                $contact = $this->input->post('contact');
                $cohort = $this->input->post('cohort');
                $submitted = date('Y-m-d');
                $file = $data['file_name'];
                $email = $this->input->post('email');

                $student = array('image' => $file, 'fname' => $fname, 'lname' => $lname, 'other' => $other, 'email' => $email, 'gender' => $gender, 'dob' => $dob, 'country' => $country, 'password' => $password, 'contact' => $contact, 'cohort' => $cohort, 'submitted' => date('Y-m-d H:i:s'), 'status' => 'false');
                $file_id = $this->Md->save($student, 'student');
                ;
                $this->session->set_flashdata('msg', '<div class="alert alert-success">
                                                   
                                                <strong>
                                                 information saved</strong>									
						</div>');

                redirect('/management/student', 'refresh');
            }
        }
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
