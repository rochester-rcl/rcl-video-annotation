import * as functions from './functions';
export class MarkerAjax {

  constructor(filmId, markerType, start, text, target, userId) {

     this.filmId = filmId;
     this.markerType = markerType;
     this.start = start;
     this.end = start + 1;
     this.text = text;
     this.target = target;
     this.userId = userId;

   }


  setAction(action) {
    this.action = action;
  }

  getAction() {
    return this.action;
  }

  setFilmId(filmId) {
    this.filmId = filmId;
  }

  setMarkerType(markerType) {
    this.markerType = markerType;
  }

  setStart(start) {
    this.start = start;
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

  insertMarker() {
     $.ajax({
     url: 'php/pdoConnect.php',
        type: 'POST',
        cache: 'false',
        data: {'action': this.action, 'filmId': this.filmId, 'markerType': this.markerType, 'start': this.start,
        'end': this.end, 'text': this.text, 'target': this.target, 'userId': this.target},
        dataType:'html',
        success: function(html) {
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

}
