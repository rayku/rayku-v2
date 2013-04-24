$(document).ready(function(){
  	var tutorList = []; //store selected tutors
    var tutorCount = 0;

    //Tutor Selection
    $('.tutor-check').on('click', function(){
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
            });
        }
    });
    //Clear selected tutors
    $('.clear-tutors').click(function(event){
        event.preventDefault();
        tutorCount = 0; //set the selected tutor count back to 0
        tutorList.splice(0, tutorList.length); //delete all tutors from the tutor list
        $("#selectedTutors li").remove(); //remove selected tutors from ol list
        $('input[name="tutor"]').attr('checked', false); //set all checked tutors to unchecked
        $('span.tutor-count').html("0"); //reset the count on the page
    });
});