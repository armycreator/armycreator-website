<?php

namespace Sitioweb\Bundle\AclBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand as Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

/**
 * GrantContribCommand
 *
 * @uses Command
 * @author Julien Deniau <julien.deniau@mapado.com>
 */
class GrantContribCommand extends Command
{
    /**
     * configure
     *
     * @access protected
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('armycreator:grant')
            ->setDescription('Grant access to contribution')
            ->addArgument(
                'class',
                InputArgument::REQUIRED,
                'Wich class ?'
            )
            ->addArgument(
                'slug',
                InputArgument::REQUIRED,
                'Wich object ?'
            )
            ->addArgument(
                'user',
                InputArgument::REQUIRED,
                'Wich user ?'
            )
            ;
    }


    /**
     * execute
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @access protected
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $class = $input->getArgument('class');
        $slug = $input->getArgument('slug');
        $username = $input->getArgument('user');


        if (!$this->isValidClass($class)) {
            return $this->error('class ' . $class . ' is not valid', $output);
        }

        $repo = $this->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository('SitiowebArmyCreatorBundle:' . $class);

        $object = $this->getObject($repo, $slug);

        if (!$object) {
            return $this->error($class . ' ' . $slug . ' not found', $output);
        }

        $user = $this->getUser($username);

        if (!$user) {
            return $this->error('user ' . $username . ' not found', $output);
        }

        $this->getContainer()
            ->get('oneup_acl.manager')
            ->addObjectPermission($object, MaskBuilder::MASK_EDIT, $user);

        $output->writeln('<info>Done</info>');
    }

    /**
     * getUser
     *
     * @param mixed $username
     * @access private
     * @return void
     */
    private function getUser($username)
    {
        $repo = $this->getContainer()
            ->get('armycreator.repository.user');

        $user = $repo->findOneByUsername($username);

        $user->addRole('ROLE_CONTRIB');

        $repo->save($user);

        $forumRepo = $this->getContainer()->get('armycreator.repository.phpbb_user');
        $forumUser = $forumRepo->find($user->getForumId());

        return $forumUser;
    }


    /**
     * getObject
     *
     * @param mixed $repo
     * @param mixed $slug
     * @access private
     * @return void
     */
    private function getObject($repo, $slug)
    {
        $object = $repo->findOneBy([ 'slug' => $slug ]);

        return $object;
    }


    /**
     * isValidClass
     *
     * @param string $class
     * @access private
     * @return boolean
     */
    private function isValidClass($class)
    {
        $classArray = ['Breed'];
        return (in_array($class, $classArray));
    }


    /**
     * error
     *
     * @param mixed $msg
     * @param mixed $output
     * @access private
     * @return void
     */
    private function error($msg, $output)
    {
        $output->writeln('<error>' . $msg . '</error>');
    }

}
