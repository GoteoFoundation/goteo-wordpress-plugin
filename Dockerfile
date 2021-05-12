FROM wordpress
LABEL maintainer="Goteo team, https://github.com/GoteoFoundation"

WORKDIR /var/www/html

COPY ./ /var/www/html/wp-content/plugins/goteo/

ENTRYPOINT ["docker-entrypoint.sh"]

CMD ["apache2-foreground"]