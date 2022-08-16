# Guestbook

Pour accéder au projet en local :

1/ Créer une bdd guestbookv2 et configurer les variables de bdd dans le dossier symfony
`DATABASE_URL=mysql://<user>:<password>@sql:<port>/guestbookv2?serverVersion=5.7`

2/ Lancer le serveur symfony
`cd symfony`
`symfony server:start`

3/ Lancer le serveur front-end (le serveur back est proxifié)
`cd angular`
`npm start`

Puis aller consulter l'app :
`http://localhost:4200/`

