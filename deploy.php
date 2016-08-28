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

env('bin/npm', function() {
  return run('which npm')->toString();
});

env('bin/bower', function() {
  return run('which bower')->toString();
});

env('bin/gulp', function() {
  return run('which gulp')->toString();
});

task('npm:install', function() {
  $output = run('cd {{deploy_path}}/current && {{bin/npm}} install --production');
  writeln('<info>' . $output . '</info>');
})->desc('Install npm dependencies');

task('bower:install', function() {
  $output = run('cd {{deploy_path}}/current && {{bin/bower}} install --production');
  writeln('<info>' . $output . '</info>');
})->desc('Install bower dependencies');

task('gulp:all', function() {
  $output = run('cd {{deploy_path}}/current && {{bin/gulp}} --production');
  writeln('<info>' . $output . '</info>');
})->desc('Run all gulp tasks');

task('compile:assets', ['npm:install', 'bower:install', 'gulp:all']);

task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'compile:assets',
    'deploy:writable',
    'deploy:symlink',
    'cleanup'
])->desc('Deploy your project');
