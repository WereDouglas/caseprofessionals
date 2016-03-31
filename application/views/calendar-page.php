<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>assets/css/bootstrap-responsive.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fullcalendar.css" />

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/chosen.css" />
<!--fonts-->
<?php require_once(APPPATH . 'views/css-page.php'); ?>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace.min.css" />
<style>
    select {
        width: 100%;
        background-color: #fff;
        border: 1px solid #ccc;
    }
</style>
<div class="page-content">
    <div class="page-header position-relative">
        <h3> Schedules </h3>

    </div><!--/.page-header-->
    <div class="row-fluid">
        <div class="span12">
            <!--PAGE CONTENT BEGINS-->

            <div class="row-fluid">
                <div class="span9">


                    <div id="calendar"></div>
                </div>

                <div class="span3">
                    <div class="widget-box transparent">
                        <div class="widget-header">
                            <h4>Add schedule</h4>
                        </div>

                        <div class="widget-main">
                            <div id="external-events">
                                <form  enctype="multipart/form-data"  action='<?= base_url(); ?>index.php/schedule/add'  method="post">
                                    <div class="span12">

                                        <div class="row-fluid">
                                            <label for="timepicker1">Date</label>
                                        </div>
                                        <div class="control-group">
                                            <div class="row-fluid input-append">
                                                <input name="day" class="span10 date-picker" id="id-date-picker-1" type="text" data-date-format="dd-mm-yyyy" />
                                                <span class="add-on">
                                                    <i class="icon-calendar"></i>
                                                </span>
                                            </div>
                                        </div>  
                                        <div class="row-fluid">
                                            <label for="form-field-select-4">Choose Attendees</label>

                                            <select multiple="multiple" name="attend[]"  data-placeholder="Choose attendees...">
                                                <option value="" />
                                                <?php
                                                if (is_array($users) && count($users)) {
                                                    foreach ($users as $loop) {
                                                        ?>  
                                                        <option value="<?php echo $loop->id; ?>" /><?php echo $loop->name; ?>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <label>
                                            <input name="trig" type="checkbox" />
                                            <span class="lbl"> Notify parties ?</span>
                                        </label>

                                        <div class="row-fluid">
                                            <label for="timepicker1">Start Time</label>
                                        </div>

                                        <div class="control-group">
                                            <div class="input-append bootstrap-timepicker">
                                                <input id="timepicker1" name="start" type="text" class="input-small" />
                                                <span class="add-on">
                                                    <i class="icon-time"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="row-fluid">
                                            <label for="timepicker1">End Time</label>
                                        </div>

                                        <div class="control-group">
                                            <div class="input-append bootstrap-timepicker">
                                                <input id="timepicker2" name="end" type="text" class="input-small" />
                                                <span class="add-on">
                                                    <i class="icon-time"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label" for="form-field-1">Number of days</label>
                                            <div class="control-group">

                                                <input class="form-control" type="text" name="days" value="1"  />

                                            </div>

                                            <div class="form-group">        
                                                <textarea  class="form-control" name="details" class="" placeholder="details" ></textarea>
                                            </div>
                                            <div class="control-group">
                                                <label>Priority</label>
                                                <select id="priority" name="priority" >                                                         
                                                    <option value="High" >High</option>
                                                    <option value="Medium" >Medium</option>
                                                    <option value="Low">Low</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn-primary btn btn-small">
                                                Add

                                            </button>
                                            <button type="reset" class="btn btn-small">

                                                Reset
                                            </button>

                                        </div>
                                </form> 


                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--PAGE CONTENT ENDS-->
        </div><!--/.span-->
    </div><!--/.row-fluid-->
</div><!--/.page-content-->


<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-small btn-inverse">
    <i class="icon-double-angle-up icon-only bigger-110"></i>
</a>

<!--basic scripts-->

<!--[if !IE]>-->

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

<!--<![endif]-->

<!--[if IE]>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<![endif]-->

<!--[if !IE]>-->

<script type="text/javascript">
    window.jQuery || document.write("<script src='<?php echo base_url(); ?>assets/js/jquery-2.0.3.min.js'>" + "<" + "/script>");</script>

<!--<![endif]-->

<!--[if IE]>
<script type="text/javascript">
window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

<script type="text/javascript">
    if ("ontouchend" in document)
        document.write("<script src='<?php echo base_url(); ?>assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");</script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>

<!--page specific plugin scripts-->

<script src="<?php echo base_url(); ?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/chosen.jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/fuelux/fuelux.spinner.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/fullcalendar.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date-time/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date-time/daterangepicker.min.js"></script>
<!--ace scripts-->

<script src="<?php echo base_url(); ?>assets/js/ace-elements.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/ace.min.js"></script>


<script src="<?php echo base_url(); ?>assets/js/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.knob.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.autosize-min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.inputlimiter.1.3.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.maskedinput.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-tag.min.js"></script>




<!--inline scripts related to this page-->

<script type="text/javascript">
    $(function () {
        /* initialize the external events
         -----------------------------------------------------------------*/

        $('#external-events div.external-event').each(function () {

            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
                title: $.trim($(this).text()) // use the element's text as the event title
            };
            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject);
            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true, // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });
        });
        /* initialize the calendar
         -----------------------------------------------------------------*/

        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var calendar = $('#calendar').fullCalendar({
            buttonText: {
                prev: '<i class="icon-chevron-left"></i>',
                next: '<i class="icon-chevron-right"></i>'
            },
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: [
<?php
if (is_array($sch)) {
    foreach ($sch as $loop) {
        $mydate = $loop->dated;
        $prior = $loop->priority;
        $days = $loop->days;
         
         $informations ='START:'. $loop->starts.' ';
        $informations .= $loop->detail.' ';
        
        $d = (int) date("d", strtotime($mydate));
        $m = (int) date("m", strtotime($mydate));
        $y = (int) date("Y", strtotime($mydate));

        switch ($prior) {
            case High:
                $className = 'label-important';
                break;
            case Medium:
                $className = 'label-success';
                break;
            case Low:
                $className = 'label-grey';
                break;
        }

        if (is_array($att)) {
            foreach ($att as $val) {
                if ($val->scheduleID == $loop->id) {                  

                    if (is_array($users)) {
                        foreach ($users as $user) {
                            if ($user->id == $val->userID) {
                                $information .= 'Att:';
                                $information .= $user->name.' ';
                            }
                        }
                    }
                }
            }
        }
        ?>
                        {
                            title: '<?php echo $informations; ?>',
                            start: new Date(<?php echo $y; ?>, <?php echo $m; ?>, <?php echo $d; ?> -<?php echo $days; ?>),
                            className: '<?php echo $className; ?>'

                        },
        <?php
    }
}
?>]
            ,
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar !!!
            drop: function (date, allDay) { // this function is called when something is dropped

                // retrieve the dropped element's stored Event Object
                var originalEventObject = $(this).data('eventObject');
                var $extraEventClass = $(this).attr('data-class');
                // we need to copy it, so that multiple events don't have a reference to the same object
                var copiedEventObject = $.extend({}, originalEventObject);
                // assign it the date that was reported
                copiedEventObject.start = date;
                copiedEventObject.allDay = allDay;
                if ($extraEventClass)
                    copiedEventObject['className'] = [$extraEventClass];
                // render the event on the calendar
                // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
                $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }

            }
            ,
            selectable: true,
            selectHelper: true,
            eventClick: function (calEvent, jsEvent, view) {

                var form = $("<form class='form-inline'><label>Schedule Information</label></form>");
                form.append("<hr><label>" + calEvent.title + "</label> ");
                form.append("");
                var div = bootbox.dialog(form,
                        [
                            {
                                "label": " Close",
                                "class": "btn-small"
                            }
                        ]
                        ,
                        {
                            // prompts need a few extra options
                            "onEscape": function () {
                                div.modal("hide");
                            }
                        }
                );
                form.on('submit', function () {
                    calEvent.title = form.find("input[type=text]").val();
                    calendar.fullCalendar('updateEvent', calEvent);
                    div.modal("hide");
                    return false;
                });
                //console.log(calEvent.id);
                //console.log(jsEvent);
                //console.log(view);

                // change the border color just for fun
                //$(this).css('border-color', 'red');

            }

        });
    })
</script>
<script type="text/javascript">
    $(function () {
        $('#id-disable-check').on('click', function () {
            var inp = $('#form-input-readonly').get(0);
            if (inp.hasAttribute('disabled')) {
                inp.setAttribute('readonly', 'true');
                inp.removeAttribute('disabled');
                inp.value = "This text field is readonly!";
            } else {
                inp.setAttribute('disabled', 'disabled');
                inp.removeAttribute('readonly');
                inp.value = "This text field is disabled!";
            }
        });
        $(".chzn-select").chosen();
        $('[data-rel=tooltip]').tooltip({container: 'body'});
        $('[data-rel=popover]').popover({container: 'body'});
        $('textarea[class*=autosize]').autosize({append: "\n"});
        $('textarea[class*=limited]').each(function () {
            var limit = parseInt($(this).attr('data-maxlength')) || 100;
            $(this).inputlimiter({
                "limit": limit,
                remText: '%n character%s remaining...',
                limitText: 'max allowed : %n.'
            });
        });
        $.mask.definitions['~'] = '[+-]';
        $('.input-mask-date').mask('99/99/9999');
        $('.input-mask-phone').mask('(999) 999-9999');
        $('.input-mask-eyescript').mask('~9.99 ~9.99 999');
        $(".input-mask-product").mask("a*-999-a999", {placeholder: " ", completed: function () {
                alert("You typed the following: " + this.val());
            }});
        $("#input-size-slider").css('width', '200px').slider({
            value: 1,
            range: "min",
            min: 1,
            max: 6,
            step: 1,
            slide: function (event, ui) {
                var sizing = ['', 'input-mini', 'input-small', 'input-medium', 'input-large', 'input-xlarge', 'input-xxlarge'];
                var val = parseInt(ui.value);
                $('#form-field-4').attr('class', sizing[val]).val('.' + sizing[val]);
            }
        });
        $("#input-span-slider").slider({
            value: 1,
            range: "min",
            min: 1,
            max: 11,
            step: 1,
            slide: function (event, ui) {
                var val = parseInt(ui.value);
                $('#form-field-5').attr('class', 'span' + val).val('.span' + val).next().attr('class', 'span' + (12 - val)).val('.span' + (12 - val));
            }
        });
        $("#slider-range").css('height', '200px').slider({
            orientation: "vertical",
            range: true,
            min: 0,
            max: 100,
            values: [17, 67],
            slide: function (event, ui) {
                var val = ui.values[$(ui.handle).index() - 1] + "";
                if (!ui.handle.firstChild) {
                    $(ui.handle).append("<div class='tooltip right in' style='display:none;left:15px;top:-8px;'><div class='tooltip-arrow'></div><div class='tooltip-inner'></div></div>");
                }
                $(ui.handle.firstChild).show().children().eq(1).text(val);
            }
        }).find('a').on('blur', function () {
            $(this.firstChild).hide();
        });
        $("#slider-range-max").slider({
            range: "max",
            min: 1,
            max: 10,
            value: 2
        });
        $("#eq > span").css({width: '90%', 'float': 'left', margin: '15px'}).each(function () {
            // read initial values from markup and remove that
            var value = parseInt($(this).text(), 10);
            $(this).empty().slider({
                value: value,
                range: "min",
                animate: true

            });
        });
        $('#id-input-file-1 , #id-input-file-2').ace_file_input({
            no_file: 'No File ...',
            btn_choose: 'Choose',
            btn_change: 'Change',
            droppable: false,
            onchange: null,
            thumbnail: false //| true | large
                    //whitelist:'gif|png|jpg|jpeg'
                    //blacklist:'exe|php'
                    //onchange:''
                    //
        });
        $('#id-input-file-3').ace_file_input({
            style: 'well',
            btn_choose: 'Drop files here or click to choose',
            btn_change: null,
            no_icon: 'icon-cloud-upload',
            droppable: true,
            thumbnail: 'small'
                    //,icon_remove:null//set null, to hide remove/reset button
                    /**,before_change:function(files, dropped) {
                     //Check an example below
                     //or examples/file-upload.html
                     return true;
                     }*/
                    /**,before_remove : function() {
                     return true;
                     }*/
            ,
            preview_error: function (filename, error_code) {
                //name of the file that failed
                //error_code values
                //1 = 'FILE_LOAD_FAILED',
                //2 = 'IMAGE_LOAD_FAILED',
                //3 = 'THUMBNAIL_FAILED'
                //alert(error_code);
            }

        }).on('change', function () {
            //console.log($(this).data('ace_input_files'));
            //console.log($(this).data('ace_input_method'));
        });
        //dynamically change allowed formats by changing before_change callback function
        $('#id-file-format').removeAttr('checked').on('change', function () {
            var before_change
            var btn_choose
            var no_icon
            if (this.checked) {
                btn_choose = "Drop images here or click to choose";
                no_icon = "icon-picture";
                before_change = function (files, dropped) {
                    var allowed_files = [];
                    for (var i = 0; i < files.length; i++) {
                        var file = files[i];
                        if (typeof file === "string") {
                            //IE8 and browsers that don't support File Object
                            if (!(/\.(jpe?g|png|gif|bmp)$/i).test(file))
                                return false;
                        } else {
                            var type = $.trim(file.type);
                            if ((type.length > 0 && !(/^image\/(jpe?g|png|gif|bmp)$/i).test(type))
                                    || (type.length == 0 && !(/\.(jpe?g|png|gif|bmp)$/i).test(file.name))//for android's default browser which gives an empty string for file.type
                                    )
                                continue; //not an image so don't keep this file
                        }

                        allowed_files.push(file);
                    }
                    if (allowed_files.length == 0)
                        return false;
                    return allowed_files;
                }
            } else {
                btn_choose = "Drop files here or click to choose";
                no_icon = "icon-cloud-upload";
                before_change = function (files, dropped) {
                    return files;
                }
            }
            var file_input = $('#id-input-file-3');
            file_input.ace_file_input('update_settings', {'before_change': before_change, 'btn_choose': btn_choose, 'no_icon': no_icon})
            file_input.ace_file_input('reset_input');
        });
        $('#spinner1').ace_spinner({value: 0, min: 0, max: 200, step: 10, btn_up_class: 'btn-info', btn_down_class: 'btn-info'})
                .on('change', function () {
                    //alert(this.value)
                });
        $('#spinner2').ace_spinner({value: 0, min: 0, max: 10000, step: 100, icon_up: 'icon-caret-up', icon_down: 'icon-caret-down'});
        $('#spinner3').ace_spinner({value: 0, min: -100, max: 100, step: 10, icon_up: 'icon-plus', icon_down: 'icon-minus', btn_up_class: 'btn-success', btn_down_class: 'btn-danger'});
        $('.date-picker').datepicker().next().on(ace.click_event, function () {
            $(this).prev().focus();
        });
        $('#id-date-range-picker-1').daterangepicker().prev().on(ace.click_event, function () {
            $(this).next().focus();
        });
        $('#timepicker1').timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false
        })
        $('#timepicker2').timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false
        })

        $('#colorpicker1').colorpicker();
        $('#simple-colorpicker-1').ace_colorpicker();
        $(".knob").knob();
        //we could just set the data-provide="tag" of the element inside HTML, but IE8 fails!
        var tag_input = $('#form-field-tags');
        if (!(/msie\s*(8|7|6)/.test(navigator.userAgent.toLowerCase())))
            tag_input.tag({placeholder: tag_input.attr('placeholder')});
        else {
            //display a textarea for old IE, because it doesn't support this plugin or another one I tried!
            tag_input.after('<textarea id="' + tag_input.attr('id') + '" name="' + tag_input.attr('name') + '" rows="3">' + tag_input.val() + '</textarea>').remove();
            //$('#form-field-tags').autosize({append: "\n"});
        }


        /////////
        $('#modal-form input[type=file]').ace_file_input({
            style: 'well',
            btn_choose: 'Drop files here or click to choose',
            btn_change: null,
            no_icon: 'icon-cloud-upload',
            droppable: true,
            thumbnail: 'large'
        })

        //chosen plugin inside a modal will have a zero width because the select element is originally hidden
        //and its width cannot be determined.
        //so we set the width after modal is show
        $('#modal-form').on('show', function () {
            $(this).find('.chzn-container').each(function () {
                $(this).find('a:first-child').css('width', '200px');
                $(this).find('.chzn-drop').css('width', '210px');
                $(this).find('.chzn-search input').css('width', '200px');
            });
        })
        /**
         //or you can activate the chosen plugin after modal is shown
         //this way select element has a width now and chosen works as expected
         $('#modal-form').on('shown', function () {
         $(this).find('.modal-chosen').chosen();
         })
         */

    });
</script>
</body>
</html>


</body>
</html>

</body>
</html>
