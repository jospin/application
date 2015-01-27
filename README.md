# application

Após clonar:
  - Rode o composer install;
  - Ativar .htaccess
  - Colocar no hosts
  - Crie o vhost para acesso via url

<VirtualHost *:80>
      ServerName application.localhost
      DocumentRoot /var/www/application/public
      ErrorLog ${APACHE_LOG_DIR}/application.log
      CustomLog ${APACHE_LOG_DIR}/application_access.log combined
      <Directory /var/www/application/public>
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
      </Directory>
</VirtualHost>

