<?php

require 'recipe/laravel.php';

server('production', 'codeanarchy.org')
  ->user('rhymebin-deployer')
  ->identityFile('~/.ssh/id_rsa.pub', '~/.ssh/id_rsa', '')
  ->env('deploy_path', '/home/rhymebin-deployer/www')
  ->stage('production');

set('repository', 'https://github.com/mogria/rhymebin.git');

// use www-data user of apache
set('http_user', 'www-data');

// copy over the vendor directory to new releases to avoid downloading 
// the same dependencies over again
set('copy_dirs', ['vendor']);
before('deploy:vendors', 'deploy:copy_dirs');

set('keep_releases', 10); // keep the last 10 releases