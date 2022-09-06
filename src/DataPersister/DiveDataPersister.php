<?php

namespace App\DataPersister;

use Symfony\Component\Security\Core\Security;
use App\Entity\Dive;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV1;

class DiveDataPersister implements ContextAwareDataPersisterInterface
{
    private $_entityManager;
    private $request;
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

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Dive;
    }

    /**
     * @param Dive $data
     */
    public function persist($data, array $context = [])
    {

        if ($this->_request->getMethod() === 'POST') {
            $uuid = Uuid::v1();
            $data->setUuid($uuid);
            $data->setOwner($this->_security->getUser());
        }

        if ($this->_request->getMethod() !== 'POST') {
            $data->setUpdatedAt(new \DateTimeImmutable());
        }

        $this->_entityManager->persist($data);
        $this->_entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {
        $this->_entityManager->remove($data);
        $this->_entityManager->flush();
    }
}
