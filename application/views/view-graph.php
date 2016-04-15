<?php require_once(APPPATH . 'views/css-page.php'); ?>
<section class="content-header">
    <h3>Consolidated  Reports   </h3> 
    <hr>
    <?php
    $months = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');

    $year = date('Y');
    if (is_array($credits) && count($credits)) {


        $allcredits = array();
        foreach ($months as $num => $name) {
            $obj = new stdClass();
            $obj->name = $name;
            $total = 0;
            //   echo $name . ' ' . $total . '<br>';
            foreach ($credits as $loop) {
                if (date("m", strtotime($loop->created)) == $num) {
                    $number = tofloat($loop->total);
                    $total += $number;
                }
                $obj->total = $total;
            }
            array_push($allcredits, $obj);
        }
       // echo json_encode($allcredits) . '<br>';
    }
    
    
    if (is_array($debits) && count($debits)) {


        $alldebits = array();
        foreach ($months as $num => $name) {
            $obj = new stdClass();
            $obj->name = $name;
            $total = 0;
            //   echo $name . ' ' . $total . '<br>';
            foreach ($debits as $loop) {
                if (date("m", strtotime($loop->created)) == $num) {
                    $number = tofloat($loop->total);
                    $total += $number;
                }
                $obj->total = $total;
            }
            array_push($alldebits, $obj);
        }

      //  echo json_encode($alldebits);
    }
    
      if (is_array($schedules) && count($schedules)) {

        $allsch = array();
        foreach ($months as $num => $name) {
            $obj = new stdClass();
            $obj->month = $name;
            $total = 0;
            //   echo $name . ' ' . $total . '<br>';
            foreach ($schedules as $loop) {
                if (date("m", strtotime($loop->created)) == $num) {
                   
                    $total += 1;
                }
                $obj->times = $total;
            }
            array_push($allsch, $obj);
        }

    //   echo json_encode($allsch);
    }

    function tofloat($num) {
        $dotPos = strrpos($num, '.');
        $commaPos = strrpos($num, ',');
        $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos :
                ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);

        if (!$sep) {
            return floatval(preg_replace("/[^0-9]/", "", $num));
        }

        return floatval(
                preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
                preg_replace("/[^0-9]/", "", substr($num, $sep + 1, strlen($num)))
        );
    }
    ?>
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->

    <div class="row-fluid">
         <div id="container5"  style="min-width: 310px; height: 300px; margin: 0 auto"></div>
        <div id="container"  style="min-width: 310px; height: 300px; margin: 0 auto"></div>
        <div id="container2" style="height: 300px"></div>
        <div id="container3" style="height: 300px"></div>

    </div>


</section><!-- /.content -->
<script type="text/javascript">
    $(document).ready(function ()
    {
    $.post("<?php echo base_url() ?>index.php/consolidate/budgets", {posts: ""}
    , function (response) {
    $('#loading').hide();
    setTimeout(finishAjax('loading', escape(response)), 200);
    }); //end change

    $("#generate").on("click", function (e) {

    var period = $("#period").val();
    var department = $("#department").val();
    var unit = $("#unit").val();
    var initiative = $("#initiative").val();
    var account = $("#account").val();
    var by = encodeURIComponent($("#by").val());
    $.post("<?php echo base_url() ?>index.php/consolidate/generate", {period: period, department: department, unit: unit, initiative: initiative, account: account, by: by}
    , function (response) {
    $('#loading').hide();
    setTimeout(finishAjax('loading', escape(response)), 200);
    }); //end change

    })
            function finishAjax(id, response) {
            $('#' + id).html(unescape(response));
            $('#' + id).fadeIn();
            }

    });</script>
<script>
    //Script for getting the dynamic values from database using jQuery and AJAX
    $(document).ready(function () {
    $('#department').change(function () {

    var form_data = {
    name: $('#department').val()
    };
    $.ajax({
    url: "<?php echo base_url() . "index.php/unit/where"; ?>",
            type: 'POST',
            dataType: 'json',
            data: form_data,
            success: function (msg) {
            var sc = '';
            $.each(msg, function (key, val) {
            sc += '<option value="' + val.name + '">' + val.name + '</option>';
            });
            $("#unit option").remove();
            $("#unit").append(sc);
            }
    });
    });
    $('#objective').change(function () {

    var form_data = {
    name: $('#objective').val()
    };
    $.ajax({
    url: "<?php echo base_url() . "index.php/initiative/where"; ?>",
            type: 'POST',
            dataType: 'json',
            data: form_data,
            success: function (msg) {
            var sc = '';
            var pc = '';
            $.each(msg, function (key, val) {
            sc += '<option value="' + val.details + '">' + val.details + '</option>';
            pc = val.values;
            });
            $("#initiative option").remove();
            $("#initiative").append(sc);
            $("#performance").val("");
            $("#performance").val(pc);
            }
    });
    });
    $('#category').change(function () {

    var form_data = {
    name: $('#category').val()
    };
    $.ajax({
    url: "<?php echo base_url() . "index.php/reporting/where"; ?>",
            type: 'POST',
            dataType: 'json',
            data: form_data,
            success: function (msg) {
            var sc = '';
            $.each(msg, function (key, val) {
            sc += '<option value="' + val.name + '">' + val.name + '</option>';
            });
            $("#line option").remove();
            $("#line").append(sc);
            }
    });
    });
    $('#line').change(function () {

    var form_data = {
    name: $('#line').val()
    };
    $.ajax({
    url: "<?php echo base_url() . "index.php/subline/where"; ?>",
            type: 'POST',
            dataType: 'json',
            data: form_data,
            success: function (msg) {
            var sc = '';
            $.each(msg, function (key, val) {
            sc += '<option value="' + val.name + '">' + val.name + '</option>';
            });
            $("#subline option").remove();
            $("#subline").append(sc);
            }
    });
    });
    $('#subline').change(function () {

    var form_data = {
    name: $('#subline').val()
    };
    $.ajax({
    url: "<?php echo base_url() . "index.php/account/where"; ?>",
            type: 'POST',
            dataType: 'json',
            data: form_data,
            success: function (msg) {
            var sc = '';
            $.each(msg, function (key, val) {
            sc += '<option value="' + val.number + '">' + val.name + " " + val.number + '</option>';
            });
            $("#account option").remove();
            $("#account").append(sc);
            }
    });
    });
    $('#currency').change(function () {

    var form_data = {
    name: $('#currency').val()
    };
    $.ajax({
    url: "<?php echo base_url() . "index.php/rate/where"; ?>",
            type: 'POST',
            dataType: 'json',
            data: form_data,
            success: function (msg) {
            var sc = '';
            $.each(msg, function (key, val) {
            sc = val.rate;
            });
            console.log(sc);
            $("#rate").text("");
            $("#rate").val(sc);
            }
    });
    });
    $('#price').blur(function () {
    var priceL = $("#price").val() * $("#rate").val();
    $("#priceL").val(priceL);
    });
    $('#period').change(function () {

    var form_data = {
    period: $('#period').val()
    };
    $.ajax({
    url: "<?php echo base_url() . "index.php/period/where"; ?>",
            type: 'POST',
            dataType: 'json',
            data: form_data,
            success: function (msg) {
            var startp = '';
            var endp = '';
            $.each(msg, function (key, val) {
            startp = val.start;
            endp = val.end;
            });
            $("#endp").val(endp);
            $("#startp").val(startp);
            }
    });
    });
    });</script>

<script type="text/javascript">
    $(function () {
    $('#start').datetimepicker({
    format: 'YYYY-MM-DD'
    });
    $('#end').datetimepicker({
    format: 'YYYY-MM-DD'
    });
    });</script>

<script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery-2.0.3.min.js"></script>
<script type="text/javascript">
    $(function () {
    $('#container').highcharts({
    chart: {
    zoomType: 'xy'
    },
            title: {
            text: 'MONTHLY SCHEDULE RATE'
            },
            subtitle: {
            text: ''
            },
            xAxis: [{
            categories: [<?php   foreach ($allsch as $ap) {  ?>
                                '<?php echo $ap->month; ?>',
                    <?php }  ?> ' '],
                    crosshair: true
            }],
            yAxis: [{// Primary yAxis
            labels: {
            format: '{value}count',
                    style: {
                    color: Highcharts.getOptions().colors[1]
                    }
            },
                    title: {
                    text: 'count',
                            style: {
                            color: Highcharts.getOptions().colors[1]
                            }
                    }
            }, {// Secondary yAxis
            title: {
            text: 'count',
                    style: {
                    color: Highcharts.getOptions().colors[0]
                    }
            },
                    labels: {
                    format: '{value}',
                            style: {
                            color: Highcharts.getOptions().colors[0]
                            }
                    },
                    opposite: true
            }],
            tooltip: {
            shared: true
            },
            legend: {
            layout: 'vertical',
                    align: 'left',
                    x: 120,
                    verticalAlign: 'top',
                    y: 100,
                    floating: true,
                    backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
            },
            series: [ {
            name: 'Meetings',
                    type: 'spline',
                    data: [<?php foreach ($allsch as $aps) {  ?>
                        <?php echo $aps->times; ?>, <?php } ?> 0],
                    tooltip: {
                    valueSuffix: 'count'
                    }
            }]
    });
     $('#container5').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: 'CREDIT AND DEBITS TRANSACTIONS'
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            categories: [<?php   foreach ($allcredits as $ap) {  ?>
                                '<?php echo $ap->name; ?>',
                    <?php }  ?> ' ']
        },
        yAxis: {
            title: {
                text: 'Shs'
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: [{
            name: 'CREDIT TRANSACTIONS',
            data: [<?php   foreach ($allcredits as $ap) {  ?>
                                <?php echo $ap->total; ?>,
                    <?php }  ?> 0]
        }, {
            name: 'DEBIT TRANSACTIONS',
            data: [<?php   foreach ($alldebits as $ap) {  ?>
                                <?php echo $ap->total; ?>,
                    <?php }  ?>  0]
        }]
    });
    });
</script>

<script type="text/javascript">
    $(function () {
    $('#container2').highcharts({
    chart: {
    type: 'column',
            options3d: {
            enabled: true,
                    alpha: 15,
                    beta: 15,
                    viewDistance: 25,
                    depth: 40
            },
            marginTop: 80,
            marginRight: 40
    },
            title: {
            text: 'Total budgets per department'
            },
            xAxis: {
            categories: ['Technology', 'Revenue', 'accounting', 'Legal', 'Repairs']
            },
            yAxis: {
            allowDecimals: false,
                    min: 0,
                    title: {
                    text: 'Amount in shs'
                    }
            },
            tooltip: {
            headerFormat: '<b>{point.key}</b><br>',
                    pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: {point.y} / {point.stackTotal}'
            },
            plotOptions: {
            column: {
            stacking: 'normal',
                    depth: 40
            }
            },
            series: [{
            name: 'ICT',
                    data: [5, 3, 4, 7, 2],
                    stack: 'male'
            }, {
            name: 'Legal',
                    data: [3, 4, 4, 2, 5],
                    stack: 'male'
            }, {
            name: 'HUMAN_RESOURCES & ADMIN',
                    data: [2, 5, 6, 2, 1],
                    stack: 'female'
            }, {
            name: 'INTERNAL AUDIT ',
                    data: [3, 0, 4, 4, 3],
                    stack: 'female'
            }]
    });
    });</script>
<script type="text/javascript">
    $(function () {
    $('#container3').highcharts({
    chart: {
    type: 'pie',
            options3d: {
            enabled: true,
                    alpha: 45
            }
    },
            title: {
            text: 'Department expenditure'
            },
            subtitle: {
            text: 'reports per department'
            },
            plotOptions: {
            pie: {
            innerSize: 100,
                    depth: 45
            }
            },
            series: [{
            name: 'Department',
                    data: [
                    ['ICT', 8],
                    ['Legal', 3],
                    ['Broadcasting', 10],
                    ['INTERNAL AUDIT ', 6],
                    ['HUMAN_RESOURCES & ADMIN', 8],
                    ['COMPETITION & CONSUMERAFFAIRS ', 4]

                    ]
            }]
    });
    });</script>

<script src="<?= base_url(); ?>/js/highcharts.js"></script>
<script src="<?= base_url(); ?>js/highcharts-3d.js"></script>
<script src="<?= base_url(); ?>/js/modules/exporting.js"></script>