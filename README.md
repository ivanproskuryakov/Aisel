About [![Travis-CI](https://travis-ci.org/ivanproskuryakov/Aisel.svg?branch=master)](https://travis-ci.org/ivanproskuryakov/Aisel)
-----------------------------------

Aisel is open-source CMS for highload projects based on combination of Symfony2, RESTAPI and AngularJS

Project website: http://aisel.co/<br/>
Demo frontend: http://demo.aisel.co/ [frontenduser/frontenduser]<br/>
Demo administration: http://demo.aisel.co/administration [backenduser/backenduser]<br/>

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/e3761c26-4de8-4679-8645-ddedad0ae4a4/big.png)](https://insight.sensiolabs.com/projects/e3761c26-4de8-4679-8645-ddedad0ae4a4)<br/>

Installation
-----------------------------------

1.) Download composer<br/>
```bash
curl -sS https://getcomposer.org/installer | php
```
2.) Create project, installer will ask you dbname, username, password, etc.. <br/>
```bash
php composer.phar create-project -s dev aisel/aisel
```
then cd aisel/ and finish installation with commands bellow:<br/>
3.) Launch installation:<br/>
```bash
php app/console aisel:install
```
4.) Install frontend dependencies with Bower<br/>
```bash
bower install
```

Important:<br/>
Bower is a command line utility. Install it with npm.<br/>
$ npm install -g bower<br/>

webserver needs permissions to save cache, logs and sessions<br/>
Mac users:<br/>
```bash
sudo chmod +a "_www allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs<br/>
sudo chmod +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs app/var<br/>
```
Linux users:<br/>
```bash
sudo chown -R www-data:www-data  app/cache app/logs<br/>
```



Once this steps is done you will be able to access backend, similar to example bellow:
http://ecommmerce.aisel.dev/en/administration/<br/>


[Behat](http://behat.org) tests
-----------------------------------

Run Behat using the following command to test backend:

```bash
$ bin/behat
```

[Karma](http://karma-runner.github.io/) tests
-----------------------------------

Karma unit tests:
```bash
$ grunt karma:unit
```

Karma midway testing:
```bash
$ grunt karma:midway
```

Karma e2e testing:
```bash
$ grunt karma:e2e
```

Sitemap
-----------------------------------
Task: <b>php app/console aisel:sitemap:generate</b><br/>
This command will generate sitemap.xml<br/>
Example: http://demo.aisel.co/sitemap.xml<br/>

Mobile ready
-----------------------------------
http://www.responsinator.com/?url=http%3A%2F%2Fdemo.aisel.co%2F%23%21%2Fpage%2Fabout-aisel%2F

SEO for JS website
-----------------------------------
Check Google index status: https://www.google.com/search?q=site%3Ademo.aisel.co<br/>

To make JS website indexable by Google you need to generate page snapshots<br/>
Snapshots handled by https://github.com/localnerve/html-snapshots<br/>
To generate snapshots run in terminal: <b>node snapshots.js</b><br/>
Task will create snapshots in directory web/snapshots. In the end you will need to test like this:<br/>
For page http://demo.aisel.co/#!/pages/ you need type in terminal: <br/>curl http://demo.aisel.co/?_escaped_fragment_=/pages/<br/>
Full info how to make SEO for JS website read here: https://developers.google.com/webmasters/ajax-crawling/docs/specification

Bug tracking
-----------------------------------

Project uses [GitHub issues](https://github.com/ivanproskuryakov/Aisel/issues).
If you have found bug, please create an issue.


MIT License
-----------------------------------

License can be found [here](https://github.com/ivanproskuryakov/Aisel/blob/master/LICENSE).

Authors
-----------------------------------

Aisel was originally created by [Ivan Proskuryakov](http://www.magazento.com).
List of [contributors](https://github.com/ivanproskuryakov/Aisel/graphs/contributors).

BTC Donations
-----------------------------------
To support ongoing development you may send BitCoin to 1DmBssUeNGXC8VC3BFm3VB3Qc9wmSB7DrK

Speed Test
-----------------------------------
Clean Ubuntu with 512 RAM<br/>
Symfony2 in DEV environment<br/>
No server or MySQL tweaks<br/>
http://tools.pingdom.com/fpt/#!/dpgreK/http://demo.aisel.co/#!/ - 539ms
http://tools.pingdom.com/fpt/#!/OVkNs/http://demo.aisel.co/#!/pages/ -  1.05s
http://tools.pingdom.com/fpt/#!/c7MfRS/http://demo.aisel.co/#!/page/userpage-10/ - 501ms