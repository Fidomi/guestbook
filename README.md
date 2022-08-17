# Guestbook

Pour accéder au projet en local :

1/ Créer une bdd et configurer les variables de bdd dans le dossier symfony.<br />
Example : `DATABASE_URL=mysql://<user>:<password>@sql:<port>/guestbookv2?serverVersion=5.7`<br />
Pour créer un premier user utiliser la commande : `app:add-user`<br />

2/ Lancer le serveur symfony<br />
`cd symfony`<br />
`symfony server:start`<br />

3/ Lancer le serveur front-end (le serveur back est proxifié)<br />
`cd angular`<br />
`npm start`<br />

4/ Consulter l'application sur votre navigateur :<br />
`http://localhost:4200/`<br />

