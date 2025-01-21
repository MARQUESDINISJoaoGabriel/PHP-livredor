

# Livre d'Or PHP ![image](https://github.com/user-attachments/assets/8521a928-3ae1-45d5-ac96-380c24d73e3a) <br>

<hr> 

## Introduction 

Ce projet de PHP consiste en un Livre d'Or, contenant une fonction login et un logiciel regroupant des messages contenus en une base de données, le Livre d'Or affiche les messages d'utilisateurs différents, a une date donnée. Avec pour unique dépendance XAMPP.<br>

*Compatible sur Linux, Windows, MacOS*
<hr>

## Sections

- [Installation](#installation)
- [Usage](#usage)
- [Fonctionnalités](#fonctionnalités)
- [Contribuer](#contribuer)
- [Annexes](#annexes)

## Installation
### Pré-requis
- Interprétateur PHP:<br>
  --- **Windows** - https://windows.php.net/download#php-8.1<br>
  --- **MacOS avec Homebrew** - `brew install php`<br>
  --- **Linux** - `# apt install php-common libapache2-mod-php php-cli`<br>
- **Visual Studio Code** - https://code.visualstudio.com/download
- **XAMPP** - https://www.apachefriends.org/download.html

### Commandez

<strong>Clonez ce repository</strong><br>
`git clone https://github.com/MARQUESDINISJoaoGabriel/PHP-livredor`

<strong>Accédez au dossier du projet</strong><br>
`cd PHP-livredor`

## Usage
### MacOs/Windows/Linux
Pour démarrer ce projet, lancez XAMPP (manager-osx dans le fichier XAMPP d'<strong>Applications</strong> sur mac)

<strong>Démarrer le projet:</strong>
Lancez XAMPP, et démarrez Apache et MySQL Database.

![Capture d’écran 2025-01-21 à 17 37 58](https://github.com/user-attachments/assets/0850c876-18c7-4f3c-af0e-074173d0aa17)

*Vous devriez avoir cet affichage.*<br>

Après démarrage, dirigez vous vers <strong>http://localhost/phpmyadmin/index.php?route=/server/databases</strong>.
Allez dans 📥 **IMPORTER** puis importez le fichier présent dans `sql/amettredansPHPMYADMIN`, puis **Importer**.

![Capture d’écran 2025-01-21 à 18 18 42](https://github.com/user-attachments/assets/17dc26fd-8e4c-422e-a4f3-c2492ed7bd27)

Dirigez-vous à <strong>http://localhost/livredor/</strong>, vous serez redirigé à la page **login.php**

## Fonctionnalités

- Création d'utilisateurs
- Déconnexion
- Couleur de profil
- Envoi de messages
- Suppression de messages
- Mot de passe oublié

## Contribuer

Si vous voulez améliorer ce Guestbook en corrigeant / ajoutant des fonctionalités : 

1. Forkez le projet.
2. Créez une branche pour votre fonctionnalité (`git checkout -b ma-nouvelle-fonctionnalité`).
3. Commitez vos changements (`git commit -m 'Ajoute une nouvelle fonctionnalité'`).
4. Poussez votre branche (`git push origin ma-nouvelle-fonctionnalité`).
5. Ouvrez une Pull Request.

## Annexes
![Capture d’écran 2025-01-21 à 18 09 28](https://github.com/user-attachments/assets/a3b01c17-d6d2-4aa1-a81d-e6d6f9915112)

![Capture d’écran 2025-01-21 à 18 08 45](https://github.com/user-attachments/assets/8d71373b-e2cc-4da7-a358-3f320f619cf1)
