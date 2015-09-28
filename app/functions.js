import {MarkerAjax} from './markerAjax';
import {UserAjax} from './userAjax';
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

        let email = $('#user-email').val();
        let password = $('#user-password').val();

        var user = new UserAjax(id,email,filmId,fullName,password);

        let newUserAjax = user.userLogin();

        let markerPromise = newUserAjax.success(function(json) {

          if (json) {
            console.log(json);
            //Dynamically set video, display username, hide login, and show the main page
            $('.video').attr('src', json.filmUrl);
            $('.user-info').text(json.fullName);
            $('.overlay-login').hide("slow");
            $('.main-page').show("slow");

            var markerAjax = new MarkerAjax(json.userFilmId, null, null, null, null, json.userId);
            console.log(markerAjax);
            callback(markerAjax);
            user = null;
          }
      });
    });
    }

export function logAjax(markerAjax) {

      $('.annotation-group ul li button').click(function(){
        let $buttonVal = $(this).val();
        let $text = $(this).text()
        let $time = controls.getTime();
        let $target = controls.getSelector();
        markerAjax.setMarkerType($buttonVal);
        markerAjax.setStart($time);
        markerAjax.setText($text);
        markerAjax.setTarget($target);
        //pull up a submit button once the button is clicked (maybe another function ^)
        //send it to insert.php controller if submit is selected

        console.log(markerAjax.getStart());
        console.log(markerAjax.getMarkerType());
        console.log(markerAjax.getText());
        console.log(markerAjax.getTarget());


      });

    }
