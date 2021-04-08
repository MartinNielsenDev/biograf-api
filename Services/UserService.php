<?php

namespace Services;

use Lib\CurrentUser;
use Models\User;
use Records\postcodes;

class UserService
{
    /** @var QueryService */
    private $query_service;

    public function __construct(QueryService $query_service)
    {
        $this->query_service = $query_service;
    }

    private function toModel(array $array): User
    {
        $model = new User();
        $model->setId($array['id']);
        $model->setEmail($array['email']);
        $model->setName($array['name']);
        $model->setAddress($array['address']);
        $model->setPostCode($array['postCode']);
        $model->setCityName($array['cityName'] ?? null);
        $model->setPhoneNumber($array['phoneNumber']);
        $model->setPrivileges($array['privileges']);

        return $model;
    }

    public function createUser(array $array): ?User
    {
        if (!isset($array['email']) || !isset($array['password']) || !isset($array['name']) || !isset($array['address']) || !isset($array['postCode']) || !isset($array['phoneNumber']) || !isset($array['privileges'])) {
            return null;
        }
        $user = $this->toModel($array);

        if (CurrentUser::$current_user->getPrivileges() <= $user->getPrivileges()) {
            return null;
        }
        $password_hash = password_hash($array['password'], PASSWORD_DEFAULT);

        /** @var postcodes|null $postCode */
        $postCode = $this->query_service->selectRecord(postcodes::class, 'SELECT id, postCode, cityName FROM postcodes WHERE postCode = ?', [$user->getPostCode()]);
        if ($postCode === null) {
            return null;
        }

        /** @var User|null $user */
        $id = $this->query_service->insertRecord(
            'INSERT INTO users(email, password, name, address, postCodeId, phoneNumber, privileges) VALUES (?, ?, ?, ?, ?, ?, ?)',
            [$user->getEmail(), $password_hash, $user->getName(), $user->getAddress(), $postCode->getId(), $user->getPhoneNumber(), $user->getPrivileges()]
        );
        if ($id !== null) {
            $user->setId($id);

            return $user;
        } else {
            return null;
        }
    }

    public function getUser($user_id): ?User
    {
        /** @var User|null $user */
        $user = $this->query_service->selectRecord
        (
            User::class,
            'SELECT users.id, users.email, users.name, users.address, postcodes.postCode as postCode, postcodes.cityName as cityName, users.phoneNumber FROM users, postcodes WHERE users.id = ? && users.postCodeId = postcodes.id',
            [$user_id]
        );
        return $user;
    }

    public function getUsers(): array
    {
        return $this->query_service->selectRecords
        (
            User::class,
            'SELECT users.id, users.email, users.name, users.address, postcodes.postCode AS postCode, postcodes.cityName AS cityName, users.phoneNumber, users.privileges FROM users, postcodes WHERE users.postCodeId = postcodes.id'
        );
    }

    public function deleteUser(int $user_id): ?int
    {
        return $this->query_service->deleteRecord('users', $user_id);
    }
}
