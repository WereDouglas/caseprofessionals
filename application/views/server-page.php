
<?php require_once(APPPATH . 'views/css-page.php'); ?>

<div id="accordion2" class="accordion">  

    <div class="align-left">
        <h3>Data Clients</h3>
        <?php echo $this->session->flashdata('msg'); ?>
    </div>  

            <div class="row-fluid sortable">		

                <div class="box-body">

                    <table class="table table-striped table-bordered bootstrap-datatable datatable" id="datatable">
                        <thead>
                            <tr> 
                                <th>#</th>
                                <th>NAME</th>
                                <th>PENDING SYNCS</th>
                                <th>DATE</th>                                                                        
                                
                                <th>ACTION</th>
                            </tr>
                        </thead>   
                        <tbody>

                            <?php
                            if (is_array($clients) && count($clients)) {
                                foreach ($clients as $loop) {
                                  
                                    ?>  
                                    <tr >
                                        <td> 
                                           <?php echo $loop->id; ?>
                                        </td>
                                         <td> 
                                           <?php echo $loop->name; ?>
                                        </td>
                                         
                                         <td> 
                                           <?php 
                                              $count = 0;
                                              foreach ($syncs as $loops) {                                                    
                                                  if ($loops->client == $loop->name){                                                      
                                                   $count += 1;  
                                                  }
                                              }
                                              echo $count;
                                           ?>
                                        </td>
                                        <td> 
                                           <?php echo $loop->created; ?>
                                        </td>
                                        <td class="center">
                                            <a class="btn-danger btn-small icon-remove" href="<?php echo base_url() . "index.php/client/delete/" . $loop->id."/". $loop->name; ?>"></a>
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


