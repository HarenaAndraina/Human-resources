# gestion-entreprise

Une application conçue pour la gestion d'entreprise.

Étapes pour lancer le projet dans votre environnement local :

1. Créer une copie du fichier `.env` et renommer le en `.env.local`. Ensuite chercher la ligne ci-dessous et appliquer vos informations de base de données
    ``` text
    DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=16&charset=utf8"
    ```
   
2. Si votre base de données n'a pas encore été créée, vous pouvez utiliser la commande fournie par symfony :
    ``` text
    php bin/console doctrine:database:create
    ```
3. Exécutez les scripts sql dans le dossier `database` 

4. Pour lancer le projet, rendez-vous sur le répertoire racine du projet et exécutez cette commande dans le terminal :
    ``` text
    start_dev_server.bat
    ```
