FROM yiisoftware/yii2-php:7.4-apache

# TimeZone
RUN cp /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime \
&& echo "America/Sao_Paulo" >  /etc/timezone

# # INSTALL COMPOSER
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=1.10.26 
RUN alias composer='php composer.phar'

RUN chown -R www-data:www-data /var/www
RUN chown -R www-data:www-data /var/www/html

# Remove Cache
RUN rm -rf /var/cache/apk/*