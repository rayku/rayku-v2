$(document).ready(function(){

	//Custom checkbox skin
	$('li.checkboxes input').customcheckbox();
	
	//Ask a question signup form
	$('#intro input.ask').keyup(function(){
		if (this.value == 'q') {
		$('#intro').addClass('open');
		} else {
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
		checkboxCls   	: options.checkboxCls || 'checkbox' , radioCls : options.radioCls || 'radio' ,	
		checkedCls 		: options.checkedCls  || 'checked'  , selectedCls : options.selectedCls || 'selected' , 
		hideCls  	 	: 'hide'
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
    			else {	$(this).parent().removeClass(defaultOpt.checkedCls); $(this).parents('label').removeClass(defaultOpt.checkedCls);  	}
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