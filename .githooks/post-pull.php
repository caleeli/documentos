<?php
run(
    // Update libraries
    onchange(['composer.json'], 'composer install;') .
    // Rebuild database
    //onchange(['database/migrations', 'database/seeds'], 'composer dumpautoload;php artisan migrate:fresh --seed;') .
    onchange(['database/migrations'], 'composer dumpautoload;php artisan migrate;') .
    // Send email after update
    email('angelitacc27@gmail.com', 'Aplicación actualizada', 'El código de la aplicación fue actualizado en el servidor.')
);
