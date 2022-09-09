<?php

namespace App\Entity;

use Gesdinet\JWTRefreshTokenBundle\Entity\RefreshToken as BaseRefreshToken;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RefreshTokenRepository;

#[ORM\Entity]
#[ORM\Table(name: "refresh_tokens")]
class RefreshToken extends BaseRefreshToken
{
}
