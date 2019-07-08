<?php
	/*
	* Template Name: Calendar Page
	* Template page for Calendar Page 	
	*/

// get_header();
global $current_user;
$user = wp_get_current_user();
get_header( 'dashboard' );

?>


<script type="text/javascript" src="../calendar-assets/bootstrap-year-calendar.js"></script>
<script type="text/javascript" src="../calendar-assets/bootstrap-year-calendar.min.js"></script>
<link href="../calendar-assets/bootstrap-year-calendar.css" rel="stylesheet">
<link href="../calendar-assets/bootstrap-year-calendar.min.css" rel="stylesheet">



<div id="main-content" class="oncommonsidebar">

	<div class="inner-placeholder">
		<div class="inner-main-content">
			<div data-provide="calendar"></div>
		</div>
	</div>


<script type="text/javascript">

	
function editEvent(event) {
    jQuery('#event-modal input[name="event-index"]').val(event ? event.id : '');
    jQuery('#event-modal input[name="event-name"]').val(event ? event.name : '');
    jQuery('#event-modal input[name="event-location"]').val(event ? event.location : '');
    jQuery('#event-modal input[name="event-start-date"]').datepicker('update', event ? event.startDate : '');
    jQuery('#event-modal input[name="event-end-date"]').datepicker('update', event ? event.endDate : '');
    jQuery('#event-modal').modal();
}

function deleteEvent(event) {
    var dataSource = jQuery('#calendar').data('calendar').getDataSource();

    for(var i in dataSource) {
        if(dataSource[i].id == event.id) {
            dataSource.splice(i, 1);
            break;
        }
    }
    
    jQuery('#calendar').data('calendar').setDataSource(dataSource);
}

function saveEvent() {
    var event = {
        id: jQuery('#event-modal input[name="event-index"]').val(),
        name: jQuery('#event-modal input[name="event-name"]').val(),
        location: jQuery('#event-modal input[name="event-location"]').val(),
        startDate: jQuery('#event-modal input[name="event-start-date"]').datepicker('getDate'),
        endDate: jQuery('#event-modal input[name="event-end-date"]').datepicker('getDate')
    }
    
    var dataSource = jQuery('#calendar').data('calendar').getDataSource();

    if(event.id) {
        for(var i in dataSource) {
            if(dataSource[i].id == event.id) {
                dataSource[i].name = event.name;
                dataSource[i].location = event.location;
                dataSource[i].startDate = event.startDate;
                dataSource[i].endDate = event.endDate;
            }
        }
    }
    else
    {
        var newId = 0;
        for(var i in dataSource) {
            if(dataSource[i].id > newId) {
                newId = dataSource[i].id;
            }
        }
        
        newId++;
        event.id = newId;
    
        dataSource.push(event);
    }
    
    jQuery('#calendar').data('calendar').setDataSource(dataSource);
    jQuery('#event-modal').modal('hide');
}

jQuery(function() {
    var currentYear = new Date().getFullYear();

    jQuery('#calendar').calendar({ 
        enableContextMenu: true,
        enableRangeSelection: true,
        contextMenuItems:[
            {
                text: 'Update',
                click: editEvent
            },
            {
                text: 'Delete',
                click: deleteEvent
            }
        ],
        selectRange: function(e) {
            editEvent({ startDate: e.startDate, endDate: e.endDate });
        },
        mouseOnDay: function(e) {
            if(e.events.length > 0) {
                var content = '';
                
                for(var i in e.events) {
                    content += '<div class="event-tooltip-content">'
                                    + '<div class="event-name" style="color:' + e.events[i].color + '">' + e.events[i].name + '</div>'
                                    + '<div class="event-location">' + e.events[i].location + '</div>'
                                + '</div>';
                }
            
                jQuery(e.element).popover({ 
                    trigger: 'manual',
                    container: 'body',
                    html:true,
                    content: content
                });
                
                jQuery(e.element).popover('show');
            }
        },
        mouseOutDay: function(e) {
            if(e.events.length > 0) {
                jQuery(e.element).popover('hide');
            }
        },
        dayContextMenu: function(e) {
            jQuery(e.element).popover('hide');
        },
        dataSource: [
            {
                id: 0,
                name: 'Google I/O',
                location: 'San Francisco, CA',
                startDate: new Date(currentYear, 4, 28),
                endDate: new Date(currentYear, 4, 29)
            },
            {
                id: 1,
                name: 'Microsoft Convergence',
                location: 'New Orleans, LA',
                startDate: new Date(currentYear, 2, 16),
                endDate: new Date(currentYear, 2, 19)
            },
            {
                id: 2,
                name: 'Microsoft Build Developer Conference',
                location: 'San Francisco, CA',
                startDate: new Date(currentYear, 3, 29),
                endDate: new Date(currentYear, 4, 1)
            },
            {
                id: 3,
                name: 'Apple Special Event',
                location: 'San Francisco, CA',
                startDate: new Date(currentYear, 8, 1),
                endDate: new Date(currentYear, 8, 1)
            },
            {
                id: 4,
                name: 'Apple Keynote',
                location: 'San Francisco, CA',
                startDate: new Date(currentYear, 8, 9),
                endDate: new Date(currentYear, 8, 9)
            },
            {
                id: 5,
                name: 'Chrome Developer Summit',
                location: 'Mountain View, CA',
                startDate: new Date(currentYear, 10, 17),
                endDate: new Date(currentYear, 10, 18)
            },
            {
                id: 6,
                name: 'F8 2015',
                location: 'San Francisco, CA',
                startDate: new Date(currentYear, 2, 25),
                endDate: new Date(currentYear, 2, 26)
            },
            {
                id: 7,
                name: 'Yahoo Mobile Developer Conference',
                location: 'New York',
                startDate: new Date(currentYear, 7, 25),
                endDate: new Date(currentYear, 7, 26)
            },
            {
                id: 8,
                name: 'Android Developer Conference',
                location: 'Santa Clara, CA',
                startDate: new Date(currentYear, 11, 1),
                endDate: new Date(currentYear, 11, 4)
            },
            {
                id: 9,
                name: 'LA Tech Summit',
                location: 'Los Angeles, CA',
                startDate: new Date(currentYear, 10, 17),
                endDate: new Date(currentYear, 10, 17)
            }
        ]
    });
    
    jQuery('#save-event').click(function() {
        saveEvent();
    });
});	
</script>
<?php

get_footer('dashboard');
