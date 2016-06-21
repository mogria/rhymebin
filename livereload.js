var watches = [
    'public/js',
    'public/img',
    'public/css'
];

livereload = require('livereload');
server = livereload.createServer();

console.log('LiveReload server started');
watches.forEach(function(watch) {
    console.log('watching ' + watch);
    server.watch(__dirname + '/' + watch );
});
