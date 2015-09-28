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

  getFilmId() {
    return this.filmId;
  }

  setMarkerType(markerType) {
    this.markerType = markerType;
  }

  getMarkerType() {
    return this.markerType;
  }

  setStart(start) {
    this.start = start;
  }

  getStart() {
    return this.start;
  }

  setText(text) {
    this.text = text;
  }

  getText() {
    return this.text;
  }

  setTarget(target) {
    this.target = target;
  }

  getTarget() {
    return this.target;
  }

  static retrieveMarkers() {
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
    return $.ajax({
      url: 'php/controllers/insert.php',
      type: 'POST',
      cache: 'false',
      data: {'action': 'insert', 'email': this.email, 'password': this.password }, //film id marker start end target user id - check php object
      dataType: 'json',
      error: function(xhr, desc, err) {
      console.log(xhr);
      console.log("Details: " + desc + "\nError:" + err);
    }

    });

  }

}
