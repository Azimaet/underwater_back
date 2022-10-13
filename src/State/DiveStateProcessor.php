<?php

namespace App\State;

use Symfony\Component\Uid\Uuid;

use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Metadata\Operation;

class DiveStateProcessor implements ProcessorInterface
{
    private $_entityManager;
    private $_security;

    public function __construct(
        EntityManagerInterface $entityManager,
        RequestStack $request,
        Security $security
    ) {
        $this->_entityManager = $entityManager;
        $this->_request = $request->getCurrentRequest();
        $this->_security = $security;
    }

    public function process($data, Operation $operation, array $uriVariables = [], array $context = [])
    {

        if ($operation->getName() === 'create') {
            $uuid = Uuid::v1();
            $data->setUuid($uuid);
            $data->setOwner($this->_security->getUser());
        } else {
            $data->setUpdatedAt(new \DateTimeImmutable());
        }

        $this->_entityManager->persist($data);
        $this->_entityManager->flush();

        return $data;
    }
}
