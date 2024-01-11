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
Pour lancer le projet, se placer dans la root directory du projet puis :
- docker-compose up (dockerise une base de données et phpmyadmin pour le projet)
- yarn dependencies
- yarn truncate-database
- yarn setup-and-start

Le projet sera accessible sur http://localhost:8001  

## Le projet
Le projet consiste à faire une API de gestion d'articles de blog ou de presse avec API Platform.
Il contient aussi une interface web qui utilise directement l'API
