# Guestbook

Pour accéder au projet en local :

1/ Créer une bdd et configurer les variables de bdd dans le dossier symfony.
Example : `DATABASE_URL=mysql://<user>:<password>@sql:<port>/guestbookv2?serverVersion=5.7`
Pour créer un premier user utiliser la commande : `app:add-user`

2/ Lancer le serveur symfony
`cd symfony`
`symfony server:start`

3/ Lancer le serveur front-end (le serveur back est proxifié)
`cd angular`
`npm start`

Puis aller consulter l'app :
`http://localhost:4200/`

