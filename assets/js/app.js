/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';
import axios from 'axios';
import { config } from '@fortawesome/fontawesome-svg-core'

function init() {
  gapi.load('auth2', function() {
    client_id: '798194073310-46u2j7i62dopv0l5jffmb7nubn0stmeu.apps.googleusercontent.com'
    fetch_basic_profile: false,
    console.log(client_id);
  });
  auth2.signIn().then(function() {

  });
}



// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');