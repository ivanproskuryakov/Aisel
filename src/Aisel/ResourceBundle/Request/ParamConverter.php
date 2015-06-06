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
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Aisel\ResourceBundle\Exception\ValidationFailedException;
use JMS\Serializer\SerializationContext;

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
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * @param Serializer               $serializer
     * @param EntityManager            $entityManager
     * @param ValidatorInterface       $validator
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(
        Serializer $serializer,
        EntityManager $entityManager,
        ValidatorInterface $validator,
        EventDispatcherInterface $dispatcher
    ) {
        parent::__construct($serializer, null, null, $validator, 'error');
        $this->em = $entityManager;
        $this->dispatcher = $dispatcher;
    }

    /**
     * execute
     *
     * @param Request              $request
     * @param SensioParamConverter $configuration
     *
     * @return bool|mixed
     */
    public function execute(Request $request, SensioParamConverter $configuration)
    {
        $name = $configuration->getName();
        $options = $configuration->getOptions();
        $resolvedClass = $configuration->getClass();
        $id = $request->attributes->get('id');
        $method = $request->getMethod();
        $rawPayload = $request->getContent();

        switch (true) {
            case ('GET' === $method):
                $convertedValue = $this->loadEntity($resolvedClass, $id, $maxDepth = true);
                break;

            case ('DELETE' === $method):
                $convertedValue = $this->loadEntity($resolvedClass, $id);
                break;

            case ('PUT' === $method):
                $payload = array_merge(
                    array('id' => $id),
                    json_decode($rawPayload, true)
                );
                $convertedValue = $this->updateEntity($resolvedClass, json_encode($payload));
                break;

            case ('POST' === $method):
                $convertedValue = $this->updateEntity($resolvedClass, $rawPayload);
                break;
        }

        return $convertedValue;
    }

    /**
     * @param $resolvedClass
     * @param $id
     * @param $maxDepth
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @throws NotFoundHttpException
     *
     * @return mixed $entity
     */
    protected function loadEntity($resolvedClass, $id, $maxDepth = false)
    {
        $entity = $this->em->find($resolvedClass, $id);

        if (null === $entity) {
            throw new NotFoundHttpException('Not found');
        }

        if ($maxDepth) {
            $entity = $this->serializer->serialize(
                $entity, 'json',
                SerializationContext::create()->enableMaxDepthChecks()
            );

            return json_decode($entity, true);
        }

        return $entity;
    }

    /**
     * @param $resolvedClass
     * @param $rawPayload
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @throws NotFoundHttpException
     *
     * @return mixed $entity
     */
    protected function updateEntity($resolvedClass, $rawPayload)
    {
        $serializerGroups = isset($options['serializerGroups']) ? $options['serializerGroups'] : null;
        $deserializationContext = DeserializationContext::create();

        if ($serializerGroups) {
            $deserializationContext
                ->setGroups($serializerGroups)
            ;
        }
        $convertedValue = $this->serializer->deserialize(
            $rawPayload,
            $resolvedClass,
            'json'
        );
        $violations = $this->validator->validate($convertedValue);

        if ($violations->count()) {
            throw new ValidationFailedException($violations);
        }

        return $convertedValue;
    }

}
