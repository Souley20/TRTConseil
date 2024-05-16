# Evaluation d'entrainement en cours de formation: développer la partie back-end d'une application web

## Utilisation en local

Pour installer le projet sur votre machine, vous disposez de plusieurs manièère d'y proceder soit en clonant depuis le dépôt Github ou par composer en utilisant la commande
<br/>
  `git clone https://github.com/Souley20/eva_back_trtconseil.git`  
<br/>
  Rendez vous dans le dossier dans lequel vous avez cloner le projet en tapant
<br/>
 `cd trtconseil`  
<br/>
 Installer toutes les dépendances 
 <br/> 
 `composer install`  
<br/>
  Créez la base de données avec
 <br/>
  `php bin/console doctrine:database:create`  
<br/>
  Faites la migration avec 
<br/>
 `php bin/console make:migration`  
 puis `php bin/console doctrine:migrations:migrate`  
<br/>
  Lancez le serveur Symfony 
 <br/>
  `symfony serve:start -d`  


## Création d'un administrateur

Rendez-vous à l'adresse https://127.0.0.1:8000/register/admin et remplissez le formulaire.
