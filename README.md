# Rhymebin

A single page application for finding rhymes with its own rhyme database. You need to populate the database yourself (as of now). Every word also needs the information on how to split syllables and the phonetic sign for it's vowel. This information is then used to give better rhymes and find more rhymes.

## Development

For the Backend the Lumen Framework is used along with eloquent as ORM.
On the front-end angular is being used to communicate with the lumen API (on `/api`).

### Requirements & Setup

To develop you need to have the following tools installed:

 * `node`, `npm`
 * `php` >= version 5.6
 * `composer`

Then run the `install.sh` script in the root of the repository

    ./install.sh

If you have these installed either install bower & gulp with the following command

    npm install -g bower gulp

Or install [`direnv`](https://github.com/direnv/direnv) and type the following command while in the root of the repository: 

    direnv allow
    
This will add `vendor/bin` and `node_modules/{gulp,bower}/bin` to your path while you are inside the repository with your shell.

### Running in development mode

For development you can use the `serve.sh` script to run PHPs own internal webserver on `127.0.0.1:1337`.

    $ ./serve.sh
     ____  _     _   _           _   _ ____  _
     |  _ \| |__ (_) (_)_ __ ___ (_)_(_) __ )(_)_ __
     | |_) | '_ \| | | | '_ ` _ \ / _ \|  _ \| | '_ \
     |  _ <| | | | |_| | | | | | |  __/| |_) | | | | |
     |_| \_\_| |_|\__, |_| |_| |_|\___||____/|_|_| |_|
                  |___/
    RhymeBin: killing previous processes, if they are still running
    RhymeBin: Running gulp watch with live-reload ... 
    RhymeBin: Running PHPs own webserver on 127.0.0.1:1337 WEBROOT=public/  ... 
    PHP 5.6.11-1ubuntu3.4 Development Server started at Thu Oct 13 21:58:59 2016
    Listening on http://127.0.0.1:1337
    Document root is /home/mogria/Code/rhymebin/public
    Press Ctrl-C to quit.
    [21:59:00] Using gulpfile ~/Code/rhymebin/gulpfile.js
    [21:59:00] Starting 'js-combine'...

This will automatically run gulp & LiveReload. LiveReload only works for CSS, Images and Javascript files. For the anglar templates to reload you need to refresh the page.

### Testing

PHPUnit is used as the testing framework. You can run the tests like this:

    phpunit

## Deployment

[Deployer](https://github.com/deployphp/deployer) is being used to deploy this project to a server. See the [`deploy.php`](https://github.com/mogria/rhymebin/blob/master/deploy.php) for the configuration.

For production live reload is being disabled and `gulp --production` is run. This will combine all HTML, angular templates, CSS & HTML into a single file and save it in `public/index.html`. There is also a `.htaccess` which gets generated for easy integration with apache. Just make the `public` folder the RootDirectory of your VirtualHost.
Additionally you need to configure your `.env` file for your sever for the database backend (but just once, because it's shared between releases).
**Important:** Don't forget to change the `APP_SECRET`.

## License
The Rhymebin is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
