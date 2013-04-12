$(function(){
    var tutorList = []; //store selected tutors
    var tutorCount = 0;
    var $settings = $('.user-settings');
    var $profile = $('.user-profile');
    
    //Forgot password on login modal
    $('a.forgot-password').click(function(){
        if($('.login-button').hasClass('disabled')){
            $('.forgot-email-form').slideUp(200);
            $('.login-modal-divider1').hide();
            $('.login-button').removeClass('disabled');
            $('.login-button').attr('disabled', false);
        }
        else {
            $('.forgot-email-form').slideDown(200);
            $('.login-modal-divider1').show();
            $('.login-button').addClass('disabled');
            $('.login-button').attr('disabled', true);
        }
    });
    //Show settings
    $('.settings').on('click', function(){
        $profile.fadeOut('fast');
        $('.tutor-list').fadeOut('fast');
        $settings.delay(500).fadeIn('slow');
    });

    //Show home
    $('.home').on('click', function(){
        $settings.fadeOut('fast');
        $profile.delay(500).fadeIn('slow');
    });
    
    //Show dropdown navigation
    $('a.logged-in-as').on('click',function(){
            $('div.submenu').slideToggle(30);
        }
    );
    $('.submenu').on('mouseleave', function(){
        $(this).slideUp(30);
    });

    //Category Select
    $('#categorySelect').change(function() {
        var category = $('select[name="category"]').val();
        //If the current option is Choose Category, do not show the input box
        if (category == "Choose Category"){
            $('.tutor-list').fadeOut('fast');
            $("#selectedTutors li").remove(); //remove selected tutors from ol list
            tutorList.splice(0, tutorList.length); //empty tutor id list
            tutorCount = 0; //set tutor count back to 0
            $('.tutor-selected').fadeOut('fast');
            $('span.tutor-count').html("0"); // replace tutor count on page with empty string
            console.log(tutorList);
        }
        else{
            var placeholder = 'What is your ' + category + ' question? Or view online tutors'; //set placeholder text for ask form
            $('input[name="ask"]').attr('placeholder', placeholder);
            $('.question-container').slideDown('fast'); //show input field
        }
    });

    //Populate level select box
    $('#schoolSelect').on('change', function(){
        populateLevel(); //call the populate function
    });

    //Edit user profile
    $('a.edit-button').on('click',function(event){
        event.preventDefault();
        if($(this).hasClass('edit-button')){
            $(this).hide();
            $('.done-button').show();
            $('a.edit-tool').show(100);
        }
    });

    $('.done-button').on('click', function(event){
        if($(this).hasClass('done-button')){
            $('a.edit-tool').hide(100);
            $(this).hide();
            $('.edit-button').show();
        }
    });

    $('a.edit-tool').on('click', function(event){
        event.preventDefault();
        $(this).siblings('form.user-profile-edit-form').hide(100);
        $(this).next('form.user-profile-edit-form').show(100);
    });
    $('a.close-edit').on('click', function(event){
        event.preventDefault();
        $('form.user-profile-edit-form').hide(100);
    })
});

function populateLevel(){
    var level = $('select[name="school"]').val(); //determine if highschool or university was selected

    if(level == 'high school'){
        //if highschool is selected, show the highschool grade selection list
        console.log(level);
        $('#placeholder').hide();
        $('#university').hide();
        $('#highschool').show();
        $('#university select').attr('disabled', 'disabled');
        $('#highschool select').removeAttr('disabled');
    }
    else if(level == 'university'){
        //if university is selected, show the university level selection list
        console.log(level);
        $('#placeholder').hide();
        $('#highschool').hide();
        $('#university').show();
        $('#highschool select').attr('disabled', 'disabled');
        $('#university select').removeAttr('disabled');
    }
    else{
        $('#university').hide();
        $('#highschool').hide();
        $('#placeholder').show();
        $('#university select').attr('disabled', 'disabled');
        $('#highschool select').attr('disabled', 'disabled');
    }
}

//stick tutor select to top of the page on scroll
$(window).scroll(function(e){ 
    $el = $('.tutor-selected'); 
    $tbel = $('#tutorTable thead');
    if ($(this).scrollTop() > 150 && $el.css('position') != 'fixed'){ 
        $('.tutor-selected').addClass('tutor-selected-scroll');
        

    } 
    else if($(this).scrollTop() < 150 && $el.css('position') == 'fixed'){
        $('.tutor-selected').removeClass('tutor-selected-scroll');
        
    }
});

$(document).ready(function(){
    //Custom checkbox skin
    $('li.checkboxes input').customcheckbox();
    
    //Already have an account
    $('a.ask-login-button').click(function(){
        $('#intro').removeClass('open');
    });

    //Show registration form
    $('.signup-user').click(function(){
        $('#intro').addClass('open');
    });

    //If user forgot password, show them the email form to retrieve the password

    //Dismiss modal and show login form
    $('a.close-reveal-modal').click(function(){
        $('.login-form').show();
        $('.forgot-email-form').hide();
    });
    
    //Ask a question signup form
    $('#intro input.ask').keyup(function(){
        if($('#intro input.ask').val()!= ""){
            $('#intro').addClass('open');
        }
        else {
            $('#intro').removeClass('open');
        }
    });
    
    //About Us Faces
    $('ul.team li').click(function(){
        $('ul.team li').removeClass('active before');
        $(this).addClass('active').prev().addClass('before');
        
        $('#behind .member-info .info').removeClass('show');
        $('#behind .member-info .info:eq('+$(this).index()+')').addClass('show');
        return false;
    });
    
    //About Us Google Maps
    if ($('#map_canvas').length) {
        $('#map_canvas').gmap({'zoom': 13,'center': '43.65668,-79.380684'}).bind('init', function(ev, map) {
            $('#map_canvas').gmap('addMarker', {'position': '43.65668,-79.380684'}).click(function() {
                $('#map_canvas').gmap('openInfoWindow', {'content': '<strong>Rayku Headquarters</strong> <br /> 10 Dundas Street E Suite 502 <br /> Toronto, Ontario, Canada <br /><br /> Get in touch! <em>cs@rayku.com</em>'}, this);
            });
            
            var width = $(this).width() / 2 / 2;
            
            map.panBy(width, 0);
        });
    }
    
    //Testimonials
    var myHeight;
    $('.element').each(function (i) {
        var myElement = $(this);
        myElement.data('params', {
            top1: $(this).css('top'),
            x1: $(this).css('left')
        });
        switch (i) {
        case 0:
            myElement.data('params', {
                top0: -500,
                x0: -2600,
                top1: $(this).css('top'),
                x1: $(this).css('left')
            });
            break;
        case 1:
            myElement.data('params', {
                top0: -100,
                x0: -930,
                top1: $(this).css('top'),
                x1: $(this).css('left')
            });
            break;
        case 2:
            myElement.data('params', {
                top0: -700,
                x0: -2600,
                top1: $(this).css('top'),
                x1: $(this).css('right')
            });
            break;
        }
    });

    function init() {
        myHeight = $(window).height();

    }
    $(window).scroll(function () {
        var s_max = myHeight / 2 + 450;

        function move(p0, p1, s) {
            return Math.min((-p0 + p1) / s_max * s + p0, p1);
        }
        var scrollTop = parseInt($(window).scrollTop());
        $('.element').each(function (i) {
            var myX = move($(this).data('params').x0, parseInt($(this).data('params').x1), scrollTop),
                myY = move($(this).data('params').top0, parseInt($(this).data('params').top1), scrollTop);
            if (i < 2) {
                $(this).stop().css({
                    left: myX + 'px',
                    top: myY + 'px'
                })
            } else {
                $(this).stop().css({
                    right: myX + 'px',
                    top: myY + 'px'
                })
            }
        })
    })
    init();
    $(window).resize(function () {
        init();
    });

});

//Checkbox / Radio skin
(function($) {
  $.fn.customcheckbox = function(options) {
    options = options || {}; 
    var defaultOpt = { 
        checkboxCls     : options.checkboxCls || 'checkbox' , radioCls : options.radioCls || 'radio' ,  
        checkedCls      : options.checkedCls  || 'checked'  , selectedCls : options.selectedCls || 'selected' , 
        hideCls         : 'hide'
    };
    return this.each(function() {
        var $this = $(this);
        var wrapTag = $this.attr('type') == 'checkbox' ? '<div class="'+defaultOpt.checkboxCls+'"><small>' : '<div class="'+defaultOpt.radioCls+'"><small>';
        // for checkbox
        if( $this.attr('type') == 'checkbox') {
            $this.addClass(defaultOpt.hideCls).wrap(wrapTag).change(function() {
                if( $(this).is(':checked') ) { 
                    $(this).parent().addClass(defaultOpt.checkedCls); 
                    $(this).parents('label').addClass(defaultOpt.checkedCls); 
                } 
                else {  $(this).parent().removeClass(defaultOpt.checkedCls); $(this).parents('label').removeClass(defaultOpt.checkedCls);   }
            });
            
            if( $this.is(':checked') ) {
                $this.parent().addClass(defaultOpt.checkedCls);         
            }
        } 
        else if( $this.attr('type') == 'radio') {

            $this.addClass(defaultOpt.hideCls).wrap(wrapTag).change(function() {
                // radio button may contain groups! - so check for group
                $('input[name="'+$(this).attr('name')+'"]').each(function() {
                    if( $(this).is(':checked') ) { 
                        $(this).parent().addClass(defaultOpt.selectedCls); 
                        $(this).parents('label').addClass(defaultOpt.checkedCls); 
                    } else {
                        $(this).parent().removeClass(defaultOpt.selectedCls);    
                        $(this).parents('label').removeClass(defaultOpt.checkedCls);                    
                    }
                });
            });
            
            if( $this.is(':checked') ) {
                $this.parent().addClass(defaultOpt.selectedCls);            
            }           
        }
    });
  }
})(jQuery);