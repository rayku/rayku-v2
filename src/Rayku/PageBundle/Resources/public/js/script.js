$(document).ready(function(){
	//Show dropdown navigation
    $('a.logged-in-as').on('mouseenter',function(){
            $('div.submenu').slideToggle(100);
        }
    );
    $('.submenu').on('mouseleave', function(){
        $(this).slideUp(30);
    });

    $('#sidebar ul.sidebar-nav li a').click(function(){
    	var navitem = $(this).text().substr(1);
    	var icon = $(this).text().charAt(0);
    	$('#sidebar ul.sidebar-nav li').siblings().removeClass('active');
    	$(this).parent().addClass('active');
    	$('.content-header h3').html('<span class="raphael">'+ icon +'</span>' + navitem);
    });

    $('.profile').click(function(){
        $('#content').fadeOut('fast');
        $('#userprofile').delay(500).fadeIn('fast');
    });
    $('.dashboard').click(function(){
        $('#userprofile').fadeOut('fast');
        $('#content').delay(500).fadeIn('fast');
    });

    //checkbox toggle tutor selection
    $('.tutorTable tr').click(
    	function(){
    		var checkbox = $(this).find('input[type="checkbox"]');
    		checkbox.attr("checked", !checkbox.prop("checked"));
	    }
    );

    //Animation to increment/decrement dashboard size
    $('.userWhiteboard').click(function (){
    	$('#content-body').animate({
    		width: '98%'
    	});
    });
    $('.dashboard').click(function (){
    	$('#content-body').animate({
    		width: '82%'
    	});
    });
});