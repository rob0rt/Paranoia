$(window).resize(function(){
	$('.maintitle').css({
		top: ($(window).height() - $('.maintitle').outerHeight())/2,
		width: $(window).width()
	});
	disbaleSubmit();
});

$(document).ready(function() {
	$('.noEnterSubmit').keypress(function(e){
		if ( e.which == 13 ) return false;
	});
	$("#deaths").html($('#Players tr.error').length);
	if($('#Players tr.error').length ==($('#Players tr').length - 2)) {
		$('.navbar').after("<div class=\"container-fluid\"><div class=\"row-fluid\"><div class=\"alert alert-success span12\">The game is over! The winner is: " + $('#Players tr:not(.error)').find("td").html() + ".</div></div></div>");
	}
});

function checkPW() {
	var password = $("#createPassword").val();
	var confirmPassword = $("#verifyPassword").val();

    if (password != confirmPassword) {
    	if($('#badPsswd').length == 0)
			$("#verifyPsswd").after("<div class=\"alert alert-error\" id=\"badPsswd\">Passwords must match.</div>");
    }
    else
    	$("#badPsswd").remove();
    	
    if(password.length < 6) {
    	if($("#badPsswdLen").length == 0)
    		$("#verifyPsswd").after("<div class=\"alert alert-error\" id=\"badPsswdLen\">Passwords must be longer then 6 characters.</div>");
    }
    else
    	$("#badPsswdLen").remove();
    
    if($('#badPsswd').length != 0 || $("#badPsswdLen").length != 0){
	    $("#verifyPsswd").addClass("error");
    	$("#verifyPsswd").removeClass("success");
    	$("#createPsswd").removeClass("success");
    }
    else {
	    $("#verifyPsswd").removeClass("error").addClass("success");
    	$("#createPsswd").addClass("success");
    }
    
    disbaleSubmit();
}

function verifyEmail(){
	var emailRegEx = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
	if ($("#inputEmail").val().search(emailRegEx) == -1) {	
		if($('#badEmail').length == 0)
			$("#verifyPsswd").after("<div class=\"alert alert-error\" id=\"badEmail\">Enter a valid email address.</div>");
		$("#userEmail").addClass("error");
		$("#userEmail").removeClass("success");
	}
	else {
		$("#badEmail").remove();
		$("#userEmail").removeClass("error").addClass("success");
	}
	disbaleSubmit();
}

function checkUserExists() {
	
	var temp = 0;
	$.ajax({
		type: "POST",
		url: "lib/checkuser.php",
		data: {user: $("#createUsername").val()},
		success: function(data){
			if(data != 0) {
				if($('#badUser').length == 0) {
					$("#verifyPsswd").after("<div class=\"alert alert-error\" id=\"badUser\">Username already exists.</div>");
				}
				$("#accountName").removeClass("success");
				$("#accountName").addClass("error");
			}
			else {
				$("#badUser").remove();
				$("#accountName").removeClass("error").addClass("success");
			}
		}
	});
	disbaleSubmit();
}

function disbaleSubmit() {
	if($("#accountName").hasClass("success") && $("#userEmail").hasClass("success") && $("#verifyPsswd").hasClass("success"))
		$('#mkAccount').attr("disabled", false);
	else
		$('#mkAccount').attr("disabled", "disabled");
}

function deleteRow(r)
{
	var i=r.parentNode.parentNode.rowIndex;
	document.getElementById('addPlayers').deleteRow(i);
}

function addRow() {
	var rowCount = $('#addPlayers tr').length - 1;
	var rowIn = "<tr><td><input class=\"noEnterSubmit\" type=\"text\" placeholder=\"Player name\" name=\"p[]\"></td><td><input class=\"noEnterSubmit\" type=\"text\" placeholder=\"Player cell\" name=\"c[]\"></td><td><button class=\"btn btn-danger\" type=\"button\" onclick=\"deleteRow(this)\">Remove</button></td></tr>"
	$('#addPlayers tr:last').after(rowIn);
}

function addMultipleRows() {
	var loop = $("#numPlayToAdd").val();
	for (var i=0;i<loop;i++) { 
		addRow();
	}
	$("#numPlayToAdd").val("");
}

function getTime(){
	var time = new Date();
	
	var hours = time.getHours();
	var minutes = time.getMinutes(); 
	var seconds = time.getSeconds(); 
	var ampm = "";
	if(hours > 12) {
		hours = hours - 12;
		ampm = "pm";
	}
	else {
		ampm = "am";
	}
	if(hours == 0)
		hours = 12;
	$("#time").html(padNumber(hours) + ":" + padNumber(minutes) + ":" + padNumber(seconds) + " " + ampm);
}

function getElapsed(s) {
	var remainingTime = getTimeString(s);
	if(remainingTime == '') {
		$('#timePassed').html('ERROR.');
	}
	else { 
		$("#timePassed").html(remainingTime);
	}
}

function getTimeString(target) {
	var today  = new Date();
	
	if (typeof(target) == 'object') {
		var targetDate = target;
	} else {
		var matches = target.match(/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2})(:(\d{2}))?/);   // YYYY-MM-DD HH-MM-SS
		if (matches != null) {
			matches[7] = typeof(matches[7]) == 'undefined' ? '00' : matches[7];
			var targetDate = new Date(matches[1], matches[2] - 1, matches[3], matches[4], matches[5], matches[7]);
		} else {
			var targetDate = new Date(target);
		}
	}
	
	seconds = Math.abs(Math.floor((targetDate.getTime() - today.getTime()) / 1000));
	
	if (seconds < 1) {
		return '';
	}
	
	var units = [86400, 3600, 60, 1];
	
	var returnArray = [];
	var value;
	for (index in units) {
		value = units[index];
		secondsConverted = Math.floor(seconds / value);
		returnArray.push(secondsConverted);
		seconds -= secondsConverted * value;
	};
	
	remainingTime = returnArray;
	
	for (index in remainingTime) {
		remainingTime[index] = padNumber(remainingTime[index]);
	};
	
	return remainingTime.join(':');
}

function padNumber(number) {
	return (number >= 0 && number < 10) ? '0' + number : number;
}