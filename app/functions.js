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

export function saveData (data, fileName, dataType) { //pure JS workaround for client side download data - either csv or json - wrote without jQuery becasue we can probably reuse it
    console.log('test');
    let a = document.createElement("a");
    document.body.appendChild(a);
    a.setAttribute('style', "display: none");
    let blob = new Blob([data], {type: dataType});
    let url = window.URL.createObjectURL(blob);
    a.href = url;
    a.download = fileName;
    a.click();
    window.URL.revokeObjectURL(url);
};

/******jQuery functions (to be rewritten) ****/

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

export function filterMarker(selector1, selector2) {

  $(selector1).on('click', function() {

    let $text = $(this).text()
    let $color = $text + '-color';

    /*if ($text == 'all') {
       $('.annotation-markers li').show();
       console.log($text);
    }*/


    $(selector2).each(function(){

      let $liClass = $(this).attr('class');

      if ($color == $liClass) {
          $(this).show();
      } else if ($text == 'all') {
        $(this).show();
        console.log($liClass);
      }
       else {
         $(this).hide();
      }

    });


  });

}

export function getSelectMultiple($selector1, $selector2, $key1, $key2){

  let $optionObject = {}; // the main object we want to return

  let $selector2Array = [];

  let $selector1Array = [];

  $($selector1).each(function($i, $option){

    let $optionVal = $($option).attr('value'); //film id

    $selector1Array.push($optionVal);

  });

  $($selector2).each(function($j, $option2){

    let $optionVal = $($option2).attr('value'); //marker category id

    $selector2Array.push($optionVal);

  });

  $optionObject[$key1] = $selector1Array;

  $optionObject[$key2] = $selector2Array;

  return $optionObject; // returns an object which contains indexical arrays of filmIds and markerCategoryIds
}

export function logAjax(markerAjax) {
      // the majority of the interactivity is handled in this callback -- should write all of these as separate functions but who cares since we're changing it ;)

      $('.annotation-group ul li button').on('click',function(){
        let $buttonVal = $(this).val();
        let $time = controls.getTime();
        let $target = controls.getSelector();

        markerAjax.setMarkerType($buttonVal);
        markerAjax.setStart($time);

        markerAjax.setTarget($target);
        markerAjax.setEnd($time);

      });

      filterMarker('.filter-button', '.annotation-markers li');

      $('#marker-submit').on('click',function() {
        let $note = $('#marker-note').val();
        markerAjax.setNote($note);
        markerAjax.insertMarker();
        $('#marker-note').val('');
      });

      VideoController.timeScrubbing('.annotation-list ul', 'li .time-stamp');
      //VideoController.activeMarker('.annotation-list ul li');

      var $mouseCount = 0;

      $('.annotation-list ul').on('click', 'li i', function () {

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


      $('.filetype-download').on('click', function(){


          let $filetype = $('.filetype input[type="radio"]:checked').attr('value');

          let $filmIdObject = getSelectMultiple('#film-select :selected', '#marker-select :selected', 'filmIds', 'markerCategoryIds');

          console.log($filmIdObject);

          console.log($filetype);

          MarkerAjax.queryDb($filmIdObject, $filetype);


      });

    }
