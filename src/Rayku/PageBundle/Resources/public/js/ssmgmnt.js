var session = null;

$(document).ready(function(){
	//Create a session
	$('#create_session').submit(function() {
		$('#loading-indicator').fadeIn('fast');
	});
	
    $('#create_session').ajaxForm(function(response) {
    	if(response.success == true){
    		session = response.redirect;
    		if(session !== null){
    			$('.backtoWhiteboard').css('display', 'block');
    			console.log(session);
    			$('#whiteboard').src = session;
		        $('#whiteboard2 iframe').attr("src", session);
		        $('#loading-indicator').fadeOut('slow');
		        $('input[name="tutorConnect"]').addClass('disabled').attr("disabled", "disabled");
		        $('.container').animate({
		            display:'none'
		        });
		        $('body').css('overflow', 'hidden');
		        $('.main-header').fadeOut('fast');
		        $('#whiteboard2').fadeIn('slow');
    		}
    		else{
    			$('input[name="tutorConnect"]').removeAttr('disabled').removeClass('disabled');
    		}   
	    }
	    else{
	    	alert('There was an error starting your session');
	    }
    });
    if(session == null){
    	$('.backtoWhiteboard').css('display', 'none');
    }
    $('.backWhiteboard').on('click', function (){
    	//if a session already exists, load the iframe containing it
    	if(session !== null && $('#whiteboard2 iframe').attr("src") === session){
    		$('.main-header').fadeOut('fast');
			$('#whiteboard2').fadeIn('slow');
    	}
    });
});