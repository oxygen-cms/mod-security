<?php

namespace OxygenModule\Security;

use OxygenModule\Security\Entity\LoginLog;
use OxygenModule\Security\Repository\LoginLogRepositoryInterface;
use Oxygen\Auth\Entity\User;

class LoginLogSubscriber {

    /**
     * The login log repository.
     *
     * @var LoginLogRepositoryInterface
     */
    protected $repository;

    /**
     * Constructs the LoginLogSubscriber.
     *
     * @param LoginLogRepositoryInterface $repository
     */

    public function __construct(LoginLogRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    /**
     * Handles a successful login.
     *
     * @param User $user
     * @return void
     */

    public function onLoginSuccessful(User $user) {
        $this->makeEntry($user->getUsername(), LoginLog::LOGIN_SUCCESS);
    }

    /**
     * Handles a failed login.
     *
     * @param string $username
     * @return void
     */

    public function onLoginFailed($username) {
        $this->makeEntry($username, LoginLog::LOGIN_FAILED);
    }

    /**
     * Handles user logout.
     *
     * @param User $user
     * @return void
     */

    public function onLogout(User $user) {
        $this->makeEntry($user->getUsername(), LoginLog::LOGOUT);
    }

    /**
     * Makes a new entry in the Login Log.
     *
     * @param string $username
     * @param string $type
     * @return void
     */
    
    protected function makeEntry($username, $type) {
        $entry = $this->repository->make();
        $entry->setUsername($username)
              ->setIpAddress($_SERVER['REMOTE_ADDR'])
              ->setType($type);
        $this->repository->persist($entry);
    }

}