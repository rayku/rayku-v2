var pathname = window.location.pathname;
var hash = window.location.hash;
var locale = pathname.split('/');
var abs = hash.split('/');

$(document).ready(function(){
	//Show dropdown navigation
    $('a.logged-in-as').on('click',function(event){
        event.preventDefault();
            $('div.submenu').slideToggle(100);
        }
    );
    $('.submenu').on('mouseleave', function(){
        $(this).slideUp(30);
    });

    $('#sidebar ul.sidebar-nav li a').click(function(){
    	var navitem = $(this).text().substr(1);
    	var icon = $(this).text().charAt(0);
    	$(this).parent().siblings().find('a').removeClass('active');
    	$(this).addClass('active');
    	//$('.content-header h3').html('<span class="raphael">'+ icon +'</span>' + navitem);
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
    $('.tutorTable tr').on('click', 
        function(){
            console.log('clicked');
    		var checkbox = $(this).find('input[type="checkbox"]');
    		checkbox.attr("checked", !checkbox.prop("checked"));
	    }
    );

    //Animation to show practice whiteboard iFrame for now
    $('.userWhiteboard').click(function (){
        $('.container').fadeOut('fast');
        $('#whiteboard2 iframe').attr("src", "http://whiteboard.rayku.com/standalone");
        $('#whiteboard2').delay(500).fadeIn('slow');

    });
    $('.home').click(function (){
    	$('body').css('overflow', 'scroll');
        $('#whiteboard2').fadeOut('slow');
        $('.container').delay(500).fadeIn('fast');
        $('.content-header h3').html('<span class="raphael">S</span>Dashboard');
        $('#sidebar ul.sidebar-nav li').siblings().removeClass('active');
    });
    //PROFILE AREA
    $('.myprofile').click(function(){
        $('.editprofileinfo').siblings().fadeOut('fast');
        $('.editprofileinfo').delay(500).fadeIn(500);
    });
    $('.payout').click(function(){
        $('.tutorpayout').siblings().fadeOut('fast');
        $('.tutorpayout').delay(500).fadeIn(500);
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


    //To show sidebar for small screen
    $('.slide-out').click(function () {
        $(this).fadeOut('fast'); //fadeout slideout button
        //show the sidebar
        $('#sidebar').addClass('sidebar-small-screen').fadeIn('fast');
        //show the slide in button
        $('.slide-in').fadeIn('fast');
    });

    //To hide sidebar for small screen
    $('.slide-in').click(function () {
        $(this).fadeOut('fast');//fade this button out
        $('#sidebar').fadeOut('fast'); //fadeout the sidebar
        $('.slide-out').fadeIn('fast');//fadein the slide-out button
    });

    $('.startedSave').click(function (event) {
        $('#getStartedModal').foundation('reveal', 'close');
        event.preventDefault();
    })
});

// Used to show/hide sidebar depending on screen size
$(window).resize(function () {
    //determine if document width is greater than 1025
    if($(document).width() > 1025){
        $('#sidebar').fadeIn('fast');
        $('#content-body').css('width', '82%');
        $('.slide-out').fadeOut('fast');
        $('.slide-in').fadeOut('fast');
    } 
    else if($(document).width() < 1025){
        $('#sidebar').fadeOut('fast');
        $('#content-body').css('width', '100%');
        $('.slide-out').fadeIn('fast');
    }
});

//Counyt characters for about 
function countChar(val) {
    var len = val.value.length;
    if (len >= 120) {
        val.value = val.value.substring(0, 120);
    } else {
        $('#charNum').text(120 - len + ' Characters Left');
    }
}

