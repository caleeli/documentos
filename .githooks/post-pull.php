<?php
run('composer dump-autoload;'
    . 'php artisan migrate --database=hr;'
    . 'php artisan migrate:update;'
    . 'php artisan db:seed');
