<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Command;

use Doctrine\ORM\Query\ResultSetMapping;
use Sitioweb\Bundle\ArmyCreatorBundle\Model\PrintableArrayObject;
use Sitioweb\Bundle\ArmyCreatorBundle\Model\RangeStrength;
use Sitioweb\Bundle\ArmyCreatorBundle\Model\Warhammer;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class StuffMigrationCommand extends ContainerAwareCommand
{
    /**
     * farmWeaponIdList
     *
     * @var array
     * @access private
     */
    private $farmWeaponIdList;

    /**
     * configure
     *
     * @access protected
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('armycreator:migrate:stuff')
            ->setDescription('Migrer donnees stuff')
            ->addOption('limit', null, InputOption::VALUE_REQUIRED, 'limite')
            ->addOption('dump-sql', null, InputOption::VALUE_NONE, 'Ne pas executer les requetes')
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
        $dumpSql = $input->getOption('dump-sql');
        $limit =  $input->getOption('limit');

        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $this->treatEquipement($output, $limit, $dumpSql);
        $this->treatWeapon($output, $limit, $dumpSql);
    }

    /**
     * treatWeapon
     *
     * @param mixed $output
     * @param mixed $limit
     * @param bool $dry
     * @access private
     * @return void
     */
    private function treatWeapon($output, $limit, $dry = false)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $repo = $em->getRepository('SitiowebArmyCreatorBundle:Weapon');

        $connection = $em->getConnection();

        $weaponList = $connection->query("
            SELECT id, type, range_, strenght, armorPenetration, rule
            FROM Weapon " .
            ((int)$limit ? "LIMIT " . (int) $limit : "")
        );


        while ($row = $weaponList->fetch()) {
            $output->writeln($row['id'] . ': ' . $row['type'] . '-' . $row['range_']);
            $weapon = $repo->find($row['id']);

            $desc = $this->getWeaponDescription($row);
            $weapon->setDescription($desc);

            if (!$dry) {
                $em->persist($weapon);
            }
        }

        if (!$dry) {
            $em->flush();
        }
    }

    /**
     * treatEquipement
     *
     * @param mixed $output
     * @param mixed $limit
     * @param bool $dry
     * @access private
     * @return void
     */
    private function treatEquipement($output, $limit, $dry = false)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $repo = $em->getRepository('SitiowebArmyCreatorBundle:Equipement');

        $connection = $em->getConnection();


        $equipementList = $connection->query("
            SELECT id, description
            FROM Equipement " .
            ((int)$limit ? "LIMIT " . (int) $limit : "")
        );

        while ($row = $equipementList->fetch()) {
            $output->writeln($row['id'] . ': ' . $row['description']);
            $equipement = $repo->find($row['id']);
            $equipement->setDescription($row['description'] ?: null);
            if (!$dry) {
                $em->persist($equipement);
            }
        }

        if (!$dry) {
            $em->flush();
        }
    }

    /**
     * getFarmWeaponId
     *
     * @access private
     * @return void
     */
    private function getFarmWeaponId()
    {
        if (!isset($this->farmWeaponIdList)) {
            $em = $this->getContainer()->get('doctrine.orm.entity_manager');
            $repo = $em->getRepository('SitiowebArmyCreatorBundle:Breed');

            $dql = "SELECT s
                FROM SitiowebArmyCreatorBundle:Stuff s
                JOIN s.breed b
                JOIN b.game g
                WHERE g.code = 'FArm'
                AND s INSTANCE OF SitiowebArmyCreatorBundle:Weapon
                ORDER BY b.id, s.name
            ";

            $farmWeapon = $em->createQuery($dql)
                ->getResult();

            $idList = [];
            foreach ($farmWeapon as $tmp) {
                $idList[] = $tmp->getId();
            }

            $this->farmWeaponIdList = $idList;
        }

        return $this->farmWeaponIdList;
    }

    /**
     * getWeaponDescription
     *
     * @param mixed $row
     * @access private
     * @return void
     */
    private function getWeaponDescription($row)
    {
        $farmWeaponId = $this->getFarmWeaponId();

        if (in_array($row['id'], $farmWeaponId)) {
            //farm
            $desc = new PrintableArrayObject;

            $rangeList = array_map('trim', explode('/', $row['range_']));
            $strengthList = array_map('trim', explode('/', $row['strenght']));

            foreach ($rangeList as $range) {
                $strength = current($strengthList);
                next($strengthList);
                $rs = new RangeStrength;
                $rs->setStrength((int) $strength)
                    ->setRange($range);

                $desc[] = $rs;
            }
        } else {
            //warhammer
            $desc = new Warhammer\Weapon;
            $desc->setType($row['type'])
                ->setRange($row['range_'])
                ->setStrenght($row['strenght'])
                ->setArmorPenetration($row['armorPenetration'])
                ->setRule($row['rule']);
        }

        return $desc;
    }
}
