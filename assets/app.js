import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

// Fonction pour gérer l'affichage des éléments selon l'état de connexion
function toggleAuthElements() {
    const isAuthenticated = document.querySelector('form[action="/login"]');
    const authElements = document.querySelectorAll('.auth-only');
    const guestElements = document.querySelectorAll('.guest-only');
    
    if (isAuthenticated) {
        // Utilisateur connecté : afficher les éléments auth-only, masquer les guest-only
        authElements.forEach(el => el.classList.remove('hidden'));
        guestElements.forEach(el => el.classList.add('hidden'));
    } else {
        // Utilisateur non connecté : masquer les éléments auth-only, afficher les guest-only
        authElements.forEach(el => el.classList.add('hidden'));
        guestElements.forEach(el => el.classList.remove('hidden'));
    }
}

// Exécuter au chargement de la page
document.addEventListener('DOMContentLoaded', toggleAuthElements);

// Optionnel : écouter les changements d'état de connexion
document.addEventListener('authStateChanged', toggleAuthElements);