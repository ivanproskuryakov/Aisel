var htmlSnapshots = require('html-snapshots');
var result = htmlSnapshots.run({
    input: "array",
    source: [
            "http://aisel.dev/#!/",
            "http://aisel.dev/#!/contact/",
            "http://aisel.dev/#!/page/about-aisel"
//            "http://aisel.dev/#!/categories/"
    ],
    outputDir: "web/snapshots",
//    outputPath: {
//        "http://aisel.dev/#!/page/about-aisel": "page/about-aisel",
//        "http://aisel.dev/#!/contact/": "contact"
//    },
    outputDirClean: true,
//    checkInterval: 1000,
    selector: ".navbar-header",
    timeout: 10000
});
