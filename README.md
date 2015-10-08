About [![Travis-CI](https://travis-ci.org/ivanproskuryakov/Aisel.svg?branch=master)](https://travis-ci.org/ivanproskuryakov/Aisel)
-----------------------------------

[![Latest Stable Version](https://poser.pugx.org/aisel/aisel/v/stable.svg)](https://packagist.org/packages/aisel/aisel)
[![Latest Unstable Version](https://poser.pugx.org/aisel/aisel/v/unstable.svg)](https://packagist.org/packages/aisel/aisel)
[![License](https://poser.pugx.org/aisel/aisel/license.svg)](https://packagist.org/packages/aisel/aisel)
<br/>
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/e3761c26-4de8-4679-8645-ddedad0ae4a4/big.png)](https://insight.sensiolabs.com/projects/e3761c26-4de8-4679-8645-ddedad0ae4a4)<br/>
FullStack based on AngularJS, PHP(Symfony2), MongoDB - http://aisel.co/

Frontend demo: `http://ecommerce.aisel.co/en/` [frontenduser/frontenduser]<br/>
Backend demo: `http://admin.ecommerce.aisel.co/` [backenduser/backenduser]<br/>

<img width="400" src="http://aisel.co/images/frontend_product_view.png"/>

Requirements:<br/>
```
Node.js and NPM
Bower
Grunt
```

Installation
-----------------------------------
Installling framework: https://github.com/ivanproskuryakov/Aisel/wiki/Installation:-Aisel
Installling environment: https://github.com/ivanproskuryakov/Aisel/wiki/Installation:-LAMP

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

Screencast:
<iframe width="420" height="315" src="https://www.youtube.com/embed/Z1FDuhCtc38" frameborder="0" allowfullscreen></iframe>
[![ScreenShot](http://img.youtube.com/vi/Z1FDuhCtc38/0.jpg)](https://www.youtube.com/watch?v=Z1FDuhCtc38)


Sitemap 
```
php app/console aisel:sitemap:generate  
```
 
Running Tests
-----------------------------------
[Protractor](http://angular.github.io/protractor/#/) <br/>
`protractor frontend/protractor/conf.js`<br/>
`protractor backend/protractor/conf.js`<br/>

[PHPUnit](https://phpunit.de/) <br/>
`bin/phpunit -c app src/`<br/>

[PHPSpec](http://phpspec.net/) <br/>
`bin/phpspec run`<br/>

XML Sitemap & Google indexing
-----------------------------------
http://ecommerce.aisel.co/sitemap.xml<br/>
https://www.google.com/search?q=site%3Aecommerce.aisel.co

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
Part of Aisel package, was originally created by [Ivan Proskuryakov](https://github.com/ivanproskuryakov) https://twitter.com/iproskuryakov<br/>
List of [contributors](https://github.com/ivanproskuryakov/AiselConfigBundle/graphs/contributors).

BTC Donations
-----------------------------------
To support ongoing development you may send BitCoin to 1DmBssUeNGXC8VC3BFm3VB3Qc9wmSB7DrK

Consulting
-----------------------------------
If you're need consulting, contact with me by e-mail volgodark@gmail.com
