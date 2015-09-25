
//Set up a prototype for the String class to convert seconds (float) to HHMMSS format for display
    export function toHHMMSS(theInt){
    let secNum = parseInt(theInt, 10);
    let hours = Math.floor(secNum / 3600);
    let minutes = Math.floor((secNum - (hours * 3600)) / 60);
    let seconds = secNum - (hours * 3600) - (minutes * 60);

    if (hours < 10) {
        hours = "0" + hours;
    }
    if (minutes < 10) {
        minutes = "0" + minutes;
    }
     if (seconds < 10) {
        seconds = "0" + seconds;
    }
    let time = hours + ":" + minutes + ":" + seconds;
    return time;
};

export function appendHTML(selector,text,start){
    $(selector).append('<div href="#" class="sceneChangeMark"><div class="sceneChangeText">' + text + '&nbsp' + start.toHHMMSS() + '</div><div class="sceneChangeTimeSec">'+ start +'</div></div>');
    return this;
    };

export function changeHTML(selector,text,start){
    $(selector).html('<h4 class="recentMarker">Most Recent Marker Selected: &nbsp;</h2><div href="#" class="sceneChangeMark"><div class="sceneChangeText">' + text + '&nbsp' + start.toHHMMSS() + '</div><div class="sceneChangeTimeSec">'+ start +'</div></div>');
    return this;
    };

export function iteratorCallback(selector,sliceMin,sliceMax) {
    return function() {
        $(selector).hide();
        $(selector).slice(sliceMin,sliceMax).show();

        };
    };


export function addPagination(selector,maxResults){

    let $maxNoOfResults = maxResults;
    let $totalResults = $(selector).length;
    let $totalPages = Math.ceil($totalResults / $maxNoOfResults);

    $(selector).hide();

    console.log('Total pages'+' '+$totalPages);

    for (i=0; i < $totalPages; i++) {
        let $tempNo = $maxNoOfResults + 1;
        let $pageOne = i + 1;
        $pageButton = '#page-' + i + '-button';
        if(i === 0) {

            console.log('Should be first loop');
            console.log('0 '+$maxNoOfResults);
            $('.markerSelectButtons').append('<a id="page-'+i+'-button">Page '+$pageOne+'</a>');
            $('.markerSelectButtons').on('click', '#page-'+i+'-button', iteratorCallback(selector,0,$tempNo));

        }

        if (i > 0) {
            $tempNo = i + 1;
            $sliceMax = ($tempNo * $maxNoOfResults) + 1;
            $sliceMin = $sliceMax - $maxNoOfResults;

            $('.page-'+i).css('display', 'none');
            console.log('Should be loop'+' '+i);
            console.log($sliceMin, $sliceMax);
            $('.markerSelectButtons').append('<a id="page-'+i+'-button">Page '+$pageOne+'</a>');
            $('.markerSelectButtons').on('click', '#page-'+i+'-button', iteratorCallback(selector,$sliceMin,$sliceMax));

        }
    };

    return this;
    }
