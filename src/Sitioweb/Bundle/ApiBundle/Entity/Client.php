<?php

namespace Sitioweb\Bundle\ApiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\OAuthServerBundle\Entity\Client as BaseClient;

/**
 * Client
 *
 * @uses BaseClient
 * @author Julien Deniau <julien.deniau@mapado.com>
 *
 * @ORM\Entity
 * @ORM\Table(name="oauth_client")
 */
class Client extends BaseClient
{
    /**
     * id
     *
     * @var mixed
     * @access protected
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * name
     *
     * @var mixed
     * @access private
     *
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * Gets the value of name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the value of name
     *
     * @param string $name name
     *
     * @return Client
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}
