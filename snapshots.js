var htmlSnapshots = require('html-snapshots');
var result = htmlSnapshots.run({
    input: "sitemap",
    source: "web/sitemap.xml",
    outputDir: "web/snapshots",
    outputDirClean: true,
    selector: ".navbar-header",
    timeout: 10000,
    processLimit: 1
}, function(err, snapshotsCompleted) {
    var fs = require('fs');
    fs.rename('web/snapshots/#!', 'web/snapshots/views', function(err) {
        if ( err ) console.log('ERROR: ' + err);
    });
});

