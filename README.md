About
========================

Aisel is open source project based on combination Symfony2 and AngularJS for frontend.

Project website: http://aisel.co/<br/>
Sandbox frontend: http://sandbox.aisel.co/ [frontenduser/frontenduser]<br/>
Sandbox administration: http://sandbox.aisel.co/administration [backenduser/backenduser]<br/>

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/e3761c26-4de8-4679-8645-ddedad0ae4a4/big.png)](https://insight.sensiolabs.com/projects/e3761c26-4de8-4679-8645-ddedad0ae4a4)

Installation
========================

1.) cd to your website directory and download composer with:  <br/>
curl -sS https://getcomposer.org/installer | php<br/>
2.) Create project, installer will ask you dbname, username, password, etc.. <br/>
php composer.phar create-project -s dev aisel/aisel - (create project)<br/>
3.) Create databasewith GUI tool like phpmyadmin or with command<br/>
php app/console doctrine:schema:create<br/>
3.) Load initial data in database with<br/>
php app/console doctrine:fixtures:load<br/>
5.) Clear Symfony cache directory<br/>
php app/console cache:clear --env=dev<br/>
6.) Install frontend dependencies with<br/>
bower install<br/>
7.) Important: webserver needs permissions to write cache in aisel/app/cache/<br/>
sudo chmod +a "_www allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs<br/>
sudo chmod +a "`whoami` allow delete,write,append,file_inherit,directory_inherit" app/cache app/logs<br/>
8.) Add Links to CSS and JS files<br/>
php app/console assets:install web --symlink

Once this steps is done you will be able to access admin section from http://websitename.dev/administration/
and frontend at http://websitename.dev/

Sitemap
========================
Task: <b>php app/console aisel:sitemap:generate</b><br/>
This command will generate sitemap.xml<br/>
Example: http://sandbox.aisel.co/sitemap.xml<br/>

SEO for JS website
========================
To make JS website indexable by Google you need to generate snapshots
Snapshots handled by https://github.com/localnerve/html-snapshots<br/>
To generate snapshots run in terminal: <b>node snapshots.js</b><br/>
Task will create snapshots in directory web/snapshots. In the end you will need to test like this:<br/>
For page http://sandbox.aisel.co/#!/pages/ you need type in terminal: <br/>curl http://sandbox.aisel.co/?_escaped_fragment_=/pages/<br/>
Google index: https://www.google.ru/search?q=site%3Asandbox.aisel.co<br/>
Full info how to make SEO for JS website read here: https://developers.google.com/webmasters/ajax-crawling/docs/specification

Speed Test
========================
 - Clean Ubuntu with 512 RAM<br/>
 - Symfony2 in DEV environment<br/>
 - No server or MySQL tweaks<br/>
http://tools.pingdom.com/fpt/#!/XzytX/http://sandbox.aisel.co/#!/ - 704ms
http://tools.pingdom.com/fpt/#!/b3BHG9/http://sandbox.aisel.co/#!/pages/ -  773ms
http://tools.pingdom.com/fpt/#!/dZajwY/http://sandbox.aisel.co/#!/page/userpage-10/ - 751ms

Bug tracking
========================

Project uses [GitHub issues](https://github.com/ivanproskuryakov/Aisel/issues).
If you have found bug, please create an issue.

MIT License
-----------

License can be found [here](https://github.com/ivanproskuryakov/Aisel/blob/master/LICENSE).

Authors
-------

Aisel was originally created by [Ivan Proskuryakov](http://www.magazento.com).
See the list of [contributors](https://github.com/ivanproskuryakov/Aisel/graphs/contributors).