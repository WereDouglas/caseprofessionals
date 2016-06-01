<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Schedule extends CI_Controller {

    function __construct() {

        parent::__construct();
        error_reporting(E_PARSE);
        $this->load->model('Md');
        $this->load->library('session');
        $this->load->library('encrypt');
    }

    public function index() {

        if ($this->session->userdata('username') == "") {
            $this->session->sess_destroy();
            redirect('welcome', 'refresh');
        }

        $query = $this->Md->query("SELECT * FROM users where org = '" . $this->session->userdata('orgid') . "' ");
        //  var_dump($query);
        if ($query) {
            $data['users'] = $query;
        } else {
            $data['users'] = array();
        }

        //$query = $this->Md->query("SELECT * FROM schedule where org = '" . $this->session->userdata('orgid') . "' ");
        // var_dump($query);
        $query = $this->Md->query("SELECT * FROM attend INNER JOIN users ON attend.userID=users.id INNER JOIN schedule ON attend.scheduleID=schedule.id where attend.org = '" . $this->session->userdata('orgid') . "' ");
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

        $this->load->view('calendar-page', $data);
    }

    public function api() {

        $orgid = urldecode($this->uri->segment(3));
        $result = $this->Md->query("SELECT * FROM schedule WHERE org ='" . $orgid . "'");

        if ($result) {

            echo json_encode($result);
        }
    }

    public function attend() {

        $orgid = urldecode($this->uri->segment(3));
        $result = $this->Md->query("SELECT * FROM attend WHERE org ='" . $orgid . "'");

        if ($result) {

            echo json_encode($result);
        }
    }

    public function all() {

        if ($this->session->userdata('username') == "") {
            $this->session->sess_destroy();
            redirect('welcome', 'refresh');
        }
//        $query = $this->Md->query("SELECT * FROM attend INNER JOIN users ON attend.userID=users.id where org = '" . $this->session->userdata('orgid') . "' ");
//        //  var_dump($query);
//        if ($query) {
//            $data['users'] = $query;
//        } else {
//            $data['users'] = array();
//        }

        $query = $this->Md->query("SELECT * FROM attend INNER JOIN users ON attend.userID=users.id INNER JOIN schedule ON attend.scheduleID=schedule.id where attend.org = '" . $this->session->userdata('orgid') . "' ");
        //  var_dump($query);
        if ($query) {
            $data['sch'] = $query;
        } else {
            $data['sch'] = array();
        }
        $query = $this->Md->query("SELECT * FROM attend INNER JOIN users ON attend.userID=users.id INNER JOIN schedule ON attend.scheduleID=schedule.id where attend.org = '" . $this->session->userdata('orgid') . "' ");
        // var_dump($query);
//       /return;
        if ($query) {
            $data['att'] = $query;
        } else {
            $data['att'] = array();
        }

        $this->load->view('schedule-page', $data);
    }

    public function GUID() {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public function add() {

        $this->load->helper(array('form', 'url'));

        $day = $this->input->post('day');
        if($day ==""){
            $day = date('d-m-Y');            
        }
        $days = $this->input->post('days');
        $fileid = $this->input->post('fileid');
        $notify = $this->input->post('trig');
        $notify = 'F';
        if ($notify != "") {
            $notify = 'T';
        }
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $details = $this->input->post('details');
        $priority = $this->input->post('priority');
        $attend = $this->input->post('attend');


        if ($day != "") {

            $scheduleID = $this->GUID();

            $sch = array('id' => $scheduleID, 'dated' => $day, 'priority' => $priority, 'days' => $days, 'detail' => $details, 'org' => $this->session->userdata('orgid'), 'starts' => $start, 'ends' => $end, 'triggers' => $notify, 'types' => 'client', 'created' => date('Y-m-d'), 'meet' => $start, 'file' => $fileid);
            $id = $this->Md->save($sch, 'schedule');
            // $credits = $this->Md->query_cell("SELECT * FROM sms_credits where orgID= '" . $id . "'", 'credits');

            $content = json_encode($sch);
            $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
            if ($query) {
                foreach ($query as $res) {
                    $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'schedule', 'contents' => $content, 'action' => 'create', 'oid' => $scheduleID, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                    $file_id = $this->Md->save($syc, 'sync_data');
                }
            }
            $message = "Email reminder" . 'You have a meeting on ' . $day . ' at' . $start . ' Ending ' . $end . '<br> Details: ' . $details;
            $orgemail = $this->Md->query_cell("SELECT * FROM organisation where id= '" . $this->session->userdata('orgid') . "'", 'sync');
            foreach ($attend as $t) {
                $schs = array('org' => $this->session->userdata('orgid'), 'userID' => $t, 'scheduleID' => $scheduleID);
                $id = $this->Md->save($schs, 'attend');
                if ($notify == "T") {
                    $schedule = $day;                // echo $email;
                    $email = $this->Md->query_cell("SELECT * FROM users where id= '" . $t . "'", 'email');
                    $mail = array('message' => $message, 'subject' => 'REMINDER', 'schedule' => $schedule, 'reciever' => $email, 'created' => date('Y-m-d H:i:s'), 'org' => $orgemail, 'sent' => 'false', 'guid' => $scheduleID);
                    $this->Md->save($mail, 'emails');
                    echo $information = 'Saved and mail will be sent on' . $schedule;
                }


                $contents = json_encode($schs);
                $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
                if ($query) {
                    foreach ($query as $res) {
                        $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'attend', 'contents' => $contents, 'action' => 'create', 'oid' => $id, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                        $this->Md->save($syc, 'sync_data');
                    }
                }
            }
            $this->session->set_flashdata('msg', '<div class="alert">                                                   
                                                <strong>
                                                 Schedule added dated '.$day.'</strong>									
						</div>');
            redirect('schedule/', 'refresh');
        } else {


            echo '<div class="alert alert-error">                                                  
                                                <strong>Missing field(s): <b>' . $errors . '</b> </strong>									
						</div>';
            redirect('schedule/', 'refresh');
        }
    }

    public function delete() {

        if ($this->session->userdata('level') == 1 || $this->session->userdata('level') == 2) {
            $this->load->helper(array('form', 'url'));
            $id = $this->uri->segment(3);
            $query = $this->Md->delete($id, 'schedule');
            $query = $this->Md->cascade($id, 'attend', 'scheduleID');
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('msg', '<div class="alert alert-error">
                                                   
                                                <strong>
                                                Information Informationed	</strong>									
						</div>');
                $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
                if ($query) {
                    foreach ($query as $res) {
                        $syc = array('object' => 'schedule', 'contents' => $id, 'action' => 'delete', 'oid' => $id, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                        $this->Md->save($syc, 'sync_data');
                    }
                }
                redirect('schedule/', 'refresh');
            } else {
                $this->session->set_flashdata('msg', '<div class="alert alert-error">
                                                   
                                                <strong>
                                             Action Failed	</strong>									
						</div>');
            }
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-error">                                                   
                                                <strong>
                                                 You cannot carry out this action ' . '	</strong>									
						</div>');
            redirect('schedule/', 'refresh');
        }
    }

}
