Sandrine COUPART - Diéteticienne
============================

ECF 2023 - TITRE PROFESSIONNEL DEVELOPPEUR WEB ET WEB MOBILE

## Déploiement en local :

1- Télécharger le fichier .zip que vous trouverez sur ce repository. Cliquez sur le bouton vert 'Code' puis sur le choix 'Download zip'.

2- Une fois fait, dézippez le fichier, puis ouvrez-le en tant que nouveau projet dans votre IDE favori.

3-Dans le fichier .env.local :
 * sur les lignes dédiées à la base de donnée, entrez les informations d'identification et de mot de passe que vous utilisez dans votre SGBD (par exemple: phpmyadmin).

4- En ligne de commande dans votre IDE:
* taper la commande suivante si vous utilisez Symfony CLI:
    - "symfony console doctrine:migrations:migrate",
* sinon tapez 
    - "php bin/console doctrine:migrations:mirgate"

5- Démarrez le serveur symfony afin de pouvoir voir le site, 
* saisir 
    - "symfony server:start"

6- Il faut maintenant créer l'utilisateur Admin. 
* Pour cela, saisir en ligne de commande :
    - symfony console app:create-administrator
    - répondre aux différentes questions pour créer l'utilisateur Admin

7- Connectez-vous grâce aux identifiant de l'administrateur que vous venez de créer. Vous pouvez alimenter les données du site en accedant au panneau d'administration.

8- Vous pouvez créer des patients qui auront accès aux recettes avancées
* panneau d'administration
    - Gérer les utilisateurs ->ajouter un patient



