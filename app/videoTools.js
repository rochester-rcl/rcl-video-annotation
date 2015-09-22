export class VideoController {

      constructor(frame, popcornSelector) {
          self.frame = frame;
          self.popcornSelector = popcornSelector;
          self.popcornInstance = Popcorn(self.popcornSelector);
      }

      getTime() {
        return self.popcornInstance.currentTime();
      }

      initControls() {
        let play = true;
        let frame =  self.frame;

        $(document).keydown(function(e) {
            switch (e.keyCode) {
                case 37:  if (self.popcornInstance.currentTime() > 0) {
                let decrement = self.popcornInstance.currentTime() - frame;
                self.popcornInstance.currentTime(decrement);
                }
                break;

                case 39: if (self.popcornInstance.currentTime() < self.popcornInstance.duration()) {
                let increment = Math.min(self.popcornInstance.duration(), self.popcornInstance.currentTime() + frame);
                self.popcornInstance.currentTime(increment);
                }
                break;

                case 32: if (play) {
                self.popcornInstance.pause();
                play = false;
                } else {
                self.popcornInstance.play();
                play = true;
                }
                break;

            }
            });

      }

      scrubMode(selector) {
          self.popcornInstance.on( "timeupdate", function() {
                  let time = self.popcornInstance.currentTime();

                  if ($(selector+':contains('+time+')')){
                      console.log(time);
                      $(selector+':contains('+time+')').css({'color': 'red'});
                      }

              });

      };

      timeScrubbing(selector1,selector2) {

             $(selector1).on('click', selector2, function () {
                  let $timeSec = $(this).find('.sceneChangeTimeSec').text();
                  console.log($timeSec);
                  self.popcornInstance.currentTime($timeSec);

                  });
                      return this;
      };

      addFootnote(start,end,text,target){
          self.popcornInstance.footnote({
                                      start: start,
                                      end: end,
                                      text: text + '&nbsp;' + '|' + '&nbsp',
                                      target: target
                                  });
      }

      markerHighlight(selector,start,end,text,i) {

           self.popcornInstance.code({
                          start: start,
                          end: end,
                          onStart: function() {
                                          let $tempNo = i + 1;
                                          changeHTML('#markersDiv2',text,start);
                                          $(selector+':nth-child('+$tempNo+')').css({'color': 'red'});
                                          console.log(selector+':nth-child('+$tempNo+')');
                                         },
                          onEnd: function() {
                                          $(selector).css({'color': '#000'});
                                         }
                                   });

      }


}
