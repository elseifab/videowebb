<?php
namespace Deployer;

include_once __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . '/vendor/deployer/deployer/recipe/composer.php';

host('video.elseif.se')
    ->port(22)
    ->set('deploy_path', '/mnt/persist/www/docroot_video')
    ->user('deploy')
    ->set('branch', 'master')
    ->stage('production')
    ->identityFile('~/.ssh/id_rsa');

set('repository', 'git@github.com:elseifab/videowebb.git');

set('env_vars', '/usr/bin/env');
set('keep_releases', 5);
set('shared_dirs', ['web/app/uploads']);
set('shared_files', ['.env']);

task('activate-plugins-and-theme', function () {
    run("cd {{ deploy_path }}/current && vendor/bin/wp plugin activate redirection");
    run("cd {{ deploy_path }}/current && vendor/bin/wp theme activate videowebb");
});
after('deploy', 'activate-plugins-and-theme');
