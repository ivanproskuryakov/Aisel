var htmlSnapshots = require('html-snapshots');
var result = htmlSnapshots.run({
    input: "array",
    source: ["http://aisel.dev/#!/","http://aisel.dev/#!/page/about-aisel","http://aisel.dev/#!/contact/","http://aisel.dev/#!/categories/"],
    outputDir: "web/snapshots",
    timeout: 10000
});