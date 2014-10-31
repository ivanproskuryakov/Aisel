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

1. Download latest from master: <br/>
`git clone https://github.com/ivanproskuryakov/Aisel.git`
then `cd to aisel/` and download composer <br/>
`curl -sS https://getcomposer.org/installer | php` <br/>
2. Install backend dependencies with composer<br/>
`php composer.phar install`
3. Install Aisel environment
`php app/console aisel:install`
4. Install frontend dependencies with Bower<br/>
`bower install`

Important:<br/>
Bower is a command line utility.Install it with npm.<br/>
$ npm install -g bower<br/>

Once this steps is done you will be able to access the backend:<br/>
`http://ecommmerce.aisel.dev/administration/en/`

Deploy on Live
-----------------------------------
For full javascript minification on frontend use grunt task<br/>
`grunt requirejs`

Tests
-----------------------------------
[Behat](http://behat.org) <br/>
`$ bin/behat`
[PHPSpec](http://phpspec.net/)<br/>
`bin/phpspec run`
[Karma](http://karma-runner.github.io/)<br/>
Unit-test:<br/>
`grunt karma:unit`
Midway:<br/>
`grunt karma:midway`<br/>
E2E:<br/>
`grunt karma:e2e`<br/>


Speed
-----------------------------------
Check with http://tools.pingdom.com/

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