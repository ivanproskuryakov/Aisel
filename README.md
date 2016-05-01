About [![Travis-CI](https://travis-ci.org/ivanproskuryakov/Aisel.svg?branch=master)](https://travis-ci.org/ivanproskuryakov/Aisel) [![Latest Stable Version](https://poser.pugx.org/aisel/aisel/v/stable.svg)](https://packagist.org/packages/aisel/aisel) [![Latest Unstable Version](https://poser.pugx.org/aisel/aisel/v/unstable.svg)](https://packagist.org/packages/aisel/aisel) [![License](https://poser.pugx.org/aisel/aisel/license.svg)](https://packagist.org/packages/aisel/aisel)
-----------------------------------

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/e3761c26-4de8-4679-8645-ddedad0ae4a4/big.png)](https://insight.sensiolabs.com/projects/e3761c26-4de8-4679-8645-ddedad0ae4a4)<br/>
Marketplace on top of AngularJS and Symfony3 - http://aisel.co/

Demo:<br/>
Frontend: http://ecommerce.aisel.co/en/ [user@aisel.co/user]<br/>
Admin: http://admin.ecommerce.aisel.co/en/ [admin@aisel.co/admin]<br/>
Seller: http://admin.ecommerce.aisel.co/en/ [seller@aisel.co/seller]<br/>

<img width="400" src="http://aisel.co/images/frontend_product_view.png"/>


Installation
-----------------------------------
LAMP: https://github.com/ivanproskuryakov/Aisel/wiki/Installation:-LAMP<br/>
Framework: https://github.com/ivanproskuryakov/Aisel/wiki/Installation:-Aisel<br/>
Commands: https://github.com/ivanproskuryakov/Aisel/wiki/Development:-Aisel-commands<br/>

Quick installation:<br/>
https://github.com/ivanproskuryakov/Aisel/blob/master/.travis/apache/virtual.host<br/>
https://github.com/ivanproskuryakov/Aisel/blob/master/.travis/apache/virtual.host<br/>

```
1. git clone git@github.com:ivanproskuryakov/Aisel.git
2. cd Aisel
3. composer install
4. bin/console aisel:install
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


Installation with [Vagrant](https://www.vagrantup.com/)
-----------------------------------
Add to /etc/hosts and open http://aisel.dev/en/<br/>
```
192.168.50.4   api.aisel.dev
192.168.50.4   aisel.dev
192.168.50.4   admin.aisel.dev
```
Launch vagrant box
```
vagrant up
```
Destroy and re-launch vagrant box
```
vagrant halt && vagrant destroy -f && vagrant up
```


Contacts
-----------------------------------
For support and consulting inquiries: https://github.com/ivanproskuryakov/Aisel/wiki/Contact-&-Support

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
