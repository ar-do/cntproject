FROM registry.gitlab.com/mbernet/registry/php:7.0-apache
RUN mkdir /var/www/html/cntproject
RUN mkdir /var/www/html/cntproject/php
RUN mkdir /var/www/html/cntproject/css
RUN mkdir /var/www/html/cntproject/img
RUN mkdir /var/www/html/cntproject/js
RUN mkdir /var/www/html/cntproject/templates
RUN mkdir /var/www/html/cntproject/templates/components
COPY php/*.php /var/www/html/cntproject/php/
COPY css/*.css /var/www/html/cntproject/css/
COPY img/*.png /var/www/html/cntproject/img/
COPY js/*.js /var/www/html/cntproject/js/
COPY *.php /var/www/html/cntproject/
COPY templates/components/*.html /var/www/html/cntproject/templates/components/
COPY *.html /var/www/html/cntproject/
