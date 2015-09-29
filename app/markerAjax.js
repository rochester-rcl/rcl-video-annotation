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

  setEnd(start) {
    this.end = start + 1;
  }

  getEnd() {
    return this.end;
  }

  static retrieveMarkers() {
     $.ajax({
     url: 'php/pdoConnect.php',
        type: 'POST',
        cache: 'false',
        data: {'action': this.action, 'filmId': this.filmId},
        dataType:'html',
        success: function(json) {
                if (json) {
                    console.log(json); //Make sure we do some popcorn stuff w/ the markers so when you click them they take you to that point in the video
                    //plus handle user info based on insert.php return - should be the same just a loop
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
      data: {'action': 'insertMarker', 'filmId': this.filmId, 'markerId': this.markerType, 'start': this.start,
      'end': this.end, 'text': this.text, 'target': this.target, 'userId': this.userId }, //film id marker start end target user id - check php object
      dataType: 'json',
      success: function(json) {
        $('.annotation-list ul').append(json.html);
        console.log(json.html);

      },
      error: function(xhr, desc, err) {
      console.log(xhr);
      console.log("Details: " + desc + "\nError:" + err);
    }

    });

  }

}
