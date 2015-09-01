 //Global variables
        var frame = 1 / 24; //Most will be 29.97 fps
        var play = true;
        var popcorn = Popcorn("#testVideo");

        /*popcorn.on( "timeupdate", function() {
            var time = this.currentTime();
            var timeToString = time.toString();
            var timeHHMMSS = timeToString.toHHMMSS();
            
            console.log(timeHHMMSS);
        });*/
        
        $(document).ready( function() {
            
            $(document).keydown(function(e) {
                switch (e.keyCode) { 
         
                    case 37:  if (popcorn.currentTime() > 0) { 
                    $decrement = popcorn.currentTime() - frame;
                    popcorn.currentTime($decrement);
                    }
                    break;
                
                    case 39: if (popcorn.currentTime() < popcorn.duration()) {
                    $increment = Math.min(popcorn.duration(), popcorn.currentTime() + frame);
                    popcorn.currentTime($increment);
                    }
                    break;
                    
                    case 32: if (play) { 
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