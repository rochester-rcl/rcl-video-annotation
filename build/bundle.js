/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	function _interopRequireWildcard(obj) { if (obj && obj.__esModule) { return obj; } else { var newObj = {}; if (obj != null) { for (var key in obj) { if (Object.prototype.hasOwnProperty.call(obj, key)) newObj[key] = obj[key]; } } newObj['default'] = obj; return newObj; } }

	var _functions = __webpack_require__(1);

	var functions = _interopRequireWildcard(_functions);

	var _playbackTools = __webpack_require__(2);

	var playback = _interopRequireWildcard(_playbackTools);

	functions.hello();

	var myText = 2003;

	var toNum = functions.toHHMMSS(myText);

	console.log(toNum);

	$(document).ready(function () {

	    $.ajax({
	        url: 'php/pdoConnect.php',
	        type: 'POST',
	        cache: 'false',
	        data: { 'action': 'retrieveData', 'filmName': 'Hugo' },
	        dataType: 'json',
	        success: function success(json) {
	            if (json) {
	                console.log(json);
	                $.each(json, function (i, item) {

	                    var $start = item.start;
	                    var $end = item.end;
	                    var $text = item.text;
	                    var $markerType = item.markerType;
	                    var $target = item.target;

	                    functions.addFootnote($start, $end, $text, $target);
	                    functions.markerHighlight('.sceneChangeMark', $start, $end, $text, i);
	                    //Write switch case for all marker categories?

	                    if ($markerType === 'Scene Change') {
	                        functions.appendHTML('.sceneChangeMarkers', $text, $start);
	                    }
	                });
	                functions.timeScrubbing('.sceneChangeMarkers', '.sceneChangeMark');
	                functions.addPagination('.sceneChangeMark', 25);
	                functions.timeScrubbing('#markersDiv2', '.sceneChangeMark');
	            }
	        },
	        error: function error(xhr, desc, err) {
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
	            data: { 'action': 'postNewRecord', 'timecode': $getTimecode, 'filmName': 'Hugo', 'markerType': 'Scene Change', 'start': $getTimecode, 'end': $footnoteEnd, 'text': 'Scene Change', 'target': $target },
	            success: function success(json) {
	                //Here return newest record instead
	                if (json) {
	                    console.log(json);
	                    $.each(json, function (i, item) {

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
	                            functions.appendHTML('.sceneChangeMarkers', $text, $start);
	                        }
	                    });
	                    functions.timeScrubbing('.sceneChangeMarkers', '.sceneChangeMark');
	                    functions.addPagination('#markerSelectButtons', 25);
	                }
	            },
	            error: function error(xhr, desc, err) {
	                console.log(xhr);
	                console.log("Details: " + desc + "\nError:" + err);
	            }
	        });
	        e.preventDefault();
	    });
	});

/***/ },
/* 1 */
/***/ function(module, exports) {

	

	//Set up a prototype for the String class to convert seconds (float) to HHMMSS format for display
	"use strict";

	Object.defineProperty(exports, "__esModule", {
	    value: true
	});
	exports.toHHMMSS = toHHMMSS;
	exports.appendHTML = appendHTML;
	exports.changeHTML = changeHTML;
	exports.iteratorCallback = iteratorCallback;
	exports.addPagination = addPagination;
	exports.scrubMode = scrubMode;
	exports.timeScrubbing = timeScrubbing;
	exports.addFootnote = addFootnote;
	exports.markerHighlight = markerHighlight;
	exports.hello = hello;

	function toHHMMSS(theInt) {
	    var secNum = parseInt(theInt, 10);
	    var hours = Math.floor(secNum / 3600);
	    var minutes = Math.floor((secNum - hours * 3600) / 60);
	    var seconds = secNum - hours * 3600 - minutes * 60;

	    if (hours < 10) {
	        hours = "0" + hours;
	    }
	    if (minutes < 10) {
	        minutes = "0" + minutes;
	    }
	    if (seconds < 10) {
	        seconds = "0" + seconds;
	    }
	    var time = hours + ":" + minutes + ":" + seconds;
	    return time;
	}

	;

	function appendHTML(selector, text, start) {
	    $(selector).append('<div href="#" class="sceneChangeMark"><div class="sceneChangeText">' + text + '&nbsp' + start.toHHMMSS() + '</div><div class="sceneChangeTimeSec">' + start + '</div></div>');
	    return this;
	}

	;

	function changeHTML(selector, text, start) {
	    $(selector).html('<h4 class="recentMarker">Most Recent Marker Selected: &nbsp;</h2><div href="#" class="sceneChangeMark"><div class="sceneChangeText">' + text + '&nbsp' + start.toHHMMSS() + '</div><div class="sceneChangeTimeSec">' + start + '</div></div>');
	    return this;
	}

	;

	function iteratorCallback(selector, sliceMin, sliceMax) {
	    return function () {
	        $(selector).hide();
	        $(selector).slice(sliceMin, sliceMax).show();
	    };
	}

	;

	function addPagination(selector, maxResults) {

	    var $maxNoOfResults = maxResults;
	    var $totalResults = $(selector).length;
	    var $totalPages = Math.ceil($totalResults / $maxNoOfResults);

	    $(selector).hide();

	    console.log('Total pages' + ' ' + $totalPages);

	    for (i = 0; i < $totalPages; i++) {
	        var $tempNo = $maxNoOfResults + 1;
	        var $pageOne = i + 1;
	        $pageButton = '#page-' + i + '-button';
	        if (i === 0) {

	            console.log('Should be first loop');
	            console.log('0 ' + $maxNoOfResults);
	            $('.markerSelectButtons').append('<a id="page-' + i + '-button">Page ' + $pageOne + '</a>');
	            $('.markerSelectButtons').on('click', '#page-' + i + '-button', iteratorCallback(selector, 0, $tempNo));
	        }

	        if (i > 0) {
	            $tempNo = i + 1;
	            $sliceMax = $tempNo * $maxNoOfResults + 1;
	            $sliceMin = $sliceMax - $maxNoOfResults;

	            $('.page-' + i).css('display', 'none');
	            console.log('Should be loop' + ' ' + i);
	            console.log($sliceMin, $sliceMax);
	            $('.markerSelectButtons').append('<a id="page-' + i + '-button">Page ' + $pageOne + '</a>');
	            $('.markerSelectButtons').on('click', '#page-' + i + '-button', iteratorCallback(selector, $sliceMin, $sliceMax));
	        }
	    };

	    return this;
	}

	//Popcorn functions

	function scrubMode(selector) {
	    popcorn.on("timeupdate", function () {
	        var time = popcorn.currentTime();

	        if ($(selector + ':contains(' + time + ')')) {
	            console.log(time);
	            $(selector + ':contains(' + time + ')').css({ 'color': 'red' });
	        }
	    });
	}

	;

	function timeScrubbing(selector1, selector2) {
	    $(selector1).on('click', selector2, function () {
	        var $timeSec = $(this).find('.sceneChangeTimeSec').text();
	        console.log($timeSec);
	        popcorn.currentTime($timeSec);
	    });
	    return this;
	}

	;

	function addFootnote(start, end, text, target) {
	    popcorn.footnote({
	        start: start,
	        end: end,
	        text: text + '&nbsp;' + '|' + '&nbsp',
	        target: target
	    });
	}

	function markerHighlight(selector, start, end, text, i) {

	    popcorn.code({
	        start: start,
	        end: end,
	        onStart: function onStart() {
	            var $tempNo = i + 1;
	            changeHTML('#markersDiv2', text, start);
	            $(selector + ':nth-child(' + $tempNo + ')').css({ 'color': 'red' });
	            console.log(selector + ':nth-child(' + $tempNo + ')');
	        },
	        onEnd: function onEnd() {
	            $(selector).css({ 'color': '#000' });
	        }
	    });
	}

	function hello() {
	    console.log('hello');
	}

/***/ },
/* 2 */
/***/ function(module, exports) {

	//Global variables
	"use strict";

	var frame = 1 / 24; //Most will be 29.97 fps
	var play = true;
	var popcorn = Popcorn("#testVideo");

	/*popcorn.on( "timeupdate", function() {
	    var time = this.currentTime();
	    var timeToString = time.toString();
	    var timeHHMMSS = timeToString.toHHMMSS();
	    
	    console.log(timeHHMMSS);
	});*/

	$(document).ready(function () {

	    $(document).keydown(function (e) {
	        switch (e.keyCode) {

	            case 37:
	                if (popcorn.currentTime() > 0) {
	                    $decrement = popcorn.currentTime() - frame;
	                    popcorn.currentTime($decrement);
	                }
	                break;

	            case 39:
	                if (popcorn.currentTime() < popcorn.duration()) {
	                    $increment = Math.min(popcorn.duration(), popcorn.currentTime() + frame);
	                    popcorn.currentTime($increment);
	                }
	                break;

	            case 32:
	                if (play) {
	                    popcorn.pause();
	                    play = false;
	                } else {
	                    popcorn.play();
	                    play = true;
	                }
	                break;

	        }
	    });
	});

/***/ }
/******/ ]);