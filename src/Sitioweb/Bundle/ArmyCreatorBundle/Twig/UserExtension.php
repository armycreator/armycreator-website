<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Twig;

use Sitioweb\Bundle\ArmyCreatorBundle\UserService;

/**
 * Class UserExtension
 * @author Julien Deniau <julien.deniau@gmail.com>
 */
class UserExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    /**
     * userService
     *
     * @var UserService
     */
    private $userService;

    /**
     * __construct
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getGlobals()
    {
        return [
            'armycreator_user' => $this->userService->getArmyCreatorUser(),
        ];
    }
}
