AiselConfigBundle
-----------------------------------
Administration settings interface for Symfony2 projects which based on SonataAdminBundle

Notes
-------------
Bundle not stable, only for development purposes

Documentation
-------------

Add to config.yml<br/>
```bash
aisel_config:
    route_prefix: config_ # ex: config_contact
    entities:
        homepage:
            order: 0
            controller: AiselSettingsBundle:ConfigHomepage:modify
```

Add routes to routing.yml<br/>
```bash
aisel_config:
    resource: "@AiselConfigBundle/Resources/config/routing.yml"
    prefix:   /
```

Create form class and set $form variable with in controller as shown bellow<br/>
```bash
<?php

namespace Aisel\SettingsBundle\Form\Type;

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

Create and extend controller from class SettingsController<br/>
```bash
<?php
namespace Aisel\SettingsBundle\Controller;
use Aisel\ConfigBundle\Controller\SettingsController;
class ConfigHomepageController extends SettingsController
{

    public $form = "\Aisel\SettingsBundle\Form\Type\ConfigHomepageType";

    /**
     * {@inheritdoc }
     */
    protected function getTemplateVariables()
    {
        $this->templateVariables['base_template'] = 'AiselSettingsBundle::layout.html.twig';
        $this->templateVariables['admin_pool'] = $this->container->get('sonata.admin.pool');
        $this->templateVariables['blocks'] = $this->container->getParameter('sonata.admin.configuration.dashboard_blocks');

        return $this->templateVariables;
    }

}
```

Create ConfigHomepage controller<br/>

MIT License
-----------------------------------

License can be found [here](https://github.com/ivanproskuryakov/Aisel/blob/master/LICENSE).

Authors
-----------------------------------

Part of Aisel package, was originally created by [Ivan Proskuryakov](http://www.magazento.com).
List of [contributors](https://github.com/ivanproskuryakov/AiselConfigBundle/graphs/contributors).