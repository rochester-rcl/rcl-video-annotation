import * as functions from './functions';

export class UserAjax {

    constructor(email,filmUrl,fullName,password) {

      this.email = email;
      this.fullName = fullName;
      this.password = password;
      this.filmUrl = filmUrl;

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

              $('.overlay-col100').find('.annotation-group').eq(0).attr('id', 'top-level');
              $('.overlay-col200').find('.annotation-group').eq(0).attr('id', $group['3']);
              $('.overlay-col200').find('.annotation-group').eq(1).attr('id', $group['10']);
              $('.overlay-col300').find('.annotation-group').eq(0).attr('id', $group['11']);
              $('.overlay-col300').find('.annotation-group').eq(1).attr('id', $group['4']);
              $('.overlay-col400').find('.annotation-group').eq(0).attr('id', $group['7']);

              $('.annotation-group').each(function(i, elem){

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

    userLogin() {
      $.ajax({
        url: 'php/controllers/login.php',
        type: 'POST',
        cache: 'false',
        data: {'action': 'login', 'email': this.email, 'password': this.password },
        dataType: 'json',
        success: function(json) {
          if (json) {
            console.log(json);

            $('.overlay-login').swing("slow");
          }

        },
        error: function(xhr, desc, err) {
        console.log(xhr);
        console.log("Details: " + desc + "\nError:" + err);
      }
      });

    }

}
