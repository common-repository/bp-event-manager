jQuery(document).ready(function() {
  // Date Picker
  jQuery("#start_date").datepicker({
    dateFormat: "D, M dd, yy",
  }).datepicker("setDate", new Date());
  jQuery('#start_time').timepicker({
    'showDuration': true,
    'timeFormat': ' g:ia '
  });
  //Time Picker
  jQuery("#end_date").datepicker({
    dateFormat: "D, M dd, yy",
  }).datepicker("setDate", new Date());
  jQuery('#end_time').timepicker({
    'showDuration': true,
    'timeFormat': ' g:ia '
  });
  // AJAX Request to create event
  jQuery("#eventform").submit(function(e) {
    e.preventDefault();
  }).validate({
    rules: {
      event_title: {
        required: true,
        //minlength:5
      },
      event_location: {
        required: true,
        //email:true
      },
      start_date: {
        required: true,
        date: true
      },
      start_time: {
        required: true,
      },
      end_date: {
        required: true,
        date: true,
        //greaterThan: "#start_date"   
      },
      end_time: {
        required: true,
        //greaterThan: "#start_time"  
      },

      gdpr_compliant: {
        required: true,
        //greaterThan: "#start_time"  
      },

      
    },
    messages: {
      event_title: {
        required: "Event title is required.",
      },
      event_location: {
        required: "Event Location is required.",
      },
      start_date: {
        required: "Event Start Date is required",
      },
      start_time: {
        required: "Event Start Time is required",
      },
      end_date: {
        required: "Event End Date is required",
        //greaterThan:"Proper dates are required."
      },
      end_time: {
        required: "Event End Time is required",
        //greaterThan:"Proper time is required."
      },
    },
    submitHandler: function(form) {
      jQuery(".create_event").hide();
      jQuery(".showaftersubmit").show();
      //alert(ajax_object.ajax_url); 
      //form.preventDefault();
      var fd = new FormData(jQuery('#eventform')[0]);
      fd.append("uploadImage", jQuery('#uploadImage')[0].files[0]);
      fd.append("event_desc", tinymce.get('event_desc').getContent());
      fd.append("event_location", jQuery('#event_location').val());
      fd.append("event_organizer", jQuery('#event_organizer').val());
      fd.append("event_organizer_url", jQuery('#event_organizer_url').val());
      fd.append("start_date", jQuery('#start_date').val());
      fd.append("start_time", jQuery('#start_time').val());
      fd.append("end_date", jQuery('#end_date').val());
      fd.append("end_time", jQuery('#end_time').val());
      fd.append("evn_group", jQuery('#evn_group').val());
      fd.append("gdpr_compliant", jQuery('#gdpr-compliant').val());
      fd.append("action", 'bpem_event_form_response');
      jQuery.ajax({
        type: 'POST',
        url: ajax_object.ajax_url,
        data: fd,
        processData: false,
        contentType: false,
        success: function(data, textStatus, XMLHttpRequest) {
          console.log(data);
          jQuery(".showaftersubmit").hide();
          jQuery(".bpem_success").show("fast");
          jQuery(".bpem_success").html(data);
          location.reload();
        },
        error: function(MLHttpRequest, textStatus, errorThrown) {
          alert(errorThrown);
        }
      });
      return false;
    },
  });
  jQuery('.bp-events').each(function(index, value) {
    jQuery('#attend_' + index).click(function() {
      jQuery(this).hide();
      jQuery(".ghoom_" + index).show();
      var event_id = jQuery(this).attr('data-id');
      //var user_id   = jQuery(this).attr('data-user-id');
      data = {
        'action': 'bpem_persons_who_attend_event',
        'event_id': event_id,
        //'user_id' : user_id,
      }
      jQuery.post(ajax_object.ajax_url, data, function(response) {
        console.log(response);
        location.reload();
      });
    });
  });
});
jQuery(document).ready(function(jQuery) {
  jQuery(function(jQuery) {
    var pageParts = jQuery("#Upcoming .bp-events");
    var numPages = pageParts.length;
    if (numPages >= 10) {
      var perPage = 10;
      pageParts.slice(perPage).hide();
      jQuery(".event-nav").pagination({
        items: numPages,
        itemsOnPage: perPage,
        prevText: "",
        nextText: "",
        cssStyle: "compact-theme",
        onPageClick: function(pageNum) {
          var start = perPage * (pageNum - 1);
          var end = start + perPage;
          pageParts.hide()
            .slice(start, end).show();
        }
      });
    } //endif
  });
  // Upcoming Pagination ends
  jQuery(function(jQuery) {
    var pageParts = jQuery("#Past .bp-events");
    var numPages = pageParts.length;
    if (numPages >= 10) {
      var perPage = 10;
      pageParts.slice(perPage).hide();
      jQuery("#Past .event-nav").pagination({
        items: numPages,
        itemsOnPage: perPage,
        prevText: "",
        nextText: "",
        cssStyle: "compact-theme",
        onPageClick: function(pageNum) {
          var start = perPage * (pageNum - 1);
          var end = start + perPage;
          pageParts.hide()
            .slice(start, end).show();
        }
      });
    } //endif
  });
});

function openCity(evt, eventName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("eventcontainer");
  //jQuery(".eventcontainer:first-child").css({"display":"block"});
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(eventName).style.display = "block";
  evt.currentTarget.className += " active";
}
//  Leave Event
jQuery(document).ready(function() {
  jQuery('.interestedbtn').click(function() {
    if (confirm("Are you sure you want to leave?")) {

      var event_id = jQuery(this).attr('data-id');
      //var user_id   = jQuery(this).attr('data-user-id');
      data = {
        'action': 'bpem_leave_event',
        'event_id': event_id,
        //'user_id' : user_id,
      }
      jQuery.post(ajax_object.ajax_url, data, function(response) {
        console.log(response);
        location.reload();
      });
    } //end confirm
  });
});
// Remove attendy
jQuery(document).ready(function() {
  jQuery(".remove_attendy").click(function(e) {
    e.preventDefault();
    if (confirm("Are You Sure! Delete Attendee ?")) {
      var user = jQuery(this).attr('user-id');
      var event = jQuery(this).attr('event-id');
      jQuery(this).closest('.box').hide('slow');
      //console.log(user+' '+event);
      data = {
        'action': 'bpem_remove_attendy',
        'user_id': user,
        'event_id': event,
      }
      jQuery.post(ajax_object.ajax_url, data, function(response) {
        console.log(response);
        location.reload();
      });
    }
  });

// Edit Event

  jQuery(".edit_event").click(function(e){
    e.preventDefault();
    // Get
    var evn_id = jQuery(this).attr("data-id");
    var post_name = jQuery(this).attr("event-name");
    var event_desc = jQuery(this).attr("event-desc");
    //var event_thumb = jQuery(this).attr("event-thumb");
    var event_location = jQuery(this).attr("event-location");
    var event_organizer = jQuery(this).attr("event-organization");
    var event_organizer_url = jQuery(this).attr("event-organization-url");
    var event_start_date = jQuery(this).attr("event-start-date");
    var event_start_time = jQuery(this).attr("event-start-time");
    var event_end_date = jQuery(this).attr("event-end-date");
    var event_end_time = jQuery(this).attr("event-end-time");
    var event_attach_id = jQuery(this).attr("event-attach-id");
    
    // Set
    jQuery(".update_event #event_title").val(post_name);
    tinymce.get('event_desc').setContent(event_desc);
    //jQuery(".update_event #EventUploadImage").val(event_thumb);
    /*jQuery(".imgshow").css({"background-image":"url("+event_thumb+")","width":"400px","height":"200px","margin":"10px 0px", "border":"6px solid #ddd","background-size":"100% 100%"}); 
    jQuery(".update_event .imgshow").attr('src', event_thumb);*/

    jQuery(".update_event #event_location").val(event_location);
    jQuery(".update_event #event_organizer").val(event_organizer);
    jQuery(".update_event #event_organizer_url").val(event_organizer_url);
    jQuery(".update_event #start_date").val(event_start_date);
    jQuery(".update_event #start_time").val(event_start_time);
    jQuery(".update_event #end_date").val(event_end_date);
    jQuery(".update_event #end_time").val(event_end_time);
    jQuery(".update_event #eventid").val(evn_id);
    jQuery(".update_event #EventUploadImage_update").val(event_attach_id);
    //Display
    jQuery(".update_event").show();

  });


  jQuery(".closeplz").click(function(){
    //hide
    jQuery(".update_event").hide('fast');
  });


 // Update Event

  jQuery(".update_event_sub").click(function(e){
    e.preventDefault();
    var ev_id = jQuery("#eventid").val();
    var ev_title        = jQuery("#event_title").val();
    var ev_desc         = tinymce.get('event_desc').getContent();
    //var ev_image        = jQuery("#EventUploadImage").val();
    var ev_location     = jQuery("#event_location").val();
    var ev_start_date   = jQuery("#start_date").val();
    var ev_start_time   = jQuery("#start_time").val();
    var ev_end_date     = jQuery("#end_date").val();
    var ev_end_time     = jQuery("#end_time").val();
    var event_organizer = jQuery("#event_organizer").val();
    var event_organizer_url     = jQuery("#event_organizer_url").val();
//    var ev_group       = jQuery("#evn_group").val();


    if(ev_title == ""){
      alert("Event title required");
      return false;
    }

    if(ev_desc == ""){
      alert("Event Description required");
      return false;
    }

    if(ev_location == ""){
      alert("Event Location required");
      return false;
    }

    if(event_organizer == ""){
      alert("Event Organiser required");
      return false;
    }



    if(ev_start_date == ""){
      alert("Event Start Date required");
      return false;
    }



    if(ev_start_time == ""){
      alert("Event Start Time required");
      return false;
    }

    if(ev_end_date == ""){
      alert("Event End Date required");
      return false;
    }



    if(ev_end_time == ""){
      alert("Event End Time required");
      return false;
    }

  

    jQuery(this).hide();

    jQuery(".loaders").show();

    var data = {

    'action': 'bpem_event_update_response',

    'ev_title':ev_title,

    'ev_desc': ev_desc,

    //'ev_image': ev_image,

    'ev_location': ev_location,

    'ev_start_date':ev_start_date,

    'ev_start_time':ev_start_time,

    'ev_end_date':ev_end_date,

    'ev_end_time':ev_end_time,

    'ev_organizer':event_organizer,

    'ev_organizer_url':event_organizer_url,

    'ev_id':ev_id,

   };



  // We can also pass the url value separately from ajaxurl for front end AJAX implementations



  jQuery.post(ajax_object.ajax_url, data, function(response) {

    console.log(response);

    location.reload();

  });



});


jQuery(".delete_event").click(function(e){
  e.preventDefault();
    var id = jQuery(this).attr("data-id");
     //alert(id);

if(confirm("Are you sure you want to delete?")){


    var ev_location     = jQuery(this).attr('event-location');
    var ev_start_date   = jQuery(this).attr('event-start-date');
    var ev_start_time   = jQuery(this).attr('event-start-time');
    var ev_end_date     = jQuery(this).attr('event-end-date');
    var ev_end_time     = jQuery(this).attr('event-end-time');
    var event_organizer = jQuery(this).attr('event-organization');
    var event_organizer_url = jQuery(this).attr('event-organization-url');

    var data = {

    'action': 'bpem_event_delete_response',
    'ev_location': ev_location,
    'ev_start_date':ev_start_date,
    'ev_start_time':ev_start_time,
    'ev_end_date':ev_end_date,
    'ev_end_time':ev_end_time,
    'ev_organizer':event_organizer,
    'ev_organizer_url':event_organizer_url,
    'ev_id':id,

   };


  jQuery.post(ajax_object.ajax_url, data, function(response) {

    console.log(response);

    //location.reload();

  });

}

});





});