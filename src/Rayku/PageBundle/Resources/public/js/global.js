$(function(){
    var tutorList = []; //store selected tutors
    var tutorCount = 0;

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

    //Show dropdown navigation
    $('a.logged-in-as').hover(function(){
        $('div.submenu').show(30, function(){
                $('a.logged-in-as').css('background', 'rgba(10, 10, 10, 0.4)');
                $(this).mouseleave(function(){
                    $(this).hide(10);
                    $('a.logged-in-as').css('background', 'transparent');
                }); 
            });
        }
    );

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

    //Submit Question
    $('input[name="aSubmit"]').click(function(e){
        e.preventDefault();

        //disable all checkboxes for tutors that are busy
        $('form#tutorList :input').each(function(){
            var input = $(this);
            if($(this).attr("data-tutor-status") == 1){
                $(this).attr('disabled', true);
            }
        });
        
        var question = $('input[name="ask"]').val(); //get the question typed by user
        $('p.user-question').html("\"" + question +"\""); //append question to header div
        //show hidden divs
        $('.tutor-list').fadeIn('fast');
        $('.tutor-selected').fadeIn('fast');
        var institution = $('#schoolSelect option:selected').val();
        var category = $('select[name="category"]').val();
        var level;
        if(institution == "high school"){
            level = $('select[name="highschool"]').val();
        }
        else if(institution == "university"){
            level = $('select[name="university"]').val();
        }
        else{
            level = "";
        }
        console.log(institution + " " + level + " " + category);
    });

    //set all busy tutors to show a red background
    $('table#tutorTable tr td').each(function(){
        var column = $(this);
        console.log(column);
        if(column.hasClass('busy')){
            column.find('a').addClass('tutor-busy');
        }
    });
    

    //Tutor Selection
    $('input[name="tutor"]').on('click', function(){
            var tutor = $(this); //set tutor to checked/clicked checkbox
            var tutor_id = $(this).attr('data-tutor-id'); //get the tutor id from the data attribute

            //check if the tutor_id exists in the list of selected tutors
            if(jQuery.inArray(tutor_id, tutorList) !== -1){
                //if student deselects a tutor
                $("#selectedTutors li[data-tutor-id='" + tutor_id + "']").remove(); //remove the li currently showing this tutor
                tutorList.splice(jQuery.inArray(tutor_id, tutorList), 1); //remove the tutor id from the tutor list
                //set the checkbox attribute to unchecked
                $(this).attr('checked', ''); // For IE
                $(this).checked = false;

                tutorCount--;//decrement the tutor count
                $('span.tutor-count').html(tutorCount);//append the new count to the page
                console.log(tutor_id);
                console.log(tutorList);
            }
            else{
                //if student selects a tutor
                //set the checkbox attribute to checked
                $(this).attr('checked', 'checked'); 
                $(this).checked = true;

                //make a list containing the selected tutors name and id
                var myTutor = {
                    'tutor_info':{
                        'tutor_name': tutor.attr('data-tutor-name'),
                        'tutor_id': tutor.attr('data-tutor-id')
                    }   
                };
                
                $.each(myTutor, function(){
                    //append the selected tutor to the page
                    var item = '<li data-tutor-id="'+ myTutor.tutor_info['tutor_id'] +'"><a href="#">'+ myTutor.tutor_info['tutor_name'] + '</a></li>';
                    $('ol#selectedTutors').hide().append(item).fadeIn('slow');
                    //push the tutors id to the list of tutors id's
                    tutorList.push(myTutor.tutor_info['tutor_id']);
                    //increment count of tutors selected
                    tutorCount++;
                    //add the count to the page
                    $('span.tutor-count').html(tutorCount);
                    console.log(tutorList);
                });
            }
        }
    );

    //Clear selected tutors
    $('.clear-tutors').click(function(event){
        event.preventDefault();
        tutorCount = 0; //set the selected tutor count back to 0
        tutorList.splice(0, tutorList.length); //delete all tutors from the tutor list
        $("#selectedTutors li").remove(); //remove selected tutors from ol list
        $('input[name="tutor"]').attr('checked', false); //set all checked tutors to unchecked
        $('span.tutor-count').html("0"); //reset the count on the page
        console.log(tutorList);
    });

    //Populate Level select box
    $('#schoolSelect').on('change', function(){
        populateLevel(); //call the populate function
    });
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