var timePickerOptions = {
		        now: "12:00", //hh:mm 24 hour format only, defaults to current time
		        twentyFour: false,  //Display 24 hour format, defaults to false
		        upArrow: 'wickedpicker__controls__control-up',  //The up arrow class selector to use, for custom CSS
		        downArrow: 'wickedpicker__controls__control-down', //The down arrow class selector to use, for custom CSS
		        close: 'wickedpicker__close', //The close class selector to use, for custom CSS
		        hoverState: 'hover-state', //The hover state class to use, for custom CSS
		        title: 'Select Time', //The Wickedpicker's title
			    minutesInterval: 15    
		    };

$.fn.scrollView = function (offset) {
    return this.each(function () {
        $('html, body').animate({
            scrollTop: $(this).offset().top + offset
        }, 1000);
    });
}

function toTime(str){
	d = new Date(str);
	//return d.toLocaleTimeString(navigator.language, {hour: '2-digit', minute:'2-digit', timeZone: 'UTC' });
	//return d.toLocaleTimeString(navigator.language, {hour: '2-digit', minute:'2-digit', timeZone: 'en-US' });
	return formatDate(d);
}

function formatDate(date) {
	  var hours = date.getHours();
	  var minutes = date.getMinutes();
	  var ampm = hours >= 12 ? 'PM' : 'AM';
	  hours = hours % 12;
	  hours = hours ? hours : 12; // the hour '0' should be '12'
	  minutes = minutes < 10 ? '0'+minutes : minutes;
	  var strTime = hours + ':' + minutes + ' ' + ampm;
	  //return date.getMonth()+1 + "/" + date.getDate() + "/" + date.getFullYear() + "  " + strTime;
	  return strTime;
	}


function toDate(str){
	d = new Date(str);
	str = window.METRO_LOCALES.en.months[ (d.getMonth()+1)+11] + ' '+d.getDate()+', ' + d.getFullYear();
	return str;
	//return d.toLocaleString(navigator.language);
}

function ajaxError(errorThrown){
	switch (errorThrown.toLowerCase()) {
	case 'forbidden':
		ajaxNotLoggedIn();
		break;

	default:
		alert(errorThrown);
		break;
	}
}
function ajaxNotLoggedIn(){
	alert('Request failed. \n You have been logged out.');
	window.location.replace(webroot+"users/login");
}

function numeric(){
	$('.numeric').keyup(function () { 
	    this.value = this.value.replace(/[^0-9\.]/g,'');
	});
}
