/**
 * Menu Burger - Gestion de l'ouverture/fermeture
 */

let burgerInitialized = false;
let burgerMenu, mainNav, body;

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
    if (body && body.classList.contains('menu-open') && 
        mainNav && !mainNav.contains(e.target) && 
        burgerMenu && !burgerMenu.contains(e.target)) {
        closeMenu();
    }
}

function handleEscapeKey(e) {
    if (e.key === 'Escape' && body && body.classList.contains('menu-open')) {
        closeMenu();
    }
}

let resizeTimer;
function handleResize() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() {
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
        document.addEventListener('click', function(e) {
            // Vérifier si c'est le bouton burger
            if (e.target.closest('#burgerMenu')) {
                e.stopPropagation();
                toggleMenu();
            }
            // Fermer le menu si clic en dehors
            else if (body.classList.contains('menu-open') && 
                     !e.target.closest('#mainNav')) {
                closeMenu();
            }
        });

        document.addEventListener('keydown', handleEscapeKey);
        window.addEventListener('resize', handleResize);
    }

    // Fermer le menu au clic sur un lien de navigation (à chaque turbo:load)
    if (mainNav) {
        const navLinks = mainNav.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                closeMenu();
            });
        });
    }
}

// Initialiser au chargement de la page et lors des navigations Turbo
document.addEventListener('DOMContentLoaded', initBurgerMenu);
document.addEventListener('turbo:load', initBurgerMenu);

