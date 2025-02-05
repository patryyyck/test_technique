# Pour la qualité de code, je propose d'utiliser:
* phpcs pour analyser les fichiers PHP du projet afin de détecter des violations définies par le standard de développement de PHP
* phpcbf pour corriger au maximum les erreurs détectées par le programme précédent
* PHPStan pour analyser "statiquement" le code PHP. Cela permettra de capturer les erreurs avant qu'elles ne se produisent

# Concernant le CI/CD, je propose les actions suivantes:
* analyse du code via phpcs
* analyse du code via phpstan
* exécution des tests (unitaires...)
* construction de package/image
* déploiement vers différents environnements (staging/prod ...)
