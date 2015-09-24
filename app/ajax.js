import * as functions from './functions';
export class Ajax {

  constructor(action, filmId, markerType, start, text, target) {

     self.action = action;
     self.filmId = filmId;
     self.markerType = markerType;
     self.start = start;
     self.end = start + 1;
     self.text = text;
     self.target = target;

   }


  setAction(action) {
    self.action = action;
  }

  getAction() {
    return self.action;
  }

  setFilmId(filmId) {
    self.filmId = filmId;
  }

  setMarkerType(markerType) {
    self.markerType = markerType;
  }

  setStart(start) {
    self.start = start;
  }

  getForm() {
    $.ajax({
      url: 'php/controllers/form.php',
      type: 'POST',
      cache: 'false',
      data: {'action': this.action},
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


          /*$('#top-level').find('ul').append(json['2']);
          $('#top-level').find('ul').append(json['']);
          $('#top-level').find('ul').append(json['sequence']);
          $('#top-level').find('ul').append(json['turning-points']); */



        }
      },
        error: function(xhr, desc, err) {
        console.log(xhr);
        console.log("Details: " + desc + "\nError:" + err);
      }
    });
  }

  retrieveMarker() {
     $.ajax({
     url: 'php/pdoConnect.php',
        type: 'POST',
        cache: 'false',
        data: {'action': this.action, 'filmId': this.filmId, 'markerType': this.markerType},
        dataType:'html',
        success: function(json) {
                if (html) {
                    console.log(html);
                }
            },
        error: function(xhr, desc, err) {
        console.log(xhr);
        console.log("Details: " + desc + "\nError:" + err);
        }
    });

}

insertMarker() {  $.ajax({
     url: 'php/pdoConnect.php',
        type: 'POST',
        cache: 'false',
        data: {'action': this.action, 'filmId': this.filmId, 'markerType': this.markerType, 'start': this.start,
        'end': this.end, 'text': this.text, 'target': this.target},
        dataType:'html',
        success: function(html) {
                if (html) {
                    console.log(html);


                    //

                }
            },
        error: function(xhr, desc, err) {
        console.log(xhr);
        console.log("Details: " + desc + "\nError:" + err);
        }
    });





}

}
