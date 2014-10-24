About [![Travis-CI](https://travis-ci.org/ivanproskuryakov/Aisel.svg?branch=master)](https://travis-ci.org/ivanproskuryakov/Aisel)
-----------------------------------
[![Latest Stable Version](https://poser.pugx.org/aisel/aisel/v/stable.svg)](https://packagist.org/packages/aisel/aisel)
[![Total Downloads](https://poser.pugx.org/aisel/aisel/downloads.svg)](https://packagist.org/packages/aisel/aisel)
[![Latest Unstable Version](https://poser.pugx.org/aisel/aisel/v/unstable.svg)](https://packagist.org/packages/aisel/aisel)
[![License](https://poser.pugx.org/aisel/aisel/license.svg)](https://packagist.org/packages/aisel/aisel)
<br/>

Aisel is open-source CMS for highload projects based on combination of Symfony2, RESTAPI and AngularJS

Project website: `http://aisel.co/`<br/>
Demo frontend: `http://ecommerce.aisel.co/en/` [frontenduser/frontenduser]<br/>
Demo administration: `http://ecommerce.aisel.co/administration/en/` [backenduser/backenduser]<br/>

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/e3761c26-4de8-4679-8645-ddedad0ae4a4/big.png)](https://insight.sensiolabs.com/projects/e3761c26-4de8-4679-8645-ddedad0ae4a4)<br/>

Installation
-----------------------------------

1.) Download composer<br/>
```bash
curl -sS https://getcomposer.org/installer | php
```
2.) Create project with installer <br/>
```bash
php composer.phar create-project -s dev aisel/aisel
```
cd to aisel/ and finish installation with commands bellow:<br/>
3.) Launch installation:<br/>
```bash
php app/console aisel:install
```
4.) Install frontend dependencies with Bower<br/>
```bash
bower install
```

Important:<br/>
Bower is a command line utility.Install it with npm.<br/>
$ npm install -g bower<br/>

webserver needs permissions to save cache, logs and sessions<br/>
Mac users:<br/>
```bash
sudo chmod +a "_www allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs
sudo chmod +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs app/var
```
Linux users:<br/>
```bash
sudo chown -R www-data:www-data  app/cache app/logs
```

Once this steps is done you will be able to access the backend:<br/>
`http://ecommmerce.aisel.dev/en/administration/`


[Behat](http://behat.org) tests
-----------------------------------

Run Behat using the following command to test backend:

```bash
$ bin/behat
```

[PHPSpec](http://phpspec.net/) tests
-----------------------------------
````
cd Symfony
bin/phpspec run
````

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


Speed
-----------------------------------
http://tools.pingdom.com/fpt/#!/crrqBk/http://ecommerce.aisel.co/en/<br/>
http://tools.pingdom.com/fpt/#!/KwiR4/http://ecommerce.aisel.co/en/pages/<br/>
http://tools.pingdom.com/fpt/#!/dcH16I/http://ecommerce.aisel.co/en/page/categories/<br/>

Mobile ready
-----------------------------------
http://www.responsinator.com/?url=http%3A%2F%2Fdemo.aisel.co%2F%23%21%2Fpage%2Fabout-aisel%2F

Bug tracking
-----------------------------------

Project uses [GitHub issues](https://github.com/ivanproskuryakov/Aisel/issues).
If you have found bug, please create an issue.

MIT License
-----------------------------------

License can be found [here](https://github.com/ivanproskuryakov/Aisel/blob/master/LICENSE).

Authors
-----------------------------------

Part of Aisel package, was originally created by [Ivan Proskuryakov](https://github.com/ivanproskuryakov).
List of [contributors](https://github.com/ivanproskuryakov/AiselConfigBundle/graphs/contributors).

BTC Donations
-----------------------------------
To support ongoing development you may send BitCoin to 1DmBssUeNGXC8VC3BFm3VB3Qc9wmSB7DrK