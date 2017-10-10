<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Security;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Game;
use Sitioweb\Bundle\ArmyCreatorBundle\Entity\User;
use Sitioweb\Bundle\ArmyCreatorBundle\UserService;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\Role\RoleHierarchyInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class GameVoter
 * @author Julien Deniau <julien.deniau@mapado.com>
 */
class GameVoter extends Voter
{
    /**
     * userService
     *
     * @var UserService
     * @access private
     */
    private $userService;

    /**
     * roleHierarchy
     *
     * @var RoleHierarchyInterface
     * @access private
     */
    private $roleHierarchy;

    /**
     * __construct
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService, RoleHierarchyInterface $roleHierarchy)
    {
        $this->userService = $userService;
        $this->roleHierarchy = $roleHierarchy;
    }

    protected function supports($attribute, $subject)
    {
        if ($subject instanceof Game) {
            return true;
        }

        return false;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        $armyCreatorUser = $this->userService->getArmyCreatorUser();

        if (!$user instanceof UserInterface || !$armyCreatorUser instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        $roles = array_map(
            function ($role) {
                return new Role($role);
            },
            $armyCreatorUser->getRoles()
        );
        $reachableRoles = $this->roleHierarchy->getReachableRoles($roles);

        foreach ($reachableRoles as $reachableRole) {
            if ($reachableRole->getRole() === 'ROLE_CONTRIB') {
                return $attribute === 'VIEW';
            } elseif ($reachableRole->getRole() === 'ROLE_CONTRIB_ALL') {
                switch ($attribute) {
                    case 'VIEW':
                    case 'EDIT':
                    case 'CREATE':
                        return true;
                }
            } elseif ($reachableRole->getRole() === 'ROLE_ADMIN') {
                switch ($attribute) {
                    case 'VIEW':
                    case 'EDIT':
                    case 'CREATE':
                    case 'DELETE':
                        return true;
                }
            }
        }

        return false;
    }
}
