<?php

namespace Aisel\ResourceBundle\Tests;

/**
 * Class AbstractBackendWebTestCase.
 *
 */
abstract class AbstractBackendWebTestCase extends AbstractWebTestCase
{

    public function setUp()
    {
        parent::setUp();

        $this->logInBackend();
    }

    public function logInBackend($username = 'backenduser', $password = 'backenduser')
    {
        if ($this->um->isAuthenticated() === false) {

            $this->client->request(
                'GET',
                '/backend/api/user/login/?username='. $username . '&password='. $password,
                [],
                [],
                ['CONTENT_TYPE' => 'application/json']
            );
            $response = $this->client->getResponse();
            $content = $response->getContent();
            $result = json_decode($content, true);

            if ($result['status'] !== true ) {
                throw new \LogicException('Authentication failed.');
            }
        }

        return $this->um->isAuthenticated();
    }

}
