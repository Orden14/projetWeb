# Projet Web pour le cours Challengeweb

## Auteurs
Thomas L.  
Ludovic M.
David W.

EFREI  
B3 développement web & applications

## Lancer le projet
/!\ Le projet requier OpenSSL sur l'environement de travail (gitbash intègre OpenSSL)
Pour faciliter l'éxecution du projet sur toutes les machines, il est préférable de posséder docker ainsi que yarn.  
Navigateur recommandé : chrome  
  
Pour lancer le projet pour la première fois, se placer dans la root directory du projet puis :
- docker-compose up (dockerise une base de données et phpmyadmin pour le projet)
- yarn fullsetup

commandes spéciales disponibles :
- yarn dependencies (execute composer install, yarn install, puis compile avec webpack)
- yarn truncate-database (reset la BDD et execute les fixtures)
- yarn setup-and-start (regenere les clés JWT puis lance le serveur symfony sur le port 8001)
- yarn build (compile avec webpack)

Le projet sera accessible sur http://localhost:8001  

## Utilisateurs par défaut
Tous les utilisateurs générés par les fixtures ont pour mot de passe '123'  
Username des comptes de test par défaut : 'Admin' et 'Technicien'

## Le projet
Le projet consiste à faire une API de gestion d'articles de blog ou de presse avec API Platform.  
Les appels API sont protégés par une authentification avec token JWT.  
Il contient aussi une interface web qui utilise directement l'API.  
