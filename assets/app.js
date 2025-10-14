import "./bootstrap.js";
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import "./styles/app.css";
import "./burger-menu.js";
import "./styles/ckeditor.css"; // add this line

console.log("This log comes from assets/app.js - welcome to AssetMapper! 🎉");

// Wait 5 seconds (5000 ms), then fade out and remove messages
function fadeFlashes() {
   document.querySelectorAll('.flash-message, .alert').forEach(el => {
       setTimeout(() => {
           el.style.transition = "opacity 0.5s ease";
           el.style.opacity = "0";
           setTimeout(() => el.remove(), 500);
       }, 5000);
   });
}

document.addEventListener("DOMContentLoaded", fadeFlashes);
document.addEventListener("turbo:load", fadeFlashes);