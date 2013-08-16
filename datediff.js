var d = new Date();    // defaults to the current time in the current timezone
var greeting = 'Good Afternoon.';
if (d.getHours() < 12) {
    greeting =  "Good morning.";
} else if (d.getHours() > 12 && d.getHours() < 16) {
    greeting = "Good afternoon.";
}
else if (d.getHours() > 16) {
	greeting = "Good evening.";
}
var currentHours = d.getHours();
if (currentHours > 12) {currentHours = currentHours - 12;}
var beforeafter = 'PM';
if (d.getHours() < 12) {
	beforeafter = 'AM';
}
var currentMin = d.getMinutes();
//currentHours = ( currentHours < 10 ? "0" : "" ) + currentHours;
currentMin = ( currentMin < 10 ? "0" : "" ) + currentMin;
//$('span#greetme').append(greeting);
	$('#greetme').append("<b>current time is "+currentHours+":"+currentMin+"</b><b>"+beforeafter+" - "+greeting+"</b>");
});


var start = $('#start_date').val();
var end = $('#end_date').val();

// end - start returns difference in milliseconds 
var diff = new Date(end - start);

// get days
var days = diff/1000/60/60/24;