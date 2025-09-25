# 📘 Cahier des charges – Application de gestion de tickets de debug

Techno : Symfony + MySQL / phpMyAdmin

## 🎯 Objectif

Développer une application web en Symfony permettant aux développeurs de créer, suivre et résoudre des tickets de debug.
L’application doit permettre de commenter et collaborer facilement autour des bugs signalés.

## ⚙️ Fonctionnalités principales
### 🔐 Authentification

    -  Gestion des utilisateurs via Symfony Security.

### Fonctionnalités :

    -  Inscription

    - Connexion

    - Déconnexion

### Rôles possibles (optionnels) :

    - Utilisateur : peut créer des tickets, commenter.

    - Développeur : peut prendre en charge et résoudre des tickets.

### 🧾 Gestion des tickets

#### Un utilisateur connecté peut créer un ticket avec :

    - Titre

    - Technologie concernée (ex : React, Symfony, Python…)

    - Description du bug (texte libre)

    - Date de création (enregistrée automatiquement)

### Statuts d’un ticket :

        🟡 Ouvert – Ticket créé, en attente

        🔵 En cours – Un développeur l’a pris en charge

        ✅ Résolu – Ticket corrigé

### 🔁 Changement de visuel selon le statut (badge/couleur)

### 👤 Attribution d’un ticket à un développeur

## 💬 Commentaires

Chaque ticket peut recevoir des commentaires pour faciliter la résolution.

Un commentaire peut contenir :

- Texte formaté (gras, italique, listes, code…)

- Images (upload d’illustrations ou captures d’écran)


### 👉 Pour gérer cela facilement :

- Utiliser FOSCKEditorBundle (éditeur riche type CKEditor dans Symfony)

- Ajouter un système d’upload d’images lié aux commentaires

- Possibilité de marquer un commentaire comme “Demande d’aide sur place” (case à cocher ou bouton spécial)

### 📊 Statistiques & classement

Tableau de bord affichant :

- Nombre de tickets : ouverts, en cours, résolus

- Classement des développeurs selon le nombre de tickets résolus

## 🛠️ Contraintes techniques

### Framework : Symfony (dernière version stable)

### Base de données : MySQL (gestion via phpMyAdmin)

### ORM : Doctrine

### Bundle recommandé :

`FOSCKEditorBundle`
 → éditeur de texte riche pour les commentaires

## 💡 Idées bonus (optionnelles)

    🔎 Filtrage / recherche des tickets par technologie ou statut

    📧 Notifications (ex : mail lorsqu’un ticket est commenté ou pris en charge)

    📱 API REST simple pour une future application mobile