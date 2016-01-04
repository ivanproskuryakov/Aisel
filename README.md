About [![Travis-CI](https://travis-ci.org/ivanproskuryakov/Aisel.svg?branch=master)](https://travis-ci.org/ivanproskuryakov/Aisel) [![Latest Stable Version](https://poser.pugx.org/aisel/aisel/v/stable.svg)](https://packagist.org/packages/aisel/aisel) [![Latest Unstable Version](https://poser.pugx.org/aisel/aisel/v/unstable.svg)](https://packagist.org/packages/aisel/aisel) [![License](https://poser.pugx.org/aisel/aisel/license.svg)](https://packagist.org/packages/aisel/aisel)
-----------------------------------

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/e3761c26-4de8-4679-8645-ddedad0ae4a4/big.png)](https://insight.sensiolabs.com/projects/e3761c26-4de8-4679-8645-ddedad0ae4a4)<br/>
FullStack based on AngularJS, PHP(Symfony2) - http://aisel.co/

Frontend demo: http://ecommerce.aisel.co/en/ [frontenduser/frontenduser]<br/>
Backend demo: http://admin.ecommerce.aisel.co/en/ [backenduser/backenduser]<br/>

<img width="400" src="http://aisel.co/images/frontend_product_view.png"/>


Ask us anything -- or issue, question, or feedback.
https://github.com/ivanproskuryakov/Aisel/issues/new

Installation with Vagrant - https://www.vagrantup.com/
-----------------------------------
cd to project directory, where ```Vagrantfile``` is located and run<br/>
```
vagrant up
```
add to /etc/hosts<br/>
```
192.168.50.4   api.aisel.dev
192.168.50.4   aisel.dev
192.168.50.4   admin.aisel.dev
```
open in browser http://aisel.dev/

to fully destroy and re-launch vagrant box, run<br/>
```
vagrant halt && vagrant destroy -f && vagrant up
```




Installation without Vagrant
-----------------------------------
Framework: https://github.com/ivanproskuryakov/Aisel/wiki/Installation:-Aisel<br/>
Environment: https://github.com/ivanproskuryakov/Aisel/wiki/Installation:-LAMP<br/>
Commands: https://github.com/ivanproskuryakov/Aisel/wiki/Development:-Aisel-commands<br/>

Quick installation:<br/>
https://github.com/ivanproskuryakov/Aisel/blob/master/.travis/apache/virtual.host<br/>

```
1. git clone git@github.com:ivanproskuryakov/Aisel.git
2. cd Aisel
3. composer install
4. php app/console aisel:install
5. Give permissions to following directories: 
 - app/cache/
 - app/var/
 - app/logs/
 - web/media/
```

Requirements:<br/>
```
Node.js and NPM
Bower
Grunt
```

Contacts
-----------------------------------
For support and consulting inquiries: https://github.com/ivanproskuryakov/Aisel/wiki/Contact-&-Support

Speed
-----------------------------------
Check with http://tools.pingdom.com/

Mobile ready check on [Responsinator](http://www.responsinator.com/)
-----------------------------------
http://www.responsinator.com/?url=ecommerce.aisel.co%2Fen%2Fproducts%2F

Bug tracking
-----------------------------------
Project uses [GitHub issues](https://github.com/ivanproskuryakov/Aisel/issues).
If you have found bug, please create an issue.

MIT License
-----------------------------------
License can be found [here](https://github.com/ivanproskuryakov/Aisel/blob/master/LICENSE).

Authors
-----------------------------------
Part of Aisel package, was originally created by [Ivan Proskuryakov](https://github.com/ivanproskuryakov) https://github.com/ivanproskuryakov<br/>
List of [contributors](https://github.com/ivanproskuryakov/AiselConfigBundle/graphs/contributors).
