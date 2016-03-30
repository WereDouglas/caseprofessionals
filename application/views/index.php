  <?php require_once(APPPATH . 'views/header.php'); ?>
<link rel="stylesheet" href="<?= base_url();?>assets/css/fullcalendar.css" />

            <div class="main-content">
               

                <div class="page-content">
                   
                    <div class="row-fluid">
                        <div class="span12">
                            <!--PAGE CONTENT BEGINS-->

                            <div class="alert alert-block alert-success">
                                <button type="button" class="close" data-dismiss="alert">
                                    <i class="icon-remove"></i>
                                </button>

                                <i class="icon-ok green"></i>

                                Welcome to
                                <strong class="green">
                                    Epi-track
                                    <small>(v1.1.2)</small>
                                </strong>
                                ,
                             your events are as follows 
                            </div>

                            <div class="space-6"></div>
<div class="row-fluid">
						<div class="span12">
							<!--PAGE CONTENT BEGINS-->

							<div class="row-fluid">
								<div class="span9">
									<div class="space"></div>

									<div id="calendar"></div>
								</div>

								<div class="span3">
									<div class="widget-box transparent">
										<div class="widget-header">
											<h4>Draggable events</h4>
										</div>

									    <div class="row-fluid">
                                <div class="span7 infobox-container">
                                    <div class="infobox infobox-green  ">
                                        <div class="infobox-icon">
                                            <i class="icon-comments"></i>
                                        </div>

                                        <div class="infobox-data">
                                            <span class="infobox-data-number">32</span>
                                            <div class="infobox-content">comments + 2 reviews</div>
                                        </div>
                                        <div class="stat stat-success">8%</div>
                                    </div>

                                    <div class="infobox infobox-blue  ">
                                        <div class="infobox-icon">
                                            <i class="icon-twitter"></i>
                                        </div>

                                        <div class="infobox-data">
                                            <span class="infobox-data-number">11</span>
                                            <div class="infobox-content">new followers</div>
                                        </div>

                                        <div class="badge badge-success">
                                            +32%
                                            <i class="icon-arrow-up"></i>
                                        </div>
                                    </div>

                                    <div class="infobox infobox-pink  ">
                                        <div class="infobox-icon">
                                            <i class="icon-shopping-cart"></i>
                                        </div>

                                        <div class="infobox-data">
                                            <span class="infobox-data-number">8</span>
                                            <div class="infobox-content">new orders</div>
                                        </div>
                                        <div class="stat stat-important">+4%</div>
                                    </div>

                                    <div class="infobox infobox-red  ">
                                        <div class="infobox-icon">
                                            <i class="icon-beaker"></i>
                                        </div>

                                        <div class="infobox-data">
                                            <span class="infobox-data-number">7</span>
                                            <div class="infobox-content">experiments</div>
                                        </div>
                                    </div>

                                    <div class="infobox infobox-orange2  ">
                                        <div class="infobox-chart">
                                            <span class="sparkline" data-values="196,128,202,177,154,94,100,170,224"></span>
                                        </div>

                                        <div class="infobox-data">
                                            <span class="infobox-data-number">6,251</span>
                                            <div class="infobox-content">pageviews</div>
                                        </div>

                                        <div class="badge badge-success">
                                            7.2%
                                            <i class="icon-arrow-up"></i>
                                        </div>
                                    </div>

                                    <div class="infobox infobox-blue2  ">
                                        <div class="infobox-progress">
                                            <div class="easy-pie-chart percentage" data-percent="42" data-size="46">
                                                <span class="percent">42</span>
                                                %
                                            </div>
                                        </div>

                                        <div class="infobox-data">
                                            <span class="infobox-text">traffic used</span>

                                            <div class="infobox-content">
                                                <span class="bigger-110">~</span>
                                                58GB remaining
                                            </div>
                                        </div>
                                    </div>

                                    <div class="space-6"></div>

                                 
                                </div>

                                <div class="vspace"></div>

                            </div><!--/row-->
									</div>
								</div>
							</div>

							<!--PAGE CONTENT ENDS-->
						</div><!--/.span-->
					</div><!--/.row-fluid-->
                        

                            <div class="hr hr32 hr-dotted"></div>


        
                            <!--PAGE CONTENT ENDS-->
                        </div><!--/.span-->
                    </div><!--/.row-fluid-->
                </div><!--/.page-content-->

                <div class="ace-settings-container" id="ace-settings-container">
                    <div class="btn btn-app btn-mini btn-warning ace-settings-btn" id="ace-settings-btn">
                        <i class="icon-cog bigger-150"></i>
                    </div>

                    <div class="ace-settings-box" id="ace-settings-box">
                        <div>
                            <div class="pull-left">
                                <select id="skin-colorpicker" class="hide">
                                    <option data-class="default" value="#438EB9" />#438EB9
                                    <option data-class="skin-1" value="#222A2D" />#222A2D
                                    <option data-class="skin-2" value="#C6487E" />#C6487E
                                    <option data-class="skin-3" value="#D0D0D0" />#D0D0D0
                                </select>
                            </div>
                            <span>&nbsp; Choose Skin</span>
                        </div>

                        <div>
                            <input type="checkbox" class="ace-checkbox-2" id="ace-settings-header" />
                            <label class="lbl" for="ace-settings-header"> Fixed Header</label>
                        </div>

                        <div>
                            <input type="checkbox" class="ace-checkbox-2" id="ace-settings-sidebar" />
                            <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                        </div>

                        <div>
                            <input type="checkbox" class="ace-checkbox-2" id="ace-settings-breadcrumbs" />
                            <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                        </div>

                        <div>
                            <input type="checkbox" class="ace-checkbox-2" id="ace-settings-rtl" />
                            <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                        </div>
                    </div>
                </div><!--/#ace-settings-container-->
            </div><!--/.main-content-->
      
  <?php require_once(APPPATH . 'views/footer.php'); ?>
            <script src="<?=base_url();?>assets/js/fullcalendar.min.js"></script>
<script type="text/javascript">
			$(function() {

/* initialize the external events
	-----------------------------------------------------------------*/

	$('#external-events div.external-event').each(function() {

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
			revert: true,      // will cause the event to go back to its
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
		{
			title: 'All Day Event',
			start: new Date(y, m, 1),
			className: 'label-important'
		},
		{
			title: 'Long Event',
			start: new Date(y, m, d-5),
			end: new Date(y, m, d-2),
			className: 'label-success'
		},
		{
			title: 'Some Event',
			start: new Date(y, m, d-3, 16, 0),
			allDay: false
		}]
		,
		editable: true,
		droppable: true, // this allows things to be dropped onto the calendar !!!
		drop: function(date, allDay) { // this function is called when something is dropped
		
			// retrieve the dropped element's stored Event Object
			var originalEventObject = $(this).data('eventObject');
			var $extraEventClass = $(this).attr('data-class');
			
			
			// we need to copy it, so that multiple events don't have a reference to the same object
			var copiedEventObject = $.extend({}, originalEventObject);
			
			// assign it the date that was reported
			copiedEventObject.start = date;
			copiedEventObject.allDay = allDay;
			if($extraEventClass) copiedEventObject['className'] = [$extraEventClass];
			
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
		select: function(start, end, allDay) {
			
			bootbox.prompt("New Event Title:", function(title) {
				if (title !== null) {
					calendar.fullCalendar('renderEvent',
						{
							title: title,
							start: start,
							end: end,
							allDay: allDay
						},
						true // make the event "stick"
					);
				}
			});
			

			calendar.fullCalendar('unselect');
			
		}
		,
		eventClick: function(calEvent, jsEvent, view) {

			var form = $("<form class='form-inline'><label>Change event name &nbsp;</label></form>");
			form.append("<input autocomplete=off type=text value='" + calEvent.title + "' /> ");
			form.append("<button type='submit' class='btn btn-small btn-success'><i class='icon-ok'></i> Save</button>");
			
			var div = bootbox.dialog(form,
				[
				{
					"label" : "<i class='icon-trash'></i> Delete Event",
					"class" : "btn-small btn-danger",
					"callback": function() {
						calendar.fullCalendar('removeEvents' , function(ev){
							return (ev._id == calEvent._id);
						})
					}
				}
				,
				{
					"label" : "<i class='icon-remove'></i> Close",
					"class" : "btn-small"
				}
				]
				,
				{
					// prompts need a few extra options
					"onEscape": function(){div.modal("hide");}
				}
			);
			
			form.on('submit', function(){
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