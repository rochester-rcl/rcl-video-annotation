import * as functions from './functions';
import {VideoController} from './playbackTools';
import {Ajax} from './ajax';
let popcorn = require('popcorn');
let footnote = require('footnote');
let frame = 1 / 24; //Most will be 29.97 fps

$(document).ready( function() {

let popcornSelector = "#testVideo";

let controls = new VideoController(frame, popcornSelector);

let action = 'getForm';

let filmId = 0;

let markerType = 0;

let start = 0;

let text = 'blah'

let target = '.markerControl';

controls.initControls();

let myAjax = new Ajax(action, filmId, markerType, start, text, target);

let meh = myAjax.getAction();

let form = myAjax.getForm();

console.log(meh);
});
