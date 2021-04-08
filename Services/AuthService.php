<?php

namespace Services;


use PsrJwt\Factory\Jwt;
use ReallySimpleJWT\Exception\ValidateException;
use Records\users;

class AuthService
{
    /** @var QueryService */
    private $query_service;
    /** @var string */
    private $secret_key;

    public function __construct(QueryService $query_service, string $secret_key)
    {
        $this->query_service = $query_service;
        $this->secret_key = $secret_key;
    }

    public function getToken(array $user_data): ?string
    {
        /** @var users|null $user */
        $user = $this->query_service->selectRecord(
            users::class,
            'SELECT users.name, users.password, users.privileges FROM users WHERE users.email = ?',
            [$user_data['username']]
        );
        if ($user === null) {
            return null;
        }

        if (password_verify($user_data['password'], $user->password)) {
            $factory = new Jwt();
            $builder = $factory->builder();
            try {
                $token = $builder
                    ->setExpiration(strtotime('+30 day'))
                    ->setIssuedAt(time())
                    ->setIssuer('biograf.api')
                    ->setPayloadClaim('name', $user->name)
                    ->setPayloadClaim('privileges', $user->privileges)
                    ->setSubject($user_data['username'])
                    ->setSecret(base64_decode($this->secret_key))
                    ->build();
            } catch (ValidateException $e) {
                return null;
            }

            return $token->getToken();
        }
        return null;
    }
}
