# Entrevoisins API
---
![GitHub contributors](https://img.shields.io/github/contributors/scottydocs/README-template.md)

Entrevoisins est une application dont l’objectif est de
développer un réseau social pour que des voisins puissent faire connaissance et organiser des
activités ensemble. Dans ce contexte, nous avons pris en charge la partie Backend et on fournit les écrans
suivant pour décrire les fonctionnalités de l’application grâce à une API REST:
* Ajouter un voisin
* Consulter un voisin
* Consulter l'ensemble des voisins
* Marquer un voisin comme favoris
Nous tenons aussi à préciser que nous avons utilisé le langage PHP accompagné de [SLIM Framework](http://www.slimframework.com/)

## Prérequis
---
Avant d'utiliser ce projet, assurez d'avoir:

* Installé un serveur Web `Exemple: Apache`
* Installé une base données `Exemple: MySQL` 
* Dans notre cas, nous avons utilisé `XAMPP` qui nous permet d'avoir les deux à la fois.

## Comment utiliser Entrevoisins API ?
---
Pour utiliser <Entrevoisins_API>, suivez ces étapes:
* Créer la base de données et la table impliquée
```
CREATE DATABASE dbvoisins;

CREATE TABLE `dbvoisins`.`t_voisins` ( `id` INT(11) NOT NULL , `nom` VARCHAR
(255) NOT NULL , `adresse` VARCHAR(255) NOT NULL , `apropos` TEXT NOT NULL , 
`favoris` BOOLEAN NOT NULL ) ENGINE = InnoDB; 
```
*  Créer un dossier nommé `entrevoisins` dans votre répertoire APACHE `Exemple: htdocs pour XAMPP ou www pour WAMP` et Copier les dossiers qui sont dans les zip ainsi les fichiers dedans. 
* Modifier le fichier d'accés à la base de données `entrevoisins/src/configs/DBAccess.php` en précisant le nom d'utilisateur et le mot de passe.

## Contributeurs
---
* [@amadouf7](https://github.com/amadouf7) 
* [@AmadouSNdiaye](https://github.com/AmadouSNdiaye) 

## Contact
---
Si vous voulez nous contacter, vous pouvez envoyer un courriel au <amadouf7@gmail.com> ou <amadousellendiaye@protonmail.com>.

## Licence
---
Ce projet utilise cette licence : [MIT License](https://choosealicense.com/licenses/mit/).
