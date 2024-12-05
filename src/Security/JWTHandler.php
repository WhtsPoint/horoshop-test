<?php

namespace App\Security;

use App\Entity\AuthUser;
use App\Exception\InvalidTokenException;
use App\JWT\JWT;
use SensitiveParameter;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

readonly class JWTHandler implements AccessTokenHandlerInterface
{
    public function __construct(private JWT $JWT) {
    }

    public function getUserBadgeFrom(#[SensitiveParameter] string $accessToken): UserBadge
    {
        try {
            ['id' => $id, 'role' => $role] = $this->JWT->decodeToken($accessToken);
        } catch (InvalidTokenException $exception) {
            throw new HttpException(401, $exception->getMessage());
        }
        return new UserBadge('11', fn () => new AuthUser($id, [$role]));
    }
}