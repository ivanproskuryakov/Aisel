<?php

/*
 * This file is part of the Aisel package.
 *
 * (c) Ivan Proskuryakov
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aisel\ResourceBundle\Request;

use FOS\RestBundle\Request\RequestBodyParamConverter;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\Serializer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter as SensioParamConverter;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Aisel\ResourceBundle\Exception\ValidationFailedException;

/**
 * Class ParamConverter
 *
 * @author Ivan Proskoryakov <volgodark@gmail.com>
 */
class ParamConverter extends RequestBodyParamConverter
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @param Serializer $serializer
     * @param EntityManager $entityManager
     * @param ValidatorInterface $validator
     * @param TokenStorageInterface $tokenStorage
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(
        Serializer $serializer,
        EntityManager $entityManager,
        ValidatorInterface $validator,
        TokenStorageInterface $tokenStorage,
        EventDispatcherInterface $dispatcher
    ) {
        parent::__construct($serializer, null, null, $validator, 'error');
        $this->em = $entityManager;
        $this->tokenStorage = $tokenStorage;
        $this->dispatcher = $dispatcher;
    }

    public function execute(Request $request, SensioParamConverter $configuration)
    {
        $name = $configuration->getName();
        $options = $configuration->getOptions();
        $resolvedClass = $configuration->getClass();
        $id = $request->attributes->get('id');

        if (('DELETE' === $request->getMethod()) or ('GET' === $request->getMethod())) {
            $convertedValue = $this->em->find($resolvedClass, $id);

            if (null === $convertedValue) {
                throw new NotFoundHttpException('Not found');
            }

        } else {
            $rawPayload = $request->getContent();
            $serializerGroups = isset($options['serializerGroups']) ? $options['serializerGroups'] : null;
            $deserializationContext = DeserializationContext::create();

            if ($serializerGroups) {
                $deserializationContext
                    ->setGroups($serializerGroups)
                ;
            }

            if ($id) {
                $deserializationContext->attributes->set('put_id', $id);
            }

            try {
                $convertedValue = $this->serializer->deserialize(
                    $rawPayload,
                    $resolvedClass,
                    'json',
                    $deserializationContext
                );

                if ($id) {
                    if ($id !== $convertedValue->getId()) {
                        throw new \LogicException('Ids do not match');
                    }
                }
            } catch (\Exception $e) {
                throw new \LogicException($e);
            }

            $violations = $this->validator->validate($convertedValue);

            if ($violations->count()) {
                throw new ValidationFailedException($violations);
            }
        }

        return $convertedValue;
    }


}
