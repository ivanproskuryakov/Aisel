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

/**
 * Class ParamConverter
 *
 * @author Ivan Proskuryakov <volgodark@gmail.com>
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
     * @param EntityManager          $em
     * @param ValidatorInterface       $validator
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(
        Serializer $serializer,
        EntityManager $em,
        ValidatorInterface $validator,
        EventDispatcherInterface $dispatcher
    ) {
        parent::__construct($serializer, null, null, $validator, 'error');
        $this->em = $em;
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
        $id = $request->attributes->get('id');
        $locale = $request->attributes->get('locale');
        $url = $request->attributes->get('url');

        $name = $configuration->getName();
        $options = $configuration->getOptions();
        $resolvedClass = $configuration->getClass();
        $method = $request->getMethod();
        $rawPayload = $request->getContent();

        switch (true) {
            case ('GET' === $method):
                $convertedValue = $this->loadEntity($resolvedClass, $id, $locale, $url );
                break;

            case ('DELETE' === $method):
                $convertedValue = $this->loadEntity($resolvedClass, $id, $locale, $url );
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
     * @param $locale
     * @param $url
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @throws \Doctrine\ORM\TransactionRequiredException
     * @throws NotFoundHttpException
     *
     * @return mixed $entity
     */
    protected function loadEntity($resolvedClass, $id, $locale, $url)
    {
        if (isset($locale) && isset($url)) {
            $entity = $this->em->getRepository($resolvedClass)->findOneBy(
                array(
                    'metaUrl' => $url,
                    'locale' => $locale
                )
            );
        }

        if ($id) {
            $entity = $this->em->find($resolvedClass, $id);
        }

        if (null === $entity) {
            throw new NotFoundHttpException('Not found');
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