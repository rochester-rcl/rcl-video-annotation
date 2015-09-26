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

//User properties -- base these on login - write a function in functions.js

let fullName = null;


//The main program

$(document).ready( function() {

  //Login

  $('.user-login').submit(function(event){

    let email = $('#user-email').val();
    let password = $('#user-password').val();
    let user = new UserAjax(email,filmId,fullName,password);

    user.userLogin();

  //Only working once?


  });


  let popcornSelector = ".video";

  let controls = new VideoController(frame, popcornSelector);

  controls.initControls();

  UserAjax.getForm();

  //let markerAjax = new MarkerAjax(filmId, markerId, start, text, target, userId);


});

//1. login - change interface 2. insert 3. filter returned markers 4. delete markers
