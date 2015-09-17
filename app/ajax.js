class Ajax {

  constructor(action, filmId, markerType, start, target) {

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

  setFilmId(filmId) {
    self.filmId = filmId;
  }

  setMarkerType(markerType) {
    self.markerType = markerType;
  }

  retrieveMarker() {
     $.ajax({
     url: 'php/pdoConnect.php',
        type: 'POST',
        cache: 'false',
        data: {'action': self.action, 'filmId': self.filmId},
        dataType:'json',
        success: function(json) {
                if (json) {
                    console.log(json);
                    $.each(json, function(i, item) {

                            let $start = item.start;
                            let $end = item.end;
                            let $text = item.text;
                            let $markerType = item.markerType;
                            let $target = item.target;

                            functions.addFootnote($start,$end,$text,$target);
                            functions.markerHighlight('.sceneChangeMark',$start,$end,$text,i);
                           //Write switch case for all marker categories?

                            if ($markerType === 'Scene Change') {
                                    functions.appendHTML('.sceneChangeMarkers',$text,$start);
                                }
                      });
                    functions.timeScrubbing('.sceneChangeMarkers','.sceneChangeMark');
                    functions.addPagination('.sceneChangeMark',25);
                    functions.timeScrubbing('#markersDiv2','.sceneChangeMark');
                }
            },
        error: function(xhr, desc, err) {
        console.log(xhr);
        console.log("Details: " + desc + "\nError:" + err);
        }
    });

let $timeLog = $('#timeLogButton');

$timeLog.on("click", function (e) {
    let $getTimecode = popcorn.currentTime();
    let $footnoteEnd = $getTimecode + 1;
    let $target = $('#videoNote').attr('id');
    $.ajax({
        url: 'php/pdoConnect.php',
        type: 'post',
        cache: 'false',
        data: {'action': 'postNewRecord', 'timecode': $getTimecode, 'filmName': 'Hugo', 'markerType': 'Scene Change', 'start': $getTimecode, 'end': $footnoteEnd, 'text': 'Scene Change', 'target': $target },
        success: function(json) { //Here return newest record instead
                if (json) {
                    console.log(json);
                    $.each(json, function(i, item) {

                            let $start = item.start;
                            let $end = item.end;
                            let $text = item.text;
                            let $markerType = item.markerType;

                            popcorn.footnote({
                                start: $start,
                                end: $end,
                                text: $text + '&nbsp;' + '|' + '&nbsp',
                                target: $target
                            });

                            if ($markerType === 'Scene Change') {
                                    functions.appendHTML('.sceneChangeMarkers',$text,$start);
                                }
                      });
                    functions.timeScrubbing('.sceneChangeMarkers','.sceneChangeMark');
                    functions.addPagination('#markerSelectButtons',25);
                }
            },
        error: function(xhr, desc, err) {
        console.log(xhr);
        console.log("Details: " + desc + "\nError:" + err);
        }
    });
    e.preventDefault();


});

}

insertMarker() {  $.ajax({
     url: 'php/pdoConnect.php',
        type: 'POST',
        cache: 'false',
        data: {'action': 'retrieveData', 'filmName': 'Hugo'},
        dataType:'json',
        success: function(json) {
                if (json) {
                    console.log(json);
                    $.each(json, function(i, item) {

                            let $start = item.start;
                            let $end = item.end;
                            let $text = item.text;
                            let $markerType = item.markerType;
                            let $target = item.target;

                            functions.addFootnote($start,$end,$text,$target);
                            functions.markerHighlight('.sceneChangeMark',$start,$end,$text,i);
                           //Write switch case for all marker categories?

                            if ($markerType === 'Scene Change') {
                                    functions.appendHTML('.sceneChangeMarkers',$text,$start);
                                }
                      });
                    functions.timeScrubbing('.sceneChangeMarkers','.sceneChangeMark');
                    functions.addPagination('.sceneChangeMark',25);
                    functions.timeScrubbing('#markersDiv2','.sceneChangeMark');
                }
            },
        error: function(xhr, desc, err) {
        console.log(xhr);
        console.log("Details: " + desc + "\nError:" + err);
        }
    });

let $timeLog = $('#timeLogButton');

$timeLog.on("click", function (e) {
    let $getTimecode = popcorn.currentTime();
    let $footnoteEnd = $getTimecode + 1;
    let $target = $('#videoNote').attr('id');
    $.ajax({
        url: 'php/pdoConnect.php',
        type: 'post',
        cache: 'false',
        data: {'action': 'postNewRecord', 'timecode': $getTimecode, 'filmName': 'Hugo', 'markerType': 'Scene Change', 'start': $getTimecode, 'end': $footnoteEnd, 'text': 'Scene Change', 'target': $target },
        success: function(json) { //Here return newest record instead
                if (json) {
                    console.log(json);
                    $.each(json, function(i, item) {

                            let $start = item.start;
                            let $end = item.end;
                            let $text = item.text;
                            let $markerType = item.markerType;

                            popcorn.footnote({
                                start: $start,
                                end: $end,
                                text: $text + '&nbsp;' + '|' + '&nbsp',
                                target: $target
                            });

                            if ($markerType === 'Scene Change') {
                                    functions.appendHTML('.sceneChangeMarkers',$text,$start);
                                }
                      });
                    functions.timeScrubbing('.sceneChangeMarkers','.sceneChangeMark');
                    functions.addPagination('#markerSelectButtons',25);
                }
            },
        error: function(xhr, desc, err) {
        console.log(xhr);
        console.log("Details: " + desc + "\nError:" + err);
        }
    });
    e.preventDefault();


});



}

}
