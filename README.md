# Back Project

Le projet back-end que j'ai entrepris vise à 
améliorer mes compétences en utilisant le framework Symfony. 
L'objectif principal est de créer un système CRUD administratif 
pour gérer les données d'une boutique en ligne simplifiée. 
Il convient de noter que les données utilisées sont fictives et 
que certains noms n'ont pas de signification particulière.

Il reste encore beaucoup de choses à peaufiner.

## Installation

Symfony 6.2

php 8.1.10

node V16

```bash
composer install
```
```bash
npm install
```
## Données

Cette commande permet de créer la base de données et de lancer les Fixtures. 

```bash
php bin/console app:install-back
```

## JWT KEY

```bash
php bin/console lexik:jwt:generate-keypair
```


Pour mettre en place les pages d'erreur changer dans le .env
```
APP_ENV=dev => prod
```

# Serveur Local


## OPTION 1
[Scoop Instalation](https://scoop.sh/)

Quand Scoop et installer

```bash
scoop install symfony-cli
```


Pour lancer le serveur en local
```bash
symfony serve
```

Si les worker sont déjà pris

Pour lancer le serveur en local

```bash
symfony server:stop
```

Et relancé
```bash
symfony serve
```
# Serveur distant
## OPTION 2

Testé sur mon [site](http://sudreflorian.fr)