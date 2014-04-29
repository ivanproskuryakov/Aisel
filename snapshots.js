var htmlSnapshots = require('html-snapshots');
var result = htmlSnapshots.run({
    input: "array",
    source: [
            "http://aisel.dev/#!/",
            "http://aisel.dev/#!/contact/",
            "http://aisel.dev/#!/page/about-aisel"
    ],
    outputDir: "web/snapshots",
    outputDirClean: true,
    selector: ".navbar-header",
    timeout: 10000
}, function(err, snapshotsCompleted) {
    var fs = require('fs');
    fs.rename('web/snapshots/#!', 'web/snapshots/views', function(err) {
        if ( err ) console.log('ERROR: ' + err);
    });
});

