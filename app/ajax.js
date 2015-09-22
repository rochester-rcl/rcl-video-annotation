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
      dataType: 'html',
      success: function(html) {
        if (html) {
          console.log(html),
            $('.markerControl').append(html);
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
