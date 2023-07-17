FROM ubuntu:22.04

RUN ln -snf /usr/share/zoneinfo/UTC /etc/localtime
RUN echo UTC > /etc/timezone

RUN apt-get update && apt-get -y install curl openssl unixodbc zip \
    php8.1 php8.1-mysql php8.1-bcmath php8.1-curl php-json php8.1-ldap php8.1-mbstring php8.1-xml php8.1-zip

# Enable apache rewrite
RUN a2enmod rewrite

# Laravel composer
RUN curl https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer | php --
RUN mv composer.phar /usr/local/bin/composer

COPY docker_files/virtualhost.conf /etc/apache2/sites-available/000-default.conf
COPY docker_files/php.ini /etc/php/8.1/apache2/php.ini
COPY www /var/www/html
RUN chmod -R 777 /var/www/html/*

EXPOSE 80 443

COPY docker_files/compose_app.sh /
RUN chmod a+x ./compose_app.sh
ENTRYPOINT /compose_app.sh
