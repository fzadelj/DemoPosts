FROM php:8.0.3-apache-buster
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN apt-get update && apt-get upgrade -y
RUN apt-get install zip unzip
RUN php -r "copy('https://getcomposer.org/installer', '/tmp/composer-setup.php');"
RUN php -r "if (hash_file('sha384', '/tmp/composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('/tmp/composer-setup.php'); } echo PHP_EOL;"
RUN php /tmp/composer-setup.php && rm /tmp/composer-setup.php && cp composer.phar /usr/local/bin/composer
WORKDIR /etc/apache2/sites-enabled
RUN rm 000-default.conf
RUN ln -s /app/config/apache/virtual_host.conf default.conf
RUN a2enmod rewrite
RUN service apache2 restart
WORKDIR /app
