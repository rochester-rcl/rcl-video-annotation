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
let filmId = 0;
let markerId = 0;
let start = 0;
let text = 'blah';
let target = '.markerControl';
let userId = 1;

//User properties
let email = 'jromphf@library.rochester.edu';
let password = 'DigitalHum15';
let fullName = 'Josh Romphf';


//The main program

$(document).ready( function() {

  //Login
  let user = new UserAjax(email,filmId,fullName,password);

  let userPassword = user.getPassword();

  console.log(userPassword);

  user.userLogin();

  let popcornSelector = ".testVideo";

  let controls = new VideoController(frame, popcornSelector);

  controls.initControls();

  UserAjax.getForm();

  //let markerAjax = new MarkerAjax(filmId, markerId, start, text, target, userId);


});
