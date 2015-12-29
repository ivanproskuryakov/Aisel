<?php

namespace Aisel\ResourceBundle\Tests;

use Aisel\BackendUserBundle\Entity\BackendUser;

/**
 * Class AbstractBackendWebTestCase.
 *
 */
abstract class AbstractBackendWebTestCase extends AbstractWebTestCase
{

    /**
     * @var BackendUser
     */
    protected $backendUser = null;

    public function setUp()
    {
        parent::setUp();

        $this->backendUser = $this->logInBackend();
    }

}
