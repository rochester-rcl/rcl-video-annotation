import {MarkerAjax} from './markerAjax';
import {UserAjax} from './userAjax';
import {VideoController} from './videoTools';
//Set up a prototype for the String class to convert seconds (float) to HHMMSS format for display
export function toHHMMSS(theInt){
    let secNum = parseInt(theInt, 10);
    let hours = Math.floor(secNum / 3600);
    let minutes = Math.floor((secNum - (hours * 3600)) / 60);
    let seconds = secNum - (hours * 3600) - (minutes * 60);

    if (hours < 10) {
        hours = "0" + hours;
    }
    if (minutes < 10) {
        minutes = "0" + minutes;
    }
     if (seconds < 10) {
        seconds = "0" + seconds;
    }
    let time = hours + ":" + minutes + ":" + seconds;
    return time;
};

export function userAjaxSubmit(callback) {
      let fullName = null;
      let filmId = null;
      let id = null;
      $('.user-login').submit(function(event){
        event.preventDefault();
        let email = $('#user-email').val();
        let password = $('#user-password').val();
        var user = new UserAjax(id,email,filmId,fullName,password);
        user.userLogin(callback);

    });
    }

export function logAjax(markerAjax) {
      // the majority of the interactivity is handled in this callback
      $('.annotation-group ul li button').on('click',function(){
        let $buttonVal = $(this).val();
        let $time = controls.getTime();
        let $target = controls.getSelector();

        markerAjax.setMarkerType($buttonVal);
        markerAjax.setStart($time);

        markerAjax.setTarget($target);
        markerAjax.setEnd($time);
        //$('.annotation-list ul li').hide();
        //pull up a submit button once the button is clicked (maybe another function ^)
        //send it to insert.php controller if submit is selected

      });

      $('#marker-submit').on('click',function() {
        let $note = $('#marker-note').val();
        markerAjax.setNote($note);
        markerAjax.insertMarker();
        $('#marker-note').val('');
      });

      VideoController.timeScrubbing('.annotation-list ul', 'li .time-stamp');

      VideoController.activeMarker('.annotation-list ul');

      var $mouseCount = 0;

      $('.annotation-list ul').on('click', 'li i', function () {


        console.log($mouseCount);
        if ($('.delete-option').length === 0) {

           $(this).parent().append('<div class="delete-option"> Delete Marker | Are you sure? <button id="yes-option" val="yes">Yes</button> <button id="no-option" val="no">No</button> </div>');

         }
         $('#yes-option').on('click', function() {

           var $id = $(this).parent().parent().data("film-marker-id");
           var $start = $(this).parent().parent().data("start");
           var $time = controls.getTime();
           var $displayTime = toHHMMSS($start);
           var $message = ' Marker at ' + $displayTime + ' deleted forever';

            $('.helptext').append('<span class="delete-message">'+$message+'</span>');
            setTimeout(function(){
              $('.delete-message').remove();
            }, 1000);
            markerAjax.setId($id);
            console.log(markerAjax.getId());
            markerAjax.deleteMarker();
            $(this).parent().parent().remove();

         });


             $('#no-option').on('click', function() {
               $(this).parent().remove();
                $mouseCount += 1;
                var $id, $start, $time, $end, $displayTime, $message = null;

             });

           });


    }
