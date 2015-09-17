import * as functions from './functions';
import {VideoController} from './playbackTools';
let popcorn = require('popcorn');
let footnote = require('footnote');
let template = require('../index.html');
let frame = 1 / 24; //Most will be 29.97 fps

$(document).ready( function() {

let popcornSelector = "#testVideo";

let controls = new VideoController(frame, popcornSelector);

controls.initControls();

});
