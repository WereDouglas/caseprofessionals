<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Client extends CI_Controller {

    function __construct() {

        parent::__construct();
       // error_reporting(E_PARSE);
        $this->load->model('Md');
        $this->load->library('session');
        $this->load->library('encrypt');
        date_default_timezone_set('Africa/Kampala');
        $this->load->library('excel');
    }

    public function index() {
        $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "' ");

        if ($query) {
            $data['clients'] = $query;
        } else {
            $data['clients'] = array();
        }
        $query = $this->Md->query("SELECT * FROM sync_data where org = '" . $this->session->userdata('orgid') . "' ");

        if ($query) {
            $data['syncs'] = $query;
        } else {
            $data['syncs'] = array();
        }
        $this->load->view('server-page', $data);
    }

    public function import() {

        if (isset($_POST["Import"])) {
            $filename = $_FILES["file"]["tmp_name"];
            // echo $filename;
            if ($_FILES["file"]["size"] > 0) {
                $file = fopen($filename, "r");
                $file = $filename;
                
                $objPHPExcel = PHPExcel_IOFactory::load($file);
                //      Get worksheet dimensions
                $sheet = $objPHPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
                // Loop through each row of the worksheet in turn


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

                      var_dump($rowData);
                    for ($d = 0; $d < count($rowData); $d++) {
                       // var_dump($rowData[$d]);
                        echo $rowData[$d][0] . "<br>";
                        $namer = $this->Md->query_cell("SELECT * FROM users where name= '".$rowData[$d][0]."'", 'name');
                        //echo $name.'<br>';
                        //return;
                        if ($rowData[$d][0] != "" && $namer == "") {
                            $users = array('id' => $this->GUID(), 'image' => " ", 'email' => $rowData[$d][2], 'name' => $rowData[$d][0], 'org' => $this->session->userdata('orgid'), 'address' => $rowData[$d][4], 'sync' => $rowData[$d][1], 'oid' => " ", 'contact' => $rowData[$d][3], 'password' => " ", 'types' => 'client', 'level' => '4', 'created' => date('Y-m-d H:i:s'), 'status' => 'T');
                            //  $this->Md->save($users, 'users');
                            $content = array('id' => $this->GUID(), 'image' => " ", 'email' => $rowData[$d][2], 'name' => $rowData[$d][0], 'org' => $this->session->userdata('orgid'), 'address' => $rowData[$d][4], 'sync' => $rowData[$d][1], 'oid' => " ", 'contact' => $rowData[$d][3], 'password' => " ", 'types' => 'client', 'level' => '4', 'created' => date('Y-m-d H:i:s'), 'status' => 'T');
                            $contents = json_encode($content);
                            $query = $this->Md->query("SELECT * FROM client where org = '" . $this->session->userdata('orgid') . "'");
                            if ($query) {
                                foreach ($query as $res) {
                                    $syc = array('org' => $this->session->userdata('orgid'), 'object' => 'users', 'contents' => $contents, 'action' => 'create', 'oid' => $userid, 'created' => date('Y-m-d H:i:s'), 'checksum' => $this->GUID(), 'client' => $res->name);
                                    //  $this->Md->save($syc, 'sync_data');
                                }
                            }
                            
                              echo 'saving' . $name;
                        } else {

                            echo 'Repeated' . $name;
                        }
                    }
                    return;
                }
                //  Insert row data array into your database of choice here
            }
//send the data in an array format

            fclose($file);
            // redirect('/all');
        }

        echo '<div class="alert alert-info">   <strong>Information uploaded!  </strong>	</div>';
        redirect('user/client', 'refresh');
    }

    public function GUID() {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public function delete() {
        if ($this->session->userdata('level') == 1) {
            $this->load->helper(array('form', 'url'));
            $id = urldecode($this->uri->segment(3));
            $name = urldecode($this->uri->segment(4));
            $query = $this->Md->cascade($name, 'sync_data', 'client');
            $query = $this->Md->delete($id, 'client');
            //cascade($id,$table,$field)

            if ($this->db->affected_rows() > 0) {

                $this->session->set_flashdata('msg', '<div class="alert alert-error">
                                                   
                                                <strong>
                                                Information deleted	</strong>									
						</div>');
                redirect('client', 'refresh');
            }
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-error">                                                   
                                                <strong>
                                                 You cannot carry out this action ' . '	</strong>									
						</div>');
            redirect('client', 'refresh');
        }
    }

}
