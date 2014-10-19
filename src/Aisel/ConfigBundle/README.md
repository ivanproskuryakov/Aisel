AiselConfigBundle
-----------------------------------
Administration settings interface for Symfony2 projects. Can be easily integrated with SonataAdminBundle

Notes
-------------
Bundle not stable, only for development purposes

Documentation
-------------

1. Add to config.yml<br/>
```bash
aisel_config:
    settings_route: /settings/{editLocale}
    route_prefix: config_ # ex: config_contact
    entities:
        homepage:
            order: 0
            controller: TestConfigBundle:ConfigHomepage:modify
```

Add to AppKernel.php<br/>
```bash
            new Aisel\ConfigBundle\AiselConfigBundle(),
```

2. Add routes to routing.yml<br/>
```bash
aisel_config:
    resource: "@AiselConfigBundle/Resources/config/routing.yml"
    prefix:   /
```

3. Create form class and set $form variable with in controller as shown bellow<br/>
```bash
<?php

namespace Test\Config\Bundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ConfigHomepageType extends AbstractType
{

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', 'text', array('label' => 'Content'))
            ->add('save', 'submit', array('label' => 'Save', 'attr' => array('class' => 'btn btn-primary')));
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'config_homepage';
    }

}
```

4. Create and extend controller from class SettingsController<br/>
```bash
<?php

namespace Test\Config\Bundle\Controller;

use Aisel\ConfigBundle\Controller\SettingsController;

class ConfigHomepageController extends SettingsController
{

    public $form = "\Test\Config\Bundle\Form\Type\ConfigHomepageType";

    /**
     * {@inheritdoc }
     */
    protected function getTemplateVariables()
    {
        return $this->templateVariables;
    }

}
```
5. Check that route available with router:debug
```bash
php app/console router:debug
config_homepage          ANY    ANY    ANY  /settings/{editLocale}/homepage
```
editLocale is your current locale param, controller should be available by:<br/>
/settings/ru/homepage



MIT License
-----------------------------------

License can be found [here](https://github.com/ivanproskuryakov/Aisel/blob/master/LICENSE).

Authors
-----------------------------------

Part of Aisel package, was originally created by [Ivan Proskuryakov](http://www.magazento.com).
List of [contributors](https://github.com/ivanproskuryakov/AiselConfigBundle/graphs/contributors).