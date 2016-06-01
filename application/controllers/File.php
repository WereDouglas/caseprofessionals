<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class File extends CI_Controller {

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
        $data['procs'] = array();

        $query = $this->Md->query("SELECT * FROM procedures where org = '" . $this->session->userdata('orgid') . "' OR org=''");
        if ($query)
            $data['procs'] = $query;

        $this->load->view('file-page', $data);
    }
      public function import() {

        if (isset($_POST["Import"])) {
            $filename = $_FILES["file"]["tmp_name"];
            // echo $filename;
            if ($_FILES["file"]["size"] > 0) {
                $file = fopen($filename, "r");
                $file = $filename;
                $this->load->library('excel');
                $objPHPExcel = PHPExcel_IOFactory::load($file);
                //      Get worksheet dimensions
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                // Loop through each row of the worksheet in turn
                $budget = new stdClass();

                 for ($row = 1; $row < 2; $row++) {
                    //  Read a row of data into an array
                    // echo $row;
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                    // var_dump($rowData[0]);
                    // echo count($rowData[0]);
                    for ($m = 0; $m < count($rowData[0]); $m++) {

                        // echo $rowData[0][$m]."<br> ";
                    }
                }
                for ($row = 2; $row <= $highestRow; $row++) {
                    //  Read a row of data into an array
                    // echo $row;
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                    // var_dump($rowData[0]);
                    for ($d = 0; $d < count($rowData); $d++) {
                        // var_dump($rowData[$d]);
                        // echo $rowData[$d][13] . "<br>";
                        //  echo $rowData[$d][1] . "<br>";
                        //  echo $rowData[$d][2] . "<br>";
                        //  echo $rowData[$d][3] . "<br>";
                        $budget = new stdClass();

                        if ($this->session->userdata('department') != "") {
                            $department = $this->session->userdata('department');
                        } else {
                            $department = $str_replace("_", " ", $rowData[$d][1]);
                        }
                        if ($this->session->userdata('unit') != "") {
                            $unit = $this->session->userdata('unit');
                        } else {
                            $unit = $rowData[$d][2];
                        }
                        if ($this->session->userdata('period') != "" || $this->session->userdata('period') != "none") {
                            $period = $this->session->userdata('period');
                        } else {
                            $period = $$rowData[$d][55];
                        }

                        $instance = array('id' => $this->GUID(),
                            'account' => $rowData[$d][13],
                            'totalForeign' => $rowData[$d][24],
                            'unit' => $unit,
                            'department' => $department,
                            'period' => $period,
                            'submitted' => $this->session->userdata('email'),
                            'created' => date('Y-m-d H:i:s'),
                            'activity ' => $rowData[$d][3],
                            'output' => $rowData[$d][4],
                            'outcome' => $rowData[$d][5],
                            'objectives' => $rowData[$d][6],
                            'initiatives' => $rowData[$d][7],
                            'performance' => $rowData[$d][8],
                            'starts' => $rowData[$d][27],
                            'starts' => $rowData[$d][28],
                            'Procurement' => $rowData[$d][9],
                            'category ' => $rowData[$d][10],
                            'line' => $rowData[$d][11],
                            'subline' => $rowData[$d][12],
                            'funding ' => $rowData[$d][15],
                            'description' => $rowData[$d][14],
                            //**isssue
                            'currency' => $rowData[$d][17],
                            'rate' => $rowData[$d][18],
                            'priceForeign' => $rowData[$d][19],
                            'qty' => $rowData[$d][20],
                            'persons' => $rowData[$d][21],
                            'freq' => $rowData[$d][22],
                            'priceLocal' => $rowData[$d][23],
                            'totalForeign' => $rowData[$d][24],
                            //**issue
                            'flow' => $rowData[$d][10],
                            'totalLocal' => $rowData[$d][23],
                            'variance' => $rowData[$d][25],
                            //**isssue
                            'generation' => $rowData[$d][10],
                            'Jan' => $rowData[$d][31],
                            'Feb' => $rowData[$d][32],
                            'Mar' => $rowData[$d][33],
                            'Apr' => $rowData[$d][34],
                            'May' => $rowData[$d][35],
                            'Jun' => $rowData[$d][36],
                            'Jul' => $rowData[$d][37],
                            'Aug' => $rowData[$d][38],
                            'Sep' => $rowData[$d][39],
                            'Oct' => $rowData[$d][40],
                            'Nov' => $rowData[$d][41],
                            'Dec' => $rowData[$d][42],
                            'Q1' => $rowData[$d][45],
                            'Q2' => $rowData[$d][46],
                            'Q3' => $rowData[$d][47],
                            'Q4' => $rowData[$d][48],
                            'other' => "",
                            ///***issue
                            'details ' => $rowData[$d][54],
                            'Year ' => $rowData[$d][55],
                        );

                        //  $budget = json_encode($budget);
                        //  $instance = array('account' => $rowData[$d][13], 'total' => $rowData[$d][24], 'enddate' => "", 'startdate' => "", 'initiative' => $rowData[$d][7], 'unit' => $rowData[$d][2], 'department' => str_replace("_", " ", $rowData[$d][1]), 'period' => $rowData[$d][55], 'orgID' => '', 'content' => $budget, 'by' => $this->session->userdata('email'), 'created' => date('Y-m-d H:i:s'));
                        $id = $this->Md->save($instance, 'budgets');
                    }
                }
                //  Insert row data array into your database of choice here
            }
//send the data in an array format

            fclose($file);
            // redirect('/all');
        }

        echo '<div class="alert alert-info">   <strong>Information uploaded!  </strong>	</div>';
        redirect('file', 'refresh');
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
        $result = $this->Md->query("SELECT * FROM files WHERE org ='" . $orgid . "'");

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
        $query = $this->Md->delete($id, 'files');
        if ($this->db->affected_rows() > 0) {

            $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
            if ($query) {
                foreach ($query as $res) {
                    $syc = array('object' => 'files', 'contents' => '', 'action' => 'delete', 'oid' => $id, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
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
        $co = $this->input->post('co');
        $law = $this->input->post('law');
        $citation = $this->input->post('citation');
        $details = $this->input->post('details');
        $names = $this->input->post('named');
        $types = $this->input->post('types');
        $subject = $this->input->post('subject');

        $proc = $this->input->post('procs');
        $procdate = $this->input->post('procdate');
        $len = 0;
        foreach ($proc as $t) {
            $pc = explode('-', $t);
            $names = $names;
            $len = $len + $pc[0];
            $dt = $pc[1] . " " . $names;
            $day = date('Y-m-d', strtotime($procdate . ' + ' . $len . ' days'));
            $days = "1";
            $notify = 'T';
            $start = "07:00";
            $end = "09:00";
            $details = $this->input->post('details');
            $priority = "File";
            
            $fileid=$fileid;


            $scheduleID = $this->GUID();

            $sch = array('id' => $scheduleID, 'dated' => $day, 'priority' => $priority, 'days' => $days, 'detail' => $dt, 'org' => $this->session->userdata('orgid'), 'starts' => $start, 'ends' => $end, 'triggers' => $notify, 'types' => 'client', 'created' => date('Y-m-d'), 'meet' => $start, 'file' => $fileid);
            $id = $this->Md->save($sch, 'schedule');

            $content = json_encode($sch);
            $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
            if ($query) {
                foreach ($query as $res) {
                    $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'schedule', 'contents' => $content, 'action' => 'create', 'oid' => $scheduleID, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                    $file_id = $this->Md->save($syc, 'sync_data');
                }
            }
            $schs = array('org' => $this->session->userdata('orgid'), 'userID' => $co, 'scheduleID' => $scheduleID);
            $id = $this->Md->save($schs, 'attend');

            $contents = json_encode($schs);
            $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
            if ($query) {
                foreach ($query as $res) {
                    $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'attend', 'contents' => $contents, 'action' => 'create', 'oid' => $id, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                    $this->Md->save($syc, 'sync_data');
                }
            }
        }

        $app = "O";
        switch ($types) {
            case Litigation:
                $app = "L";
                break;
            case General:
                $app = "G";
                break;
        }
        $no = $this->session->userdata('code') . "/" . $app . "/" . date('y') . "/" . date('m') . (int) date('d') . (int) date('H') . (int) date('i') . (int) date('ss');

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


            $files = array('id' => $fileid, 'users' => $users, 'org' => $orgid, 'details' => $details, 'name' => $names, 'types' => $types, 'created' => date('Y-m-d H:i:s'), 'status' => 'T', 'no' => $no, 'subject' => $subject, 'citation' => $citation, 'law' => $law, 'co' => $co);
            $this->Md->save($files, 'files');
            $contents = array('id' => $fileid, 'users' => $users, 'org' => $orgid, 'details' => $details, 'name' => $names, 'types' => $types, 'created' => date('Y-m-d H:i:s'), 'status' => 'T', 'no' => $no, 'subject' => $subject, 'citation' => $citation, 'law' => $law, 'co' => $co);

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
