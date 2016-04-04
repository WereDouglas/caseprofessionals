
<?php require_once(APPPATH . 'views/css-page.php'); ?>

<div id="accordion2" class="accordion">  

    <div class="align-left">
        <h3>Synchronisation logs</h3>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>  

            <div class="row-fluid sortable">		

                <div class="box-body">

                    <table class="table table-striped table-bordered bootstrap-datatable datatable" id="datatable">
                        <thead>
                            <tr> 
                                <th>#</th>
                                <th>OBJECT</th>
                                <th>ACTION</th>
                                <th>DATE</th>
                                <th>CLIENT</th>                                           
                                
                                <th>ACTION</th>
                            </tr>
                        </thead>   
                        <tbody>

                            <?php
                            if (is_array($logs) && count($logs)) {
                                foreach ($logs as $loop) {
                                  
                                    ?>  
                                    <tr >
                                        <td> 
                                           <?php echo $loop->id; ?>
                                        </td>
                                         <td> 
                                           <?php echo $loop->object; ?>
                                        </td>
                                         <td> 
                                           <?php echo $loop->action; ?>
                                        </td>
                                         <td> 
                                           <?php echo $loop->created; ?>
                                        </td>
                                         <td> 
                                           <?php echo $loop->client; ?>
                                        </td>
                                       

                                        <td class="center">
                                            <a class="btn-danger btn-small icon-remove" href="<?php echo base_url() . "index.php/log/delete/" . $loop->id; ?>"></a>
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


