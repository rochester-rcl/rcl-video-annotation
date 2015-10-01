import * as functions from './functions';
export class MarkerAjax {

  constructor(id,filmId, markerType, start, note, target, userId) {

     this.id = id;
     this.filmId = filmId;
     this.markerType = markerType;
     this.start = start;
     this.end = start + 1;
     this.note = note;
     this.target = target;
     this.userId = userId;


   }

  setId(id) {
    this.id = id;
  }
  getId() {
    return this.id;
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

  setNote(note) {
    this.note = note;
  }

  getNote() {
    return this.note;
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

deleteMarker() {
  return $.ajax({
    url: 'php/controllers/delete.php',
    type: 'POST',
    cache: 'false',
    data: {'action': 'deleteMarker', 'filmMarkerId': this.id }, //film id marker start end target user id - check php object
    dataType: 'json',
    success: function(json) {

      console.log(json.message);

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
      'end': this.end, 'note': this.note, 'target': this.target, 'userId': this.userId }, //film id marker start end target user id - check php object
      dataType: 'json',
      success: function(json) {

        let $markers = json.markerArray;

        $('.annotation-list ul').empty();
        $.each($markers,function(i, $marker) {

          $('.annotation-list ul').append($marker.html);
          console.log($marker.html);

        });



      },
      error: function(xhr, desc, err) {
      console.log(xhr);
      console.log("Details: " + desc + "\nError:" + err);
    }

    });

  }

}
