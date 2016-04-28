<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/easyui.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/icon.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/demo.css">
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/shieldui-all.min.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/all.min.css" />
<link rel="stylesheet" href="<?= base_url(); ?>assets/jquery-ui.css">


    <table title="Files and Documents" class="easyui-treegrid" style="width:100%;height:750px"
            data-options="
                url: '<?php echo base_url() . 'index.php/document/doc/'; ?>',
                method: 'get',
                rownumbers: true,
                idField: 'id',
                treeField: 'names'
            ">
        <thead>
            <tr>
                <th data-options="field:'name'" width="220">Name</th>
                  <th data-options="field:'names'" width="220">File</th>
                
                   <th data-options="field:'created'" width="150">Created</th>
            </tr>
        </thead>
    </table>








<script type="text/javascript" src="<?= base_url(); ?>js/jquery.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>js/jquery.easyui.min.js"></script>