(self["webpackChunkapplication_tickets_bug"] = self["webpackChunkapplication_tickets_bug"] || []).push([["app"],{

/***/ "./assets/app.js":
/*!***********************!*\
  !*** ./assets/app.js ***!
  \***********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _styles_app_css__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./styles/app.css */ "./assets/styles/app.css");
/* harmony import */ var _styles_ckeditor_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./styles/ckeditor.css */ "./assets/styles/ckeditor.css");
/* harmony import */ var _upload_img_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./upload_img.js */ "./assets/upload_img.js");
/* harmony import */ var _upload_img_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_upload_img_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _burger_menu_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./burger-menu.js */ "./assets/burger-menu.js");
/* harmony import */ var _burger_menu_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_burger_menu_js__WEBPACK_IMPORTED_MODULE_3__);
// import "./bootstrap.js";
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */

 // add this line




// console.log("This log comes from assets/app.js - welcome to AssetMapper! 🎉");

// Wait 5 seconds (5000 ms), then fade out and remove messages
function fadeFlashes() {
  document.querySelectorAll('.flash-message, .alert').forEach(function (el) {
    setTimeout(function () {
      el.style.transition = "opacity 0.5s ease";
      el.style.opacity = "0";
      setTimeout(function () {
        return el.remove();
      }, 500);
    }, 5000);
  });
}
document.addEventListener("DOMContentLoaded", fadeFlashes);
document.addEventListener("turbo:load", fadeFlashes);

/***/ }),

/***/ "./assets/burger-menu.js":
/*!*******************************!*\
  !*** ./assets/burger-menu.js ***!
  \*******************************/
/***/ (() => {

/**
 * Menu Burger - Gestion de l'ouverture/fermeture
 */

var burgerInitialized = false;
var burgerMenu, mainNav, body;
function toggleMenu() {
  if (burgerMenu && mainNav && body) {
    burgerMenu.classList.toggle('active');
    mainNav.classList.toggle('active');
    body.classList.toggle('menu-open');
  }
}
function closeMenu() {
  if (burgerMenu && mainNav && body) {
    burgerMenu.classList.remove('active');
    mainNav.classList.remove('active');
    body.classList.remove('menu-open');
  }
}
function handleBurgerClick(e) {
  e.stopPropagation();
  toggleMenu();
}
function handleBodyClick(e) {
  if (body && body.classList.contains('menu-open') && mainNav && !mainNav.contains(e.target) && burgerMenu && !burgerMenu.contains(e.target)) {
    closeMenu();
  }
}
function handleEscapeKey(e) {
  if (e.key === 'Escape' && body && body.classList.contains('menu-open')) {
    closeMenu();
  }
}
var resizeTimer;
function handleResize() {
  clearTimeout(resizeTimer);
  resizeTimer = setTimeout(function () {
    if (window.innerWidth > 768 && body && body.classList.contains('menu-open')) {
      closeMenu();
    }
  }, 250);
}
function updateDOMReferences() {
  // Mettre à jour les références DOM à chaque navigation
  burgerMenu = document.getElementById('burgerMenu');
  mainNav = document.getElementById('mainNav');
  body = document.body;
}
function initBurgerMenu() {
  updateDOMReferences();
  if (!burgerMenu || !mainNav) {
    return;
  }

  // Initialiser les event listeners globaux une seule fois
  if (!burgerInitialized) {
    burgerInitialized = true;

    // Event listeners sur les éléments qui ne changent pas
    document.addEventListener('click', function (e) {
      // Vérifier si c'est le bouton burger
      if (e.target.closest('#burgerMenu')) {
        e.stopPropagation();
        toggleMenu();
      }
      // Fermer le menu si clic en dehors
      else if (body.classList.contains('menu-open') && !e.target.closest('#mainNav')) {
        closeMenu();
      }
    });
    document.addEventListener('keydown', handleEscapeKey);
    window.addEventListener('resize', handleResize);
  }

  // Fermer le menu au clic sur un lien de navigation (à chaque turbo:load)
  if (mainNav) {
    var navLinks = mainNav.querySelectorAll('a');
    navLinks.forEach(function (link) {
      link.addEventListener('click', function () {
        closeMenu();
      });
    });
  }
}

// Initialiser au chargement de la page et lors des navigations Turbo
document.addEventListener('DOMContentLoaded', initBurgerMenu);
document.addEventListener('turbo:load', initBurgerMenu);

/***/ }),

/***/ "./assets/styles/app.css":
/*!*******************************!*\
  !*** ./assets/styles/app.css ***!
  \*******************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./assets/styles/ckeditor.css":
/*!************************************!*\
  !*** ./assets/styles/ckeditor.css ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "./assets/upload_img.js":
/*!******************************!*\
  !*** ./assets/upload_img.js ***!
  \******************************/
/***/ (() => {

// Lightbox pour agrandir les images
document.addEventListener('DOMContentLoaded', function () {
  var lightbox = document.getElementById('image-lightbox');
  var lightboxImg = document.getElementById('lightbox-image');
  var closeBtn = document.querySelector('.lightbox-close');

  // Ouvrir la lightbox au clic sur une image
  document.querySelectorAll('.clickable-image').forEach(function (img) {
    img.addEventListener('click', function () {
      lightbox.style.display = 'flex';
      lightboxImg.src = this.src;
      lightboxImg.alt = this.alt;
    });
  });

  // Fermer la lightbox
  if (closeBtn) {
    closeBtn.addEventListener('click', function () {
      lightbox.style.display = 'none';
    });
  }

  // Fermer en cliquant en dehors de l'image
  lightbox.addEventListener('click', function (e) {
    if (e.target === lightbox) {
      lightbox.style.display = 'none';
    }
  });

  // Fermer avec la touche Échap
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && lightbox.style.display === 'flex') {
      lightbox.style.display = 'none';
    }
  });
});

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ var __webpack_exports__ = (__webpack_exec__("./assets/app.js"));
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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Q0FBQ0EsR0FBRztJQUM5QixDQUFDLENBQUM7RUFDTixDQUFDLENBQUM7O0VBRUY7RUFDQSxJQUFJTCxRQUFRLEVBQUU7SUFDVkEsUUFBUSxDQUFDOUIsZ0JBQWdCLENBQUMsT0FBTyxFQUFFLFlBQVc7TUFDMUM0QixRQUFRLENBQUNoQyxLQUFLLENBQUNxQyxPQUFPLEdBQUcsTUFBTTtJQUNuQyxDQUFDLENBQUM7RUFDTjs7RUFFQTtFQUNBTCxRQUFRLENBQUM1QixnQkFBZ0IsQ0FBQyxPQUFPLEVBQUUsVUFBU1UsQ0FBQyxFQUFFO0lBQzNDLElBQUlBLENBQUMsQ0FBQ0ksTUFBTSxLQUFLYyxRQUFRLEVBQUU7TUFDdkJBLFFBQVEsQ0FBQ2hDLEtBQUssQ0FBQ3FDLE9BQU8sR0FBRyxNQUFNO0lBQ25DO0VBQ0osQ0FBQyxDQUFDOztFQUVGO0VBQ0ExQyxRQUFRLENBQUNTLGdCQUFnQixDQUFDLFNBQVMsRUFBRSxVQUFTVSxDQUFDLEVBQUU7SUFDN0MsSUFBSUEsQ0FBQyxDQUFDTSxHQUFHLEtBQUssUUFBUSxJQUFJWSxRQUFRLENBQUNoQyxLQUFLLENBQUNxQyxPQUFPLEtBQUssTUFBTSxFQUFFO01BQ3pETCxRQUFRLENBQUNoQyxLQUFLLENBQUNxQyxPQUFPLEdBQUcsTUFBTTtJQUNuQztFQUNKLENBQUMsQ0FBQztBQUNOLENBQUMsQ0FBQyxDIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vYXBwbGljYXRpb25fdGlja2V0c19idWcvLi9hc3NldHMvYXBwLmpzIiwid2VicGFjazovL2FwcGxpY2F0aW9uX3RpY2tldHNfYnVnLy4vYXNzZXRzL2J1cmdlci1tZW51LmpzIiwid2VicGFjazovL2FwcGxpY2F0aW9uX3RpY2tldHNfYnVnLy4vYXNzZXRzL3N0eWxlcy9hcHAuY3NzPzZiZTYiLCJ3ZWJwYWNrOi8vYXBwbGljYXRpb25fdGlja2V0c19idWcvLi9hc3NldHMvc3R5bGVzL2NrZWRpdG9yLmNzcz8yMDZjIiwid2VicGFjazovL2FwcGxpY2F0aW9uX3RpY2tldHNfYnVnLy4vYXNzZXRzL3VwbG9hZF9pbWcuanMiXSwic291cmNlc0NvbnRlbnQiOlsiLy8gaW1wb3J0IFwiLi9ib290c3RyYXAuanNcIjtcbi8qXG4gKiBXZWxjb21lIHRvIHlvdXIgYXBwJ3MgbWFpbiBKYXZhU2NyaXB0IGZpbGUhXG4gKlxuICogVGhpcyBmaWxlIHdpbGwgYmUgaW5jbHVkZWQgb250byB0aGUgcGFnZSB2aWEgdGhlIGltcG9ydG1hcCgpIFR3aWcgZnVuY3Rpb24sXG4gKiB3aGljaCBzaG91bGQgYWxyZWFkeSBiZSBpbiB5b3VyIGJhc2UuaHRtbC50d2lnLlxuICovXG5pbXBvcnQgXCIuL3N0eWxlcy9hcHAuY3NzXCI7XG5pbXBvcnQgXCIuL3N0eWxlcy9ja2VkaXRvci5jc3NcIjsgLy8gYWRkIHRoaXMgbGluZVxuXG5pbXBvcnQgXCIuL3VwbG9hZF9pbWcuanNcIlxuaW1wb3J0IFwiLi9idXJnZXItbWVudS5qc1wiXG5cbi8vIGNvbnNvbGUubG9nKFwiVGhpcyBsb2cgY29tZXMgZnJvbSBhc3NldHMvYXBwLmpzIC0gd2VsY29tZSB0byBBc3NldE1hcHBlciEg8J+OiVwiKTtcblxuLy8gV2FpdCA1IHNlY29uZHMgKDUwMDAgbXMpLCB0aGVuIGZhZGUgb3V0IGFuZCByZW1vdmUgbWVzc2FnZXNcbmZ1bmN0aW9uIGZhZGVGbGFzaGVzKCkge1xuICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLmZsYXNoLW1lc3NhZ2UsIC5hbGVydCcpLmZvckVhY2goZWwgPT4ge1xuICAgICAgIHNldFRpbWVvdXQoKCkgPT4ge1xuICAgICAgICAgICBlbC5zdHlsZS50cmFuc2l0aW9uID0gXCJvcGFjaXR5IDAuNXMgZWFzZVwiO1xuICAgICAgICAgICBlbC5zdHlsZS5vcGFjaXR5ID0gXCIwXCI7XG4gICAgICAgICAgIHNldFRpbWVvdXQoKCkgPT4gZWwucmVtb3ZlKCksIDUwMCk7XG4gICAgICAgfSwgNTAwMCk7XG4gICB9KTtcbn1cblxuZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcihcIkRPTUNvbnRlbnRMb2FkZWRcIiwgZmFkZUZsYXNoZXMpO1xuZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcihcInR1cmJvOmxvYWRcIiwgZmFkZUZsYXNoZXMpOyIsIi8qKlxuICogTWVudSBCdXJnZXIgLSBHZXN0aW9uIGRlIGwnb3V2ZXJ0dXJlL2Zlcm1ldHVyZVxuICovXG5cbmxldCBidXJnZXJJbml0aWFsaXplZCA9IGZhbHNlO1xubGV0IGJ1cmdlck1lbnUsIG1haW5OYXYsIGJvZHk7XG5cbmZ1bmN0aW9uIHRvZ2dsZU1lbnUoKSB7XG4gICAgaWYgKGJ1cmdlck1lbnUgJiYgbWFpbk5hdiAmJiBib2R5KSB7XG4gICAgICAgIGJ1cmdlck1lbnUuY2xhc3NMaXN0LnRvZ2dsZSgnYWN0aXZlJyk7XG4gICAgICAgIG1haW5OYXYuY2xhc3NMaXN0LnRvZ2dsZSgnYWN0aXZlJyk7XG4gICAgICAgIGJvZHkuY2xhc3NMaXN0LnRvZ2dsZSgnbWVudS1vcGVuJyk7XG4gICAgfVxufVxuXG5mdW5jdGlvbiBjbG9zZU1lbnUoKSB7XG4gICAgaWYgKGJ1cmdlck1lbnUgJiYgbWFpbk5hdiAmJiBib2R5KSB7XG4gICAgICAgIGJ1cmdlck1lbnUuY2xhc3NMaXN0LnJlbW92ZSgnYWN0aXZlJyk7XG4gICAgICAgIG1haW5OYXYuY2xhc3NMaXN0LnJlbW92ZSgnYWN0aXZlJyk7XG4gICAgICAgIGJvZHkuY2xhc3NMaXN0LnJlbW92ZSgnbWVudS1vcGVuJyk7XG4gICAgfVxufVxuXG5mdW5jdGlvbiBoYW5kbGVCdXJnZXJDbGljayhlKSB7XG4gICAgZS5zdG9wUHJvcGFnYXRpb24oKTtcbiAgICB0b2dnbGVNZW51KCk7XG59XG5cbmZ1bmN0aW9uIGhhbmRsZUJvZHlDbGljayhlKSB7XG4gICAgaWYgKGJvZHkgJiYgYm9keS5jbGFzc0xpc3QuY29udGFpbnMoJ21lbnUtb3BlbicpICYmIFxuICAgICAgICBtYWluTmF2ICYmICFtYWluTmF2LmNvbnRhaW5zKGUudGFyZ2V0KSAmJiBcbiAgICAgICAgYnVyZ2VyTWVudSAmJiAhYnVyZ2VyTWVudS5jb250YWlucyhlLnRhcmdldCkpIHtcbiAgICAgICAgY2xvc2VNZW51KCk7XG4gICAgfVxufVxuXG5mdW5jdGlvbiBoYW5kbGVFc2NhcGVLZXkoZSkge1xuICAgIGlmIChlLmtleSA9PT0gJ0VzY2FwZScgJiYgYm9keSAmJiBib2R5LmNsYXNzTGlzdC5jb250YWlucygnbWVudS1vcGVuJykpIHtcbiAgICAgICAgY2xvc2VNZW51KCk7XG4gICAgfVxufVxuXG5sZXQgcmVzaXplVGltZXI7XG5mdW5jdGlvbiBoYW5kbGVSZXNpemUoKSB7XG4gICAgY2xlYXJUaW1lb3V0KHJlc2l6ZVRpbWVyKTtcbiAgICByZXNpemVUaW1lciA9IHNldFRpbWVvdXQoZnVuY3Rpb24oKSB7XG4gICAgICAgIGlmICh3aW5kb3cuaW5uZXJXaWR0aCA+IDc2OCAmJiBib2R5ICYmIGJvZHkuY2xhc3NMaXN0LmNvbnRhaW5zKCdtZW51LW9wZW4nKSkge1xuICAgICAgICAgICAgY2xvc2VNZW51KCk7XG4gICAgICAgIH1cbiAgICB9LCAyNTApO1xufVxuXG5mdW5jdGlvbiB1cGRhdGVET01SZWZlcmVuY2VzKCkge1xuICAgIC8vIE1ldHRyZSDDoCBqb3VyIGxlcyByw6lmw6lyZW5jZXMgRE9NIMOgIGNoYXF1ZSBuYXZpZ2F0aW9uXG4gICAgYnVyZ2VyTWVudSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdidXJnZXJNZW51Jyk7XG4gICAgbWFpbk5hdiA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdtYWluTmF2Jyk7XG4gICAgYm9keSA9IGRvY3VtZW50LmJvZHk7XG59XG5cbmZ1bmN0aW9uIGluaXRCdXJnZXJNZW51KCkge1xuICAgIHVwZGF0ZURPTVJlZmVyZW5jZXMoKTtcblxuICAgIGlmICghYnVyZ2VyTWVudSB8fCAhbWFpbk5hdikge1xuICAgICAgICByZXR1cm47XG4gICAgfVxuXG4gICAgLy8gSW5pdGlhbGlzZXIgbGVzIGV2ZW50IGxpc3RlbmVycyBnbG9iYXV4IHVuZSBzZXVsZSBmb2lzXG4gICAgaWYgKCFidXJnZXJJbml0aWFsaXplZCkge1xuICAgICAgICBidXJnZXJJbml0aWFsaXplZCA9IHRydWU7XG4gICAgICAgIFxuICAgICAgICAvLyBFdmVudCBsaXN0ZW5lcnMgc3VyIGxlcyDDqWzDqW1lbnRzIHF1aSBuZSBjaGFuZ2VudCBwYXNcbiAgICAgICAgZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCBmdW5jdGlvbihlKSB7XG4gICAgICAgICAgICAvLyBWw6lyaWZpZXIgc2kgYydlc3QgbGUgYm91dG9uIGJ1cmdlclxuICAgICAgICAgICAgaWYgKGUudGFyZ2V0LmNsb3Nlc3QoJyNidXJnZXJNZW51JykpIHtcbiAgICAgICAgICAgICAgICBlLnN0b3BQcm9wYWdhdGlvbigpO1xuICAgICAgICAgICAgICAgIHRvZ2dsZU1lbnUoKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIC8vIEZlcm1lciBsZSBtZW51IHNpIGNsaWMgZW4gZGVob3JzXG4gICAgICAgICAgICBlbHNlIGlmIChib2R5LmNsYXNzTGlzdC5jb250YWlucygnbWVudS1vcGVuJykgJiYgXG4gICAgICAgICAgICAgICAgICAgICAhZS50YXJnZXQuY2xvc2VzdCgnI21haW5OYXYnKSkge1xuICAgICAgICAgICAgICAgIGNsb3NlTWVudSgpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9KTtcblxuICAgICAgICBkb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdrZXlkb3duJywgaGFuZGxlRXNjYXBlS2V5KTtcbiAgICAgICAgd2luZG93LmFkZEV2ZW50TGlzdGVuZXIoJ3Jlc2l6ZScsIGhhbmRsZVJlc2l6ZSk7XG4gICAgfVxuXG4gICAgLy8gRmVybWVyIGxlIG1lbnUgYXUgY2xpYyBzdXIgdW4gbGllbiBkZSBuYXZpZ2F0aW9uICjDoCBjaGFxdWUgdHVyYm86bG9hZClcbiAgICBpZiAobWFpbk5hdikge1xuICAgICAgICBjb25zdCBuYXZMaW5rcyA9IG1haW5OYXYucXVlcnlTZWxlY3RvckFsbCgnYScpO1xuICAgICAgICBuYXZMaW5rcy5mb3JFYWNoKGxpbmsgPT4ge1xuICAgICAgICAgICAgbGluay5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgICAgIGNsb3NlTWVudSgpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgIH0pO1xuICAgIH1cbn1cblxuLy8gSW5pdGlhbGlzZXIgYXUgY2hhcmdlbWVudCBkZSBsYSBwYWdlIGV0IGxvcnMgZGVzIG5hdmlnYXRpb25zIFR1cmJvXG5kb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdET01Db250ZW50TG9hZGVkJywgaW5pdEJ1cmdlck1lbnUpO1xuZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcigndHVyYm86bG9hZCcsIGluaXRCdXJnZXJNZW51KTtcblxuIiwiLy8gZXh0cmFjdGVkIGJ5IG1pbmktY3NzLWV4dHJhY3QtcGx1Z2luXG5leHBvcnQge307IiwiLy8gZXh0cmFjdGVkIGJ5IG1pbmktY3NzLWV4dHJhY3QtcGx1Z2luXG5leHBvcnQge307IiwiLy8gTGlnaHRib3ggcG91ciBhZ3JhbmRpciBsZXMgaW1hZ2VzXG5kb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdET01Db250ZW50TG9hZGVkJywgZnVuY3Rpb24oKSB7XG4gICAgY29uc3QgbGlnaHRib3ggPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnaW1hZ2UtbGlnaHRib3gnKTtcbiAgICBjb25zdCBsaWdodGJveEltZyA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdsaWdodGJveC1pbWFnZScpO1xuICAgIGNvbnN0IGNsb3NlQnRuID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLmxpZ2h0Ym94LWNsb3NlJyk7XG4gICAgXG4gICAgLy8gT3V2cmlyIGxhIGxpZ2h0Ym94IGF1IGNsaWMgc3VyIHVuZSBpbWFnZVxuICAgIGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJy5jbGlja2FibGUtaW1hZ2UnKS5mb3JFYWNoKGltZyA9PiB7XG4gICAgICAgIGltZy5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgbGlnaHRib3guc3R5bGUuZGlzcGxheSA9ICdmbGV4JztcbiAgICAgICAgICAgIGxpZ2h0Ym94SW1nLnNyYyA9IHRoaXMuc3JjO1xuICAgICAgICAgICAgbGlnaHRib3hJbWcuYWx0ID0gdGhpcy5hbHQ7XG4gICAgICAgIH0pO1xuICAgIH0pO1xuICAgIFxuICAgIC8vIEZlcm1lciBsYSBsaWdodGJveFxuICAgIGlmIChjbG9zZUJ0bikge1xuICAgICAgICBjbG9zZUJ0bi5hZGRFdmVudExpc3RlbmVyKCdjbGljaycsIGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgbGlnaHRib3guc3R5bGUuZGlzcGxheSA9ICdub25lJztcbiAgICAgICAgfSk7XG4gICAgfVxuICAgIFxuICAgIC8vIEZlcm1lciBlbiBjbGlxdWFudCBlbiBkZWhvcnMgZGUgbCdpbWFnZVxuICAgIGxpZ2h0Ym94LmFkZEV2ZW50TGlzdGVuZXIoJ2NsaWNrJywgZnVuY3Rpb24oZSkge1xuICAgICAgICBpZiAoZS50YXJnZXQgPT09IGxpZ2h0Ym94KSB7XG4gICAgICAgICAgICBsaWdodGJveC5zdHlsZS5kaXNwbGF5ID0gJ25vbmUnO1xuICAgICAgICB9XG4gICAgfSk7XG4gICAgXG4gICAgLy8gRmVybWVyIGF2ZWMgbGEgdG91Y2hlIMOJY2hhcFxuICAgIGRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoJ2tleWRvd24nLCBmdW5jdGlvbihlKSB7XG4gICAgICAgIGlmIChlLmtleSA9PT0gJ0VzY2FwZScgJiYgbGlnaHRib3guc3R5bGUuZGlzcGxheSA9PT0gJ2ZsZXgnKSB7XG4gICAgICAgICAgICBsaWdodGJveC5zdHlsZS5kaXNwbGF5ID0gJ25vbmUnO1xuICAgICAgICB9XG4gICAgfSk7XG59KTtcblxuIl0sIm5hbWVzIjpbImZhZGVGbGFzaGVzIiwiZG9jdW1lbnQiLCJxdWVyeVNlbGVjdG9yQWxsIiwiZm9yRWFjaCIsImVsIiwic2V0VGltZW91dCIsInN0eWxlIiwidHJhbnNpdGlvbiIsIm9wYWNpdHkiLCJyZW1vdmUiLCJhZGRFdmVudExpc3RlbmVyIiwiYnVyZ2VySW5pdGlhbGl6ZWQiLCJidXJnZXJNZW51IiwibWFpbk5hdiIsImJvZHkiLCJ0b2dnbGVNZW51IiwiY2xhc3NMaXN0IiwidG9nZ2xlIiwiY2xvc2VNZW51IiwiaGFuZGxlQnVyZ2VyQ2xpY2siLCJlIiwic3RvcFByb3BhZ2F0aW9uIiwiaGFuZGxlQm9keUNsaWNrIiwiY29udGFpbnMiLCJ0YXJnZXQiLCJoYW5kbGVFc2NhcGVLZXkiLCJrZXkiLCJyZXNpemVUaW1lciIsImhhbmRsZVJlc2l6ZSIsImNsZWFyVGltZW91dCIsIndpbmRvdyIsImlubmVyV2lkdGgiLCJ1cGRhdGVET01SZWZlcmVuY2VzIiwiZ2V0RWxlbWVudEJ5SWQiLCJpbml0QnVyZ2VyTWVudSIsImNsb3Nlc3QiLCJuYXZMaW5rcyIsImxpbmsiLCJsaWdodGJveCIsImxpZ2h0Ym94SW1nIiwiY2xvc2VCdG4iLCJxdWVyeVNlbGVjdG9yIiwiaW1nIiwiZGlzcGxheSIsInNyYyIsImFsdCJdLCJzb3VyY2VSb290IjoiIn0=