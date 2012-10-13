<?php

namespace Sitioweb\Service\PhpbbFosUserService;

use FOS\UserBundle\Model\UserInterface;

class UserManager extends \FOS\UserBundle\Doctrine\UserManager
{
    /**
     * Creates an empty user instance.
     *
     * @return UserInterface
     */
    public function createUser() {
        ladybug_dump(__FUNCTION__);
        return parent::createUser();
    }

    /**
     * Deletes a user.
     *
     * @param UserInterface $user
     *
     * @return void
     */
    public function deleteUser(UserInterface $user) {
        ladybug_dump(__FUNCTION__);
        return parent::deleteUser($user);
    }

    /**
     * Finds one user by the given criteria.
     *
     * @param array $criteria
     *
     * @return UserInterface
     */
    public function findUserBy(array $criteria) {
        ladybug_dump(__FUNCTION__);
        return parent::findUserBy($criteria);
    }

    /**
     * Find a user by its username.
     *
     * @param string $username
     *
     * @return UserInterface or null if user does not exist
     */
    public function findUserByUsername($username) {
        ladybug_dump(__FUNCTION__);
        return parent::findUserByUsername($username);
    }

    /**
     * Finds a user by its email.
     *
     * @param string $email
     *
     * @return UserInterface or null if user does not exist
     */
    public function findUserByEmail($email) {
        ladybug_dump(__FUNCTION__);
        return parent::findUserByEmail($email);
    }

    /**
     * Finds a user by its username or email.
     *
     * @param string $usernameOrEmail
     *
     * @return UserInterface or null if user does not exist
     */
    public function findUserByUsernameOrEmail($usernameOrEmail) {
        ladybug_dump(__FUNCTION__);
        return parent::findUserByUsernameOrEmail($usernameOrEmail);
    }

    /**
     * Finds a user by its confirmationToken.
     *
     * @param string $token
     *
     * @return UserInterface or null if user does not exist
     */
    public function findUserByConfirmationToken($token) {
        ladybug_dump(__FUNCTION__);
        return parent::findUserByConfirmationToken($token);
    }

    /**
     * Returns a collection with all user instances.
     *
     * @return \Traversable
     */
    public function findUsers() {
        ladybug_dump(__FUNCTION__);
        return parent::findUsers();
    }

    /**
     * Returns the user's fully qualified class name.
     *
     * @return string
     */
    public function getClass() {
        ladybug_dump(__FUNCTION__);
        return parent::getClass();
    }

    /**
     * Reloads a user.
     *
     * @param UserInterface $user
     *
     * @return void
     */
    public function reloadUser(UserInterface $user) {
        ladybug_dump(__FUNCTION__);
        return parent::reloadUser($user);
    }

    /**
     * Updates a user.
     *
     * @param UserInterface $user
     *
     * @return void
     */
    public function updateUser(UserInterface $user) {
        ladybug_dump(__FUNCTION__);
        return parent::updateUser($user);
    }

    /**
     * Updates the canonical username and email fields for a user.
     *
     * @param UserInterface $user
     *
     * @return void
     */
    public function updateCanonicalFields(UserInterface $user) {
        ladybug_dump(__FUNCTION__);
        return parent::updateCanonicalFields($user);
    }

    /**
     * Updates a user password if a plain password is set.
     *
     * @param UserInterface $user
     *
     * @return void
     */
    public function updatePassword(UserInterface $user) {
        ladybug_dump(__FUNCTION__);
        return parent::updatePassword($user);
    } 
}

