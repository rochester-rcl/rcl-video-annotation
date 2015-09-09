import * as functions from './functions';
import * as playback from './playbackTools'
functions.hello();

var myText = 2003;

var toNum = functions.toHHMMSS(myText);

console.log(toNum);

$(document).ready( function() {

$.ajax({
     url: 'php/pdoConnect.php',
        type: 'POST',
        cache: 'false',
        data: {'action': 'retrieveData', 'filmName': 'Hugo'},
        dataType:'json',
        success: function(json) {
                if (json) {
                    console.log(json);
                    $.each(json, function(i, item) {

                            var $start = item.start;
                            var $end = item.end;
                            var $text = item.text;
                            var $markerType = item.markerType;
                            var $target = item.target;

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

var $timeLog = $('#timeLogButton');

$timeLog.on("click", function (e) {
    var $getTimecode = popcorn.currentTime();
    var $footnoteEnd = $getTimecode + 1;
    var $target = $('#videoNote').attr('id');
    $.ajax({
        url: 'php/pdoConnect.php',
        type: 'post',
        cache: 'false',
        data: {'action': 'postNewRecord', 'timecode': $getTimecode, 'filmName': 'Hugo', 'markerType': 'Scene Change', 'start': $getTimecode, 'end': $footnoteEnd, 'text': 'Scene Change', 'target': $target },
        success: function(json) { //Here return newest record instead
                if (json) {
                    console.log(json);
                    $.each(json, function(i, item) {

                            var $start = item.start;
                            var $end = item.end;
                            var $text = item.text;
                            var $markerType = item.markerType;

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



});
