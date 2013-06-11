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


    $('a.setting').click(function (e) {
        e.preventDefault();
        console.log('Clicked');
        $('#content').fadeOut('fast');
        $('#userprofile').delay(500).fadeIn('fast');
        $('.profilesettings').siblings().fadeOut('fast');
        $('.profilesettings').delay(500).fadeIn(500);
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

    //Animation to show practice whiteboard iFrame for now
    $('.userWhiteboard').click(function (){
    	$('body').css('overflow', 'hidden');
        $('.container').fadeOut('fast');
        $('#whiteboard2 iframe').attr("src", "http://whiteboard.rayku.local:8080/standalone");
        $('#whiteboard2').delay(500).fadeIn('slow');
    });
    $('.home').click(function (){
    	$('body').css('overflow', 'scroll');
        $('#whiteboard2').fadeOut('slow');
        $('.container').delay(500).fadeIn('fast');
    });
    //PROFILE AREA
    $('.myprofile').click(function(){
        $('.profileinfo').siblings().fadeOut('fast');
        $('.profileinfo').delay(500).fadeIn(500);
    });
    $('.myprofileedit').click(function(){
        $('#content').fadeOut('fast');
        $('#userprofile').delay(500).fadeIn('fast');
        $('.editprofileinfo').siblings().fadeOut('fast');
        $('.editprofileinfo').delay(500).fadeIn(500);
    });
    $('.mysettings').click(function(){
        $('.profilesettings').siblings().fadeOut('fast');
        $('.profilesettings').delay(500).fadeIn(500);
    });
});