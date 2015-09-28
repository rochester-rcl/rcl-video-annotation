//Class and function imports
import * as functions from './functions';
import {VideoController} from './videoTools';
import {MarkerAjax} from './markerAjax';
import {UserAjax} from './userAjax';

//Video properties
let popcorn = require('popcorn');
let footnote = require('footnote');
let frame = 1 / 24; //Most will be 29.97 fps

//Marker properties


//User properties -- base these on login - write a function in functions.js


//The main program

$(document).ready( function() {

  //First we initialize our contols and player
  let popcornSelector = ".video";

  window.controls = new VideoController(frame, popcornSelector);

  controls.initControls();

  UserAjax.getForm(); //Statically calling getForm to get our buttons for the overlay

  //Login


  functions.userAjaxSubmit(functions.logAjax);

});

  //console.log(markerAjax);
  //Here a new MarkerAjax object is returned - it looks like this: let markerAjax = new MarkerAjax(filmId, markerId, start, text, target, userId);


//1. login - change interface 2. insert 3. filter returned markers 4. delete markers
