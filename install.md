## Arquitectura general del sistema

![Alt text](/resources/assets/images/Arquitectura-Hoja-de-Ruta.png?raw=true "Optional Title")

## Requisitos de instalación

PostgreSQL 12, 11
Apache 2
PHP >= 7.2.0
Extensión PHP BCMath
Extensión PHP Ctype
Extensión PHP JSON
Extensión PHP Mbstring
Extensión PHP OpenSSL
Extensión PHP PDO
Extensión PHP Tokenizer
Extensión PHP XML

## Descarga del proyecto de gitlab

Se recomienda descargar el sistema de correspondencia en el siguiente directorio `/var/www/correspondencia` del repositorio
principal.

```
cd /var/www
git clone https://gitlab.contraloria.gob.bo/mrosales/correspondencia
```

Para descargar la version de desarrollo:

```
cd /var/www
git clone -b develop https://gitlab.contraloria.gob.bo/mrosales/correspondencia
```

## Instalación de node/npm

Debian contiene una versión de Node.js en sus repositorios predeterminados.
Para instalarlo se debe ejecutar los siguientes comandos:

```
apt update
apt install nodejs
nodejs -v
```

## Instalación de composer

El sistema de correspondencia utiliza Composer para gestionar sus dependencias, aseguraté de tener instalado Composer en tú servidor.

```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'a5c698ffe4b8e849a443b120cd5ba38043260d5c4023dbf93e1558871f1f07f58274fc6f4c93bcfd858c6bd0775cd8d1') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

Mover composer.phar a un directorio del $PATH, por ejemplo

```
mv composer.phar /usr/local/bin/composer
```

Así tambien, asegúrese de colocar el directorio vendor/bin de Composer en tu directorio $PATH para que el sistema pueda ejecutar los paquetes de Composer correctamente.
Este directorio existe en diferentes ubicaciones según el sistema operativo; sin embargo, la dirección común de toda distribución Linux: $HOME/.config/composer/vendor/bin

## Instalar las dependencias

Dentro del directorio del proyecto de correspondencia ejecutar:

```
composer install
```

## Instalar las dependencias y construcción de frond end

Para descargar las dependencias del front end ejecute:

```
npm install
```

Para generara (o actualizar) el front end, ejecute:

```
npm run prod
```

## Configurar el sistema

Crear un usuario `correspondencia` en postgres.
Crear una base de datos `correspondencia` en postgres, y otorgar todos los permisos como propietario al usuario `correspondencia`.

Dentro del directorio del sistema de correspondecia, copie la configuración del archivo de configuración de ejemplo:

```
cp .env.example .env
php artisan storage:link
```
Ejecute siguiente comando para inicializar la llave de encripción del sistema

```
php artisan key:generate
```

Actualice los siguientes parametros dentro del archivo .env:

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=correspondencia
DB_USERNAME=correspondencia
DB_PASSWORD=.........
```

Despues de editar 

## Esquema de datos

Para la creación del esquema de datos nuevo, ejecute la siguiente linea de comando:

```
php artisan migrate:fresh --seed
```

Como alternativa puede importar el backup de la base de datos directamente en la base de datos `correspondencia`

## Configurar Apache

Cambiar el propietario de la carpeta donde se instalo el sistema par usuario de apache `www-data`:

```
chown -R www-data:www-data /var/www/correspondencia
```

Crear el archivo de configuración apache para el sistema:

```
sudo nano /etc/apache2/sites-available/correspondencia.conf
```

Y pegar la siguiente configuración (Reemplace el nombre de dominio con el correspondiente a su red):

```
VirtualHost *:80>
  ServerName scsl-correspondencia.com
  DocumentRoot "/var/www/correspondencia/public"
  <Directory "/var/www/correspondencia/public">
    AllowOverride all
  </Directory>
</VirtualHost>
```

En la linea de comando ejecutar:

```
sudo a2ensite correspondencia
sudo systemctl restart apache2
```
