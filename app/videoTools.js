export class VideoController {

      constructor(frame, popcornSelector) {
          self.frame = frame;
          self.popcornSelector = popcornSelector;
          self.popcornInstance = Popcorn(self.popcornSelector);
      }

      getFrame(frame) {
        return self.frame;
      }

      getSelector() {
        return self.popcornSelector;
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
                e.stopPropagation();
                e.preventDefault();
                }
                break;

                case 39: if (self.popcornInstance.currentTime() < self.popcornInstance.duration()) {
                let increment = Math.min(self.popcornInstance.duration(), self.popcornInstance.currentTime() + frame);
                self.popcornInstance.currentTime(increment);
                e.stopPropagation();
                e.preventDefault();
                }
                break;

                case 32: if (play) {
                self.popcornInstance.pause();
                play = false;
                e.stopPropagation();
                e.preventDefault();
                }

                else if ($('#marker-note').is(':focus')) {

                  break;

                }

                else {
                self.popcornInstance.play();
                play = true;
                e.stopPropagation();
                e.preventDefault(); //Have to do these for each keyboard event because we don't want to lose things like cmd+option+i
                }
                break;

            }
            });

      }



      static activeMarker(selector) {
          self.popcornInstance.on( "timeupdate", function() {

                  let time = self.popcornInstance.currentTime();

                  if ($(selector).find('li').data("start") == time) {
                      console.log(time);
                      $(selector).append('<i class=fa fa-film />');
                      }

              });

      }

      static timeScrubbing(selector1,selector2) {

             $(selector1).on('click', selector2, function () {
                  let $timeSec = $(this).parent().data("start");
                  console.log($timeSec);
                  self.popcornInstance.currentTime($timeSec);

                  });
                      return this;
      }


      addFootnote(start,end,note,target){
          self.popcornInstance.footnote({
                                      start: start,
                                      end: end,
                                      text: note + '&nbsp;' + '|' + '&nbsp',
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
