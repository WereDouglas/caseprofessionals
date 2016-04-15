
<?php require_once(APPPATH . 'views/css-page.php'); ?>

<div id="accordion2" class="accordion">  

    <div class="align-left">
        <h3>Schedules</h3>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>  

    <div class="row-fluid sortable">		

        <div class="box-body">

            <table class="jobs table table-striped table-bordered bootstrap-datatable datatable" id="datatable">
                <thead>
                    <tr> 
                        <th>DAY</th>
                        <th>START</th>
                        <th>END</th>
                        <th>DETAILS</th>
                        <th>ATTENDEES</th>
                        <th>ACTION</th>
                    </tr>
                </thead>   
                <tbody>

                    <?php
                    if (is_array($sch) && count($sch)) {
                        foreach ($sch as $loop) {
                            ?>  
                            <tr >
                                <td> 
                                    <?php echo $loop->dated; ?>
                                </td>
                                <td> 
                                    <?php echo $loop->starts; ?>
                                </td>
                                <td> 
                                    <?php echo $loop->ends; ?>
                                </td>
                                <td> 
                                    <?php echo $loop->detail; ?>
                                </td>
                                <td> 
                                    <?php
                                    if (is_array($att)) {
                                        foreach ($att as $val) {
                                            if ($val->scheduleID == $loop->id) {

                                                if (is_array($users)) {
                                                    foreach ($users as $user) {
                                                        if ($user->id == $val->userID) {                                                            
                                                            echo $user->name .'  ' .$user->contact.'<br>';
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </td>


                                <td class="center">
                                    <a class="btn-danger btn-small icon-remove" href="<?php echo base_url() . "index.php/schedule/delete/" . $loop->id; ?>"></a>
                                </td>
                            </tr>
        <?php
    }
}
?>
                </tbody>
            </table>            

        </div>


    </div>


<?php require_once(APPPATH . 'views/js-page.php'); ?>


