<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\RequestStack;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Doctrine\ORM\EntityManagerInterface;

class JWTCreatedListener
{
    /**
     * @var RequestStack
     */
    private $requestStack;
    private $_entityManager;

    /**
     * @param RequestStack $requestStack
     */
    public function __construct(
        RequestStack $requestStack,
        EntityManagerInterface $entityManager,
    ) {
        $this->requestStack = $requestStack;
        $this->_entityManager = $entityManager;
    }

    /**
     * @param JWTCreatedEvent $event
     *
     * @return void
     */
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $request = $this->requestStack->getCurrentRequest();

        $payload = $event->getData();
        $user = $event->getUser();
        $payload['username'] = $user->getUsername();
        $payload['id'] = $user->getId();
        $payload['avatar'] = $user->getAvatar();

        $event->setData($payload);

        $header = $event->getHeader();
        $header['cty'] = 'JWT';

        $event->setHeader($header);

        $user->setActivatedAt(new \DateTimeImmutable());

        $this->_entityManager->persist($user);
        $this->_entityManager->flush();
    }
}
