<?php

namespace App\State;

use Symfony\Component\Security\Core\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Metadata\Operation;

class UserStateProcessor implements ProcessorInterface
{
    private $_entityManager;
    private $_passwordEncoder;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordEncoder,
    ) {
        $this->_entityManager = $entityManager;
        $this->_passwordEncoder = $passwordEncoder;
    }

    public function process($data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        if ($operation->getName() === 'create') {
            $data->setSubscribedAt(new \DateTimeImmutable());
            $data->setActivatedAt(new \DateTimeImmutable());
        } else if ($operation->getName() === 'update') {
            $data->setUpdatedAt(new \DateTimeImmutable());
        }

        if ($data->getPlainPassword()) {
            $data->setPassword(
                $this->_passwordEncoder->hashPassword(
                    $data,
                    $data->getPlainPassword()
                )
            );

            $data->eraseCredentials();
        }

        $this->_entityManager->persist($data);
        $this->_entityManager->flush();

        return $data;
    }
}
