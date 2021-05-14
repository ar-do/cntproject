FROM php:7.0-apache
RUN mkdir /var/www/html/cntproject
COPY php/*.php /var/www/html/cntproject/
COPY css/*.css /var/www/html/cntproject/
COPY img/*.png /var/www/html/cntproject/
COPY js/*.js /var/www/html/cntproject/
COPY *.php /var/www/html/cntproject/
COPY templates/components/*.html /var/www/html/cntproject/
COPY *.html /var/www/html/cntproject/
