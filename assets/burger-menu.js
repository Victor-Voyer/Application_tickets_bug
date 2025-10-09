/**
 * Menu Burger - Gestion de l'ouverture/fermeture
 */

let burgerInitialized = false;
let burgerMenu, mainNav, body;

function toggleMenu() {
    burgerMenu.classList.toggle('active');
    mainNav.classList.toggle('active');
    body.classList.toggle('menu-open');
}

function closeMenu() {
    burgerMenu.classList.remove('active');
    mainNav.classList.remove('active');
    body.classList.remove('menu-open');
}

function handleBurgerClick(e) {
    e.stopPropagation();
    toggleMenu();
}

function handleBodyClick(e) {
    if (body.classList.contains('menu-open') && 
        !mainNav.contains(e.target) && 
        !burgerMenu.contains(e.target)) {
        closeMenu();
    }
}

function handleNavLinkClick() {
    closeMenu();
}

function handleEscapeKey(e) {
    if (e.key === 'Escape' && body.classList.contains('menu-open')) {
        closeMenu();
    }
}

let resizeTimer;
function handleResize() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() {
        if (window.innerWidth > 768 && body.classList.contains('menu-open')) {
            closeMenu();
        }
    }, 250);
}

function initBurgerMenu() {
    burgerMenu = document.getElementById('burgerMenu');
    mainNav = document.getElementById('mainNav');
    body = document.body;

    if (!burgerMenu || !mainNav) {
        return;
    }

    // N'initialiser qu'une seule fois
    if (burgerInitialized) {
        return;
    }
    burgerInitialized = true;

    // Ajouter les event listeners
    burgerMenu.addEventListener('click', handleBurgerClick);
    body.addEventListener('click', handleBodyClick);
    document.addEventListener('keydown', handleEscapeKey);
    window.addEventListener('resize', handleResize);

    // Fermer le menu au clic sur un lien
    const navLinks = mainNav.querySelectorAll('a');
    navLinks.forEach(link => {
        link.addEventListener('click', handleNavLinkClick);
    });
}

// Initialiser au chargement de la page
document.addEventListener('DOMContentLoaded', initBurgerMenu);
document.addEventListener('turbo:load', initBurgerMenu);

