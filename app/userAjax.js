import * as functions from './functions';
import {MarkerAjax} from './markerAjax';
import {VideoController} from './videoTools';


export class UserAjax {

    constructor(id,email,filmUrl,fullName,password) {

      this.id = id;
      this.email = email;
      this.fullName = fullName;
      this.password = password;
      this.filmUrl = filmUrl;

      }

      setUserId(id) {
        this.id = id;
      }

      getUserId() {
        return this.id;
      }

      setEmail(email) {
        this.email = email;
      }

      getEmail() {
        return this.email;
      }
      setFullName(fullName) {
        this.fullName = fullName;
      }

      getFullName() {
        return this.fullName;
      }
      setPassword(password){
        this.password = password;
      }

      getPassword(){
        return this.password;
      }

      setFilmId(filmId) {
        this.filmId = filmId;
      }

      getFilmId() {
        return this.filmId;
      }

      static getForm() {
        //let $action = this.getAction();
        $.ajax({
          url: 'php/controllers/form.php',
          type: 'POST',
          cache: 'false',
          data: {'action': 'getForm'},
          dataType: 'json',
          success: function(json) {
            if (json) {
              console.log(json);

              let $group = json['group'];
              let $button = json['button'];

              $('.overlay-col100').find('.annotation-group').eq(0).attr('id', $group['14']);
              $('.overlay-col200').find('.annotation-group').eq(0).attr('id', $group['3']);
              $('.overlay-col200').find('.annotation-group').eq(1).attr('id', $group['10']);
              $('.overlay-col300').find('.annotation-group').eq(0).attr('id', $group['11']);
              $('.overlay-col300').find('.annotation-group').eq(1).attr('id', $group['4']);
              $('.overlay-col400').find('.annotation-group').eq(0).attr('id', $group['7']);

              //Set up filtering buttons
              $.each($group, function(i,item){

                if (i != '14') {
                  $('.annotation-list').prepend('<div class="filter-button" id="'+item+'-filter">'+item+'</div>');
                }

              });

              $('.filter-button').wrapAll('<div class="filter-container" />');

              $('.filter-container').prepend('<div class="filter-button" id="all-filter">all</div>');

              $('.overlay-col100').append('<h3 class"group-heading">Notes :</h3><div class="notes"><textarea id="marker-note" type="text" cols="2" rows="2" maxlength="1000" name="note" placeholder="Enter some notes here ..."></textarea></div><button id="marker-submit">Save</button>');
              //Add save and close button
              //Add save and start playing option

              $('.annotation-group').each(function(){

                let $this = $(this);

                let $attrId = $this.attr('id');

                $.each($button, function(i, $button) {

                  let $category = $button['category'];

                  let $html = $button['html'];

                  if ($category == $attrId) {

                    $this.find('ul').append($html);

                  }

                });

              });

            }

          },
            error: function(xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
          }
        });
      }

    userLogin(callback) {
      return $.ajax({
        url: 'php/controllers/login.php',
        type: 'POST',
        cache: 'false',
        data: {'action': 'login', 'email': this.email, 'password': this.password },
        dataType: 'json',
        success: function(json) {

          console.log(json);
          if (json) {
            //Dynamically set video, display username, hide login, and show the main page
            $('.video').attr('src', json.filmUrl);
            $('.user-info').text(json.fullName);
            $('.overlay-login').hide("slow");
            $('.main-page').show("slow");
            let $markers = json.markerArray;

            $.each($markers,function(i, $marker) {

              $('.annotation-list ul').append($marker.html);

              //Add filtering for markers

              if ($marker.note !== "") {

                controls.addFootnote($marker.start, $marker.end, $marker.note, '.annotation-notes');

              }

              //console.log($marker.html);

            });

            //$('.annotation-list ul').append(json.html);
            var markerAjax = new MarkerAjax(null,json.userFilmId, null, null, null, null, json.userId);
            //MarkerAjax.retrieveMarkers(json.userFilmId);
            console.log(markerAjax);
            callback(markerAjax);

          }
        },
        error: function(xhr, desc, err) {
        console.log(xhr);
        console.log("Details: " + desc + "\nError:" + err);
      }

      });

    }

}
