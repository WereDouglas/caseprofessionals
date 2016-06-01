<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Message extends CI_Controller {

    function __construct() {
        parent::__construct();
        error_reporting(E_PARSE);
        $this->load->library('email');
        $this->load->library('upload');
        $this->load->model('Md');
    }

    public function GUID() {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public function mailer() {



        $guid = $this->GUID();
        $id = $this->session->userdata('orgID');
        $result = $this->Md->query("SELECT * FROM organizations WHERE orgID='" . $id . "'");
//  
//  var_dump($result);
        foreach ($result as $res) {
            $name = $res->name;
            $emailer = $res->email;
        }

// return;


        $files = $_FILES;
        $cpt = count($_FILES['attachment']['name']);
        for ($i = 0; $i < $cpt; $i++) {
            $_FILES['attachment']['name'] = $files['attachment']['name'][$i];
            $_FILES['attachment']['type'] = $files['attachment']['type'][$i];
            $_FILES['attachment']['tmp_name'] = $files['attachment']['tmp_name'][$i];
            $_FILES['attachment']['error'] = $files['attachment']['error'][$i];
            $_FILES['attachment']['size'] = $files['attachment']['size'][$i];
            $this->upload->initialize($this->set_upload_options());
            if ($this->upload->do_upload('attachment')) {

                $this->success = TRUE;
                $this->response = $this->upload->data();
                $this->response['file_name'];
            } else {
                $this->success = FALSE;
                $this->response = $this->upload->display_errors();
            }
            $fileName = $_FILES['attachment']['name'];
            $images[] = $fileName;
        }

        $fileNames = implode(',', $images);

        if ($fileNames != '') {
            $filename1 = explode(',', $fileNames);
            foreach ($filename1 as $file) {
                $files = array('name' => $file, 'guid' => $guid, 'created' => date('Y-m-d H:i:s'), 'org' => $emailer);
                $this->Md->save($files, 'attachment');
// echo base_url().'uploads/'.$file;
            }
        }
/// return;
//  $this->Md->upload_image($fileName);
// return;
        $schedule = $this->input->post('starts');
        if ($schedule == "") {
            $schedule = date('Y-m-d');
        }
        foreach ($this->input->post('emails') as $email) {          // echo $email;
            $mail = array('message' => $this->input->post('message'), 'subject' => $this->input->post('subject'), 'schedule' => $schedule, 'reciever' => $email, 'attachment' => $file, 'created' => date('Y-m-d H:i:s'), 'org' => $emailer, 'sent' => 'false', 'guid' => $guid);
            $this->Md->save($mail, 'emails');
            echo $information = 'Saved and mail will be sent on' . $schedule;
        }

        foreach ($this->input->post('ccs') as $cc) {
// echo $cc . "\n";
            $f = array('email' => $cc, 'guid' => $guid, 'type' => 'cc');
            $this->Md->save($f, 'cc');
        }

        foreach ($this->input->post('bccs') as $bcc) {
// echo $bcc . "\n";
            $fi = array('email' => $bcc, 'guid' => $guid, 'type' => 'bcc');
            $this->Md->save($fi, 'cc');
        }

        $this->sendEmail($information);
        return;
    }

    public function mailing() {

        $today = date('d-m-Y');
        $get_result = $this->Md->query("SELECT * FROM emails WHERE  schedule='" . $today . "' AND sent ='false'");
        foreach ($get_result as $res) {

            $this->email->initialize(array(
                'protocol' => 'smtp',
                // $sendgrid_username = "accessmobile";
                //$sendgrid_password = "Enabled123";
                'smtp_host' => 'smtp.sendgrid.net',
                'smtp_user' => 'weredouglas',
                'smtp_pass' => 'dughglas1',
                'smtp_port' => 587,
                'mailtype' => 'html',
                'crlf' => "\r\n",
                'newline' => "\r\n"
            ));

            $this->email->from($res->org,'Case Professional');
            $this->email->to($res->reciever);            
            $this->email->subject($res->subject);
            $this->email->message($res->message);
            $this->email->send();
            echo $this->email->print_debugger();
          
            
            $data = array('sent' => 'true');
            $this->Md->update($res->id, $data, 'emails');
            echo 'Sent ' . $res->reciever . '<br>';
        }
    }

}
