# Exécution behat
To run this project you will need a computer with PHP and composer installed.

# Install
To install the project, you just have to run `docker run --rm -v $(pwd):/app composer install` to get all the dependencies

# Running the tests

`docker run -it --rm -v /home:/home -w $PWD php:cli php ./vendor/bin/behat`
