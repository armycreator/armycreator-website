<?php

namespace Sitioweb\Bundle\ArmyCreatorImportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{

    public function __construct()
    {
        ini_set('memory_limit', '4096M');
    }

    private $em;
    private $emImport;
    private $w40k;

    /**
     * @Route("/", name="import_index")
     * @Template()
     */
    public function indexAction()
    {
        $importList = array(
            'import_game' => 'SitiowebArmyCreatorBundle:Game',
            'import_breed' => 'SitiowebArmyCreatorBundle:Breed',
            'import_unit_type' => 'SitiowebArmyCreatorBundle:UnitType',
            'import_unit_group' => 'SitiowebArmyCreatorBundle:UnitGroup',
            'import_unit' => 'SitiowebArmyCreatorBundle:Unit',
            'import_unit_has_unit_group' => 'SitiowebArmyCreatorBundle:UnitHasUnitGroup',
            'import_unit_has_unit' => 'SitiowebArmyCreatorBundle:UnitHasUnitGroup',
            'link_missing_unit' => 'SitiowebArmyCreatorBundle:UnitHasUnitGroup',
            'import_equipement' => 'SitiowebArmyCreatorBundle:Equipement',
            'import_weapon' => 'SitiowebArmyCreatorBundle:Weapon',
            'import_unit_stuff' => 'SitiowebArmyCreatorBundle:UnitStuff',
            'import_user' => 'SitiowebArmyCreatorBundle:User',
            'import_user_preference' => 'SitiowebArmyCreatorBundle:UserPreference',
            'import_user_has_unit' => 'SitiowebArmyCreatorBundle:UserHasUnit',
            'import_army_group' => 'SitiowebArmyCreatorBundle:ArmyGroup',
            'import_army' => 'SitiowebArmyCreatorBundle:Army',
            'import_squad' => 'SitiowebArmyCreatorBundle:Squad',
            'import_squad_line' => 'SitiowebArmyCreatorBundle:SquadLine',
            'import_squad_line_equipement' => 'SitiowebArmyCreatorBundle:SquadLineStuff',
            'import_squad_line_weapon' => 'SitiowebArmyCreatorBundle:SquadLineStuff',
        );

        $em = $this->get('doctrine')->getManager();

        $numberedImportList = array();
        foreach ($importList as $route => $import) {
            $query = $em->createQuery('SELECT COUNT(u.id) FROM ' . $import . ' u');
            $numberedImportList[] = array(
                'route' => $route,
                'name' => $import,
                'count' => $query->getSingleScalarResult()
            );
        }

        return array('importList' => $numberedImportList);
    }

    private function getDbName()
    {
        return $this->container->getParameter('database_name');

    }

    /**
     * configure
     *
     * @access public
     * @return void
     */
    public function configure()
    {
        // conf
        $this->em = $this->get('doctrine')->getManager();
        $this->emImport = $this->get('doctrine')->getManager('import')->getConnection();
        $this->w40k = $this->em->getRepository('SitiowebArmyCreatorBundle:Game')->findOneByCode('W40K');

    }

    /**
     * clearEntityList
     *
     * @param string $entityClass
     * @access private
     * @return void
     */
    private function clearEntityList($entityClass)
    {
        // delete
        switch ($entityClass) {
            case 'SitiowebArmyCreatorBundle:CollectionBreed' :
                $query = $this->em->query("
                    DELETE
                    FROM CollectionBreed
                ");
                $query->execute();
                break;
            case 'SitiowebArmyCreatorBundle:Unit' :
                $query = $this->em->createQuery("
                    DELETE
                    FROM " . $entityClass .  " e
                    WHERE e.parent IS NOT NULL
                ");
                $query->execute();

                $query2 = $this->em->createQuery("
                    DELETE
                    FROM  " . $entityClass);
                $query2->execute();
                break;
            default:
                $query = $this->em->createQuery("DELETE FROM " . $entityClass);
                $query->execute();
                break;
        }


        /*
        $entityList = $this->em->getRepository($entityClass)->findAll();

        foreach ($entityList as $entity) {
            $this->em->remove($entity);
        }
        $this->em->flush();
        */
    }

    /**
     * clearEntityListAction
     * @Route("/clear/{entityClass}", name="clear_entity_class")
     *
     * @param mixed $entityClass
     * @access public
     * @return void
     */
    public function clearEntityListAction($entityClass) {
        $this->configure();
        $this->clearEntityList($entityClass);
        $this->get('session')->getFlashBag()->add('notice', $entityClass . ' cleared');
        return $this->redirect($this->generateUrl('import_index'));
    }

    /**
     * importGame
     * @Route("/game", name="import_game")
     *
     * @access public
     * @return void
     */
    public function importGame()
    {
        $this->configure();
        if (!$this->w40k) {
            $this->w40k = new \Sitioweb\Bundle\ArmyCreatorBundle\Entity\Game();
            $this->w40k->setName('Warhammer 40.000');
            $this->w40k->setCode('W40K');

            $this->em->persist($this->w40k);
            $this->em->flush();
        }

        return $this->redirect($this->generateUrl('import_index'));
    }

    /**
     * importBreed
     * @Route("/breed", name="import_breed")
     *
     * @access public
     * @return void
     */
    public function importBreed()
    {
        // conf
        $this->configure();
        $entityClass = 'SitiowebArmyCreatorBundle:Breed';
        $this->clearEntityList($entityClass);

        // inserting
        $importBreedList = $this->emImport->query("SELECT * FROM race ORDER BY id DESC");
        while ($row = $importBreedList->fetch()) {
            $breed = new \Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed();
            $breed->setId((int) $row['id']);
            $breed->setName(utf8_encode($row['nom']));
            $breed->setImage(utf8_encode($row['imageName']));
            if ($row['new_version_id'] > 0) {
                $nv = $this->em->getRepository('SitiowebArmyCreatorBundle:Breed')->find((int) $row['new_version_id']);
                $breed->setNewVersion($nv);
            }
            $breed->setAvailable((int) $row['disponible']);
            $breed->setGame($this->w40k);

            $this->em->persist($breed);
            $this->em->getClassMetaData(get_class($breed))->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        }
        $this->em->flush();

        $this->get('session')->getFlashBag()->add('notice', 'Breed imported');
        return $this->redirect($this->generateUrl('import_index'));
    }

    /**
     * importUnitTypeAction
     * @Route("/unit_type", name="import_unit_type")
     *
     * @access public
     * @return void
     */
    public function importUnitTypeAction ()
    {
        // conf
        $this->configure();
        $entityClass = 'SitiowebArmyCreatorBundle:UnitType';
        $this->clearEntityList($entityClass);

        // inserting
        $importList = $this->emImport->query("SELECT * FROM type_unite ORDER BY id");
        $breedList = $this->em->getRepository('SitiowebArmyCreatorBundle:Breed')->findAll();

        while ($row = $importList->fetch()) {
            foreach ($breedList as $breed) {
                $entity = new \Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitType();
                $entity->setImportedId((int) $row['id']);
                $entity->setPosition((int) $row['id']);
                $entity->setName(utf8_encode($row['nom']));
                $entity->setBreed($breed);

                $this->em->persist($entity);
                //$this->em->getClassMetaData($entityClass)->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            }
        }
        $this->em->flush();

        $this->get('session')->getFlashBag()->add('notice', $entityClass . ' imported');
        return $this->redirect($this->generateUrl('import_index'));
    }

    /**
     *
     * @Route("/unit_group", name="import_unit_group")
     *
     * @access public
     * @return void
     */
    public function importUnitGroupAction ()
    {
        // conf
        $this->configure();
        $entityClass = 'SitiowebArmyCreatorBundle:UnitGroup';
        $this->clearEntityList($entityClass);

        // inserting
        $importList = $this->emImport->query("SELECT * FROM regroupement ORDER BY id");
        //$breedList = $this->em->getRepository('SitiowebArmyCreatorBundle:Breed')->findAll();

        while ($row = $importList->fetch()) {
            $entity = new \Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitGroup();
            $entity->setImportedId((int) $row['id']);
            $entity->setImportedType('unit_group');
            $entity->setName(utf8_encode($row['nom']));
            $entity->setPoints(0);

            $breed = $this->em->getRepository('SitiowebArmyCreatorBundle:Breed')->find($row['race_id']);
            $entity->setBreed($breed);

            $unitType = $this->em->getRepository('SitiowebArmyCreatorBundle:UnitType')->findOneBy(array('breed' => $breed, 'importedId' => $row['type_unite_id']));
            $entity->setUnitType($unitType);

            $this->em->persist($entity);
            //$this->em->getClassMetaData($entityClass)->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        }
        $this->em->flush();


        // inserting
        $importList = $this->emImport->query("SELECT * FROM unite WHERE viewInList = '1' ORDER BY id");
        //$breedList = $this->em->getRepository('SitiowebArmyCreatorBundle:Breed')->findAll();

        while ($row = $importList->fetch()) {
            $entity = new \Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitGroup();
            $entity->setImportedId((int) $row['id']);
            $entity->setImportedType('unit');
            $entity->setName(utf8_encode($row['nom']));
            $entity->setPoints(0);

            $breed = $this->em->getRepository('SitiowebArmyCreatorBundle:Breed')->find($row['race_id']);
            $entity->setBreed($breed);

            $unitType = $this->em->getRepository('SitiowebArmyCreatorBundle:UnitType')->findOneBy(array('breed' => $breed, 'importedId' => $row['type_unite_id']));
            $entity->setUnitType($unitType);

            $this->em->persist($entity);
            //$this->em->getClassMetaData($entityClass)->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        }
        $this->em->flush();

        $this->get('session')->getFlashBag()->add('notice', $entityClass . ' imported');
        return $this->redirect($this->generateUrl('import_index'));
    }

    /**
     *
     * @Route("/unit/{start}", name="import_unit", defaults={"start" = 0})
     *
     * @access public
     * @return void
     */
    public function importUnitAction ($start)
    {
        //mb_internal_encoding('latin1');
        // conf
        $this->configure();
        $entityClass = 'SitiowebArmyCreatorBundle:Unit';
        if ($start == 0) {
            $this->clearEntityList($entityClass);
        }

        // inserting
        $limit = 300;
        $importList = $this->emImport->query("
            SELECT *
            FROM unite
            ORDER BY parent_id, id
            LIMIT " . (int) $start . ", " . $limit . "
        ");

        if ($importList->rowCount() >= $limit) {
            $continue = $this->generateUrl('import_unit', array('start' => (int) $start + $limit));
        } else {
            $continue = null;
        }

        while ($row = $importList->fetch()) {

            $entity = new \Sitioweb\Bundle\ArmyCreatorBundle\Entity\Unit();
            $entity->setImportedId((int) $row['id']);
            $entity->setImportedType('unit');
            $entity->setName(utf8_encode($row['nom']));
            $entity->setPoints((int) $row['pts_unite']);

           $breed = $this->em->getRepository('SitiowebArmyCreatorBundle:Breed')->find($row['race_id']);
           $entity->setBreed($breed);

            $unitType = $this->em->getRepository('SitiowebArmyCreatorBundle:UnitType')->findOneBy(array('breed' => $breed, 'importedId' => $row['type_unite_id']));
            $entity->setUnitType($unitType);

            $entity->setCanModifyNumber((int) $row['canModifyNumber']);

            if ($row['parent_id']) {
                $parent = $this->em->getRepository('SitiowebArmyCreatorBundle:Unit')->findOneByImportedId($row['parent_id']);

                $entity->setParent($parent);
            }

            $this->em->persist($entity);
            //$this->em->getClassMetaData($entityClass)->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        }
        $this->em->flush();

        $this->get('session')->getFlashBag()->add('notice', $entityClass . ' imported : ' . $start);

        if ($continue) {
            return $this->redirect($continue);
        } else {
            return $this->redirect($this->generateUrl('import_index'));
        }
    }

    /**
     *
     * @Route("/unit_has_unit_group/{start}", name="import_unit_has_unit_group", defaults={"start" = 0})
     *
     * @access public
     * @return void
     */
    public function importUnitHasUniteGroupAction ($start)
    {
        // conf
        $this->configure();
        $entityClass = 'SitiowebArmyCreatorBundle:UnitHasUnitGroup';
        if ($start == 0) {
            $this->clearEntityList($entityClass);
        }

        // inserting
        $limit = 300;
        $importList = $this->emImport->query("
            SELECT *
            FROM regroupement_unite
            ORDER BY id
            LIMIT " . (int) $start . ", " . $limit . "
        ");

        if ($importList->rowCount() >= $limit) {
            $continue = $this->generateUrl('import_unit_has_unit_group', array('start' => (int) $start + $limit));
        } else {
            $continue = null;
        }

        while ($row = $importList->fetch()) {

            $entity = new \Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitHasUnitGroup();
            $entity->setImportedId((int) $row['id']);
            //$entity->setName(utf8_encode($row['nom']));
            $unit = $this->em->getRepository('SitiowebArmyCreatorBundle:Unit')->findOneByImportedId($row['unite_id']);
            // bug unit
            if (!$unit) {
                continue;
            }
            $entity->setUnit($unit);
            $group = $this->em->getRepository('SitiowebArmyCreatorBundle:UnitGroup')->findOneBy(array(
                'importedId' => $row['regroupement_id'],
                'importedType' => 'unit_group',
            ));
            $entity->setGroup($group);

            $entity->setCanChooseNumber((int) $row['canChooseNumber']);
            $entity->setMainUnit((int) $row['unite_principale']);
            $entity->setUnitNumber((int) $row['nb_unite']);

            $this->em->persist($entity);
            //$this->em->getClassMetaData($entityClass)->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        }
        $this->em->flush();

        $this->get('session')->getFlashBag()->add('notice', $entityClass . ' imported : ' . $start);

        if ($continue) {
            return $this->redirect($continue);
        } else {
            return $this->redirect($this->generateUrl('import_index'));
        }
    }

    /**
     *
     * @Route("/unit_has_unit/{start}", name="import_unit_has_unit", defaults={"start" = 0})
     *
     * @access public
     * @return void
     */
    public function importUnitHasUnitAction ($start)
    {
        // conf
        $this->configure();
        $entityClass = 'SitiowebArmyCreatorBundle:UnitHasUnitGroup';

        // inserting
        $limit = 300;
        $importList = $this->emImport->query("
            SELECT *
            FROM unite
            WHERE viewInList = '1'
            ORDER BY id
            LIMIT " . (int) $start . ", " . $limit . "
        ");

        if ($importList->rowCount() >= $limit) {
            $continue = $this->generateUrl('import_unit_has_unit', array('start' => (int) $start + $limit));
        } else {
            $continue = null;
        }
        //$breedList = $this->em->getRepository('SitiowebArmyCreatorBundle:Breed')->findAll();

        while ($row = $importList->fetch()) {

            $entity = new \Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitHasUnitGroup();
            $entity->setImportedId(0);
            //$entity->setName(utf8_encode($row['nom']));
            $unit = $this->em->getRepository('SitiowebArmyCreatorBundle:Unit')->findOneByImportedId($row['id']);
            $entity->setUnit($unit);
            $group = $this->em->getRepository('SitiowebArmyCreatorBundle:UnitGroup')->findOneBy(array(
                'importedId' => $row['id'],
                'importedType' => 'unit'
            ));
            $entity->setGroup($group);

            $entity->setCanChooseNumber(true);
            $entity->setMainUnit(true);
            $entity->setUnitNumber(1);

            $this->em->persist($entity);
            //$this->em->getClassMetaData($entityClass)->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        }

        $this->em->flush();



        $this->get('session')->getFlashBag()->add('notice', $entityClass . ' imported : ' . $start);

        if ($continue) {
            return $this->redirect($continue);
        } else {
            return $this->redirect($this->generateUrl('import_index'));
        }
    }


    /**
     * linkMissingUnits
     *
     * @access public
     * @return void
     * @Route("link_missing_unit", name="link_missing_unit")
     */
    public function linkMissingUnits()
    {
        $this->configure();
        $entityClass = 'SitiowebArmyCreatorBundle:UnitHasUnitGroup';

        $importList = $this->em->getConnection()->query("
            SELECT unit.id AS id, oldunit.parent_id AS parent_id
            FROM  " . $this->getDbName() . ".`AbstractUnit` unit
            JOIN wkarmycr_copy.unite oldunit ON oldunit.id = unit.importedId
            LEFT JOIN  " . $this->getDbName() . ".`UnitHasUnitGroup` uhug ON unit.id = uhug.unit_id
            WHERE  `discriminator` =  'unit'
            AND uhug.id IS NULL
            AND oldunit.parent_id IS NOT NULL
            ORDER BY unit.breed_id DESC
        ");

        while ($row = $importList->fetch()) {
            $unit = $this->em->getRepository('SitiowebArmyCreatorBundle:Unit')->find($row['id']);
            $parentUnit = $this->em->getRepository('SitiowebArmyCreatorBundle:Unit')->findOneByImportedId($row['parent_id']);
            $unitHasGroupList = $this->em->getRepository('SitiowebArmyCreatorBundle:UnitHasUnitGroup')
                                ->findBy(array(
                                    'unit' => $parentUnit
                                ));

            foreach ($unitHasGroupList as $unitHasGroup) {
                $entity = new \Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitHasUnitGroup();
                $entity->setUnit($unit)
                    ->setGroup($unitHasGroup->getGroup());
                $this->em->persist($entity);
            }
        }
        $this->em->flush();

        $this->get('session')->getFlashBag()->add('notice', $entityClass . ' imported missing');

        return $this->redirect($this->generateUrl('import_index'));
    }



    /**
     *
     * @Route("/equipement/{start}", name="import_equipement", defaults={"start" = 0})
     *
     * @access public
     * @return void
     */
    public function importEquipementAction ($start)
    {
        // conf
        $this->configure();
        $entityClass = 'SitiowebArmyCreatorBundle:Equipement';
        if ($start == 0) {
            $this->clearEntityList($entityClass);
        }
        $breedList = $this->em->getRepository('SitiowebArmyCreatorBundle:Breed')->findAll();

        foreach ($breedList as $breed) {
            $importList = $this->emImport->query("
                SELECT DISTINCT e.*
                FROM equipement e
                    JOIN unite_has_equipement uhe ON uhe.equipement_id = e.id
                    JOIN unite u ON uhe.unite_id = u.id
                WHERE u.race_id = " . (int) $breed->getId());

            while ($row = $importList->fetch()) {
                $entity = new \Sitioweb\Bundle\ArmyCreatorBundle\Entity\Equipement();
                $entity->setImportedId((int) $row['id']);
                $entity->setName(utf8_encode($row['nom']));
                $entity->setDescription(utf8_encode($row['carac']));
                $entity->setBreed($breed);

                $this->em->persist($entity);
                //$this->em->getClassMetaData($entityClass)->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            }
            $this->em->flush();
        }

        $this->get('session')->getFlashBag()->add('notice', $entityClass . ' imported : ' . $start);

        if ($continue) {
            return $this->redirect($continue);
        } else {
            return $this->redirect($this->generateUrl('import_index'));
        }
    }

    /**
     *
     * @Route("/weapon/{start}", name="import_weapon", defaults={"start" = 0})
     *
     * @access public
     * @return void
     */
    public function importWeaponAction ($start)
    {
        // conf
        $this->configure();
        $entityClass = 'SitiowebArmyCreatorBundle:Weapon';
        if ($start == 0) {
            $this->clearEntityList($entityClass);
        }
        $breedList = $this->em->getRepository('SitiowebArmyCreatorBundle:Breed')->findAll();

        foreach ($breedList as $breed) {
            $importList = $this->emImport->query("
                SELECT DISTINCT e.*
                FROM arme e
                    JOIN unite_has_equipement uhe ON uhe.arme_id = e.id
                    JOIN unite u ON uhe.unite_id = u.id
                WHERE u.race_id = " . (int) $breed->getId());

            while ($row = $importList->fetch()) {
                $entity = new \Sitioweb\Bundle\ArmyCreatorBundle\Entity\Weapon();
                $entity->setImportedId((int) $row['id']);
                $entity->setName(utf8_encode($row['nom']));
                $entity->setType(utf8_decode($row['type_arme']));
                $entity->setRange(utf8_decode($row['portee']));
                $entity->setStrenght(utf8_decode($row['F']));
                $entity->setArmorPenetration(utf8_decode($row['PA']));
                $entity->setBreed($breed);

                $this->em->persist($entity);
                //$this->em->getClassMetaData($entityClass)->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            }
            $this->em->flush();
        }

        $this->get('session')->getFlashBag()->add('notice', $entityClass . ' imported : ' . $start);

        if ($continue) {
            return $this->redirect($continue);
        } else {
            return $this->redirect($this->generateUrl('import_index'));
        }
    }

    /**
     *
     * @Route("/unit_stuff/{start}", name="import_unit_stuff", defaults={"start" = 0})
     *
     * @access public
     * @return void
     */
    public function importUnitStuffAction ($start)
    {
        // conf
        $this->configure();
        $entityClass = 'SitiowebArmyCreatorBundle:UnitStuff';
        if ($start == 0) {
            $this->clearEntityList($entityClass);
        }

        // inserting
        $limit = 300;
        $importList = $this->emImport->query("
            SELECT *
            FROM unite_has_equipement
            ORDER BY id
            LIMIT " . (int) $start . ", " . $limit . "
        ");

        if ($importList->rowCount() >= $limit) {
            $continue = $this->generateUrl('import_unit_stuff', array('start' => (int) $start + $limit));
        } else {
            $continue = null;
        }

        while ($row = $importList->fetch()) {
            $unit = $this->em->getRepository('SitiowebArmyCreatorBundle:Unit')->findOneByImportedId($row['unite_id']);
            if ($unit) {
                $entity = new \Sitioweb\Bundle\ArmyCreatorBundle\Entity\UnitStuff();
                //$entity->setImportedId((int) $row['id']);
                $entity->setPoints((int) $row['pts_equipement']);
                $entity->setAuto(!empty($row['equip_auto']));
                $entity->setVisible((int) $row['visible']);

                $entity->setUnit($unit);

                $tmpBreed = $unit->getBreed();
                if ($row['equipement_id'] > 0) {
                    $stuff = $this->em->getRepository('SitiowebArmyCreatorBundle:Equipement')->findOneBy(array('importedId' => $row['equipement_id'], 'breed' => $tmpBreed));
                } else {
                    $stuff = $this->em->getRepository('SitiowebArmyCreatorBundle:Weapon')->findOneBy(array('importedId' => $row['arme_id'], 'breed' => $tmpBreed));
                }
                $entity->setStuff($stuff);

                $this->em->persist($entity);
                //$this->em->getClassMetaData($entityClass)->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            }
        }
        $this->em->flush();

        $this->get('session')->getFlashBag()->add('notice', $entityClass . ' imported : ' . $start);

        if ($continue) {
            return $this->redirect($continue);
        } else {
            return $this->redirect($this->generateUrl('import_index'));
        }
    }

    /**
     *
     * @Route("/user/{start}", name="import_user", defaults={"start" = 0})
     *
     * @access public
     * @return void
     */
    public function importUserAction ($start)
    {

        // conf
        $this->configure();
        $entityClass = 'SitiowebArmyCreatorBundle:User';
        if ($start == 0) {
            $this->clearEntityList($entityClass);
        }

        // inserting
        $limit = 300;
        $importList = $this->emImport->query("
            SELECT *
            FROM phpbb_users
            WHERE user_id >= 53 OR user_id = 2
            ORDER BY user_id
            LIMIT " . (int) $start . ", " . $limit . "
        ");

        if ($importList->rowCount() >= $limit) {
            $continue = $this->generateUrl('import_user', array('start' => (int) $start + $limit));
        } else {
            $continue = null;
        }

        while ($row = $importList->fetch()) {
            if ($row['user_id'] == 2) {
                $entity = $this->em->getRepository('SitiowebArmyCreatorBundle:User')->findOneByForumId((int) $row['user_id']);
                if (!$entity) {
                    $entity = new \Sitioweb\Bundle\ArmyCreatorBundle\Entity\User();
                }
            } else {
                $entity = new \Sitioweb\Bundle\ArmyCreatorBundle\Entity\User();
            }
            //$entity->setImportedId((int) $row['id']);
            $entity->setForumId($row['user_id']);
            $username = utf8_decode(mb_convert_encoding ( $row['username'] , 'utf-8' , 'iso-8859-1'));
            //ladybug_dump($row['user_id'], $username);

            //$entity->setUsername($username);
            $entity->setUsername($row['user_id']);
            $entity->setEmail(utf8_encode($row['user_email']));
            //$entity->setPlainPassword($row['user_password']);
            $entity->setPassword(utf8_encode($row['user_password']));
            //$lastLogin = new \DateTime();
            //$lastLogin->setTimestamp($row['user_lastvisit']);
            //$entity->setLastLogin($lastLogin);
            $entity->setEnabled(true);
            $entity->setLocked(false);

            // breed collection
            $collectionList = $this->emImport->query("
                SELECT *
                FROM wac_collection_race
                WHERE id_joueur = '" . (int) $row['user_id'] . "'
            ");

            if ($collectionList->rowCount() >= 0) {
                while($row = $collectionList->fetch()) {
                    $tmpBreed = $this->em->getRepository('SitiowebArmyCreatorBundle:Breed')->find((int) $row['id_race']);
                    $entity->addCollectionList($tmpBreed);
                }
            }

            $this->em->persist($entity);
            //$this->em->getClassMetaData($entityClass)->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        }
        $this->em->flush();

        $this->get('session')->getFlashBag()->add('notice', $entityClass . ' imported : ' . $start);

        if ($continue) {
            return $this->redirect($continue);
        } else {
            return $this->redirect($this->generateUrl('import_index'));
        }
    }

    /**
     *
     * @Route("/user_preference/{start}", name="import_user_preference", defaults={"start" = 0})
     *
     * @access public
     * @return void
     */
    public function importUserPreferenceAction ($start)
    {

        // conf
        $this->configure();
        $entityClass = 'SitiowebArmyCreatorBundle:UserPreference';
        if ($start == 0) {
            $this->clearEntityList($entityClass);
        }

        // inserting
        $limit = 500;
        $importList = $this->emImport->query("
            SELECT *
            FROM wac_user_preferences
            ORDER BY joueur_id
            LIMIT " . (int) $start . ", " . $limit . "
        ");

        if ($importList->rowCount() >= $limit) {
            $continue = $this->generateUrl('import_user_preference', array('start' => (int) $start + $limit));
        } else {
            $continue = null;
        }

        while ($row = $importList->fetch()) {
            $entity = new \Sitioweb\Bundle\ArmyCreatorBundle\Entity\UserPreference();
            //$entity->setImportedId((int) $row['id']);
            $user = $this->em->getRepository('SitiowebArmyCreatorBundle:User')->findOneByForumId($row['joueur_id']);
            $entity->setUser($user);

            if ($row['prefered_race_id'] > 0) {
                $breed = $this->em->getRepository('SitiowebArmyCreatorBundle:Breed')->find($row['prefered_race_id']);
                if ($breed) {
                    $entity->setBreed($breed);
                }
            }

            $entity->setShowDefaultStuff((int) $row['showDefaultEquipement']);
            $entity->setShowStuffDescription((int) $row['showArmeDescription']);
            $entity->setShowUnitPoints((int) $row['showUnitePoints']);
            $entity->setShowStuffPoints((int) $row['showEquipementPoints']);
            $entity->setSeparator(utf8_encode($row['separateur']));
            $entity->setColorSquadType($this->colorHex($row['colorTypeEscouade']));
            $entity->setColorSquad($this->colorHex($row['colorEscouade']));
            $entity->setColorSquadDetail($this->colorHex($row['colorDetailEscouade']));
            $entity->setShowNbIfAlone((int) $row['showAloneBeforeUnite']);
            $entity->setShowUnitCarac((int) $row['showCaracUnite']);
            $entity->setShowPersonnalName((int) $row['showNomPerso']);

            $this->em->persist($entity);
            //$this->em->getClassMetaData($entityClass)->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        }
        $this->em->flush();

        $this->get('session')->getFlashBag()->add('notice', $entityClass . ' imported : ' . $start);

        if ($continue) {
            return $this->redirect($continue);
        } else {
            return $this->redirect($this->generateUrl('import_index'));
        }
    }

    /**
     * colorHex
     *
     * @param mixed $color
     * @access private
     * @return void
     */
    private function colorHex($color)
    {
        if (substr($color, 0, 1) == '#') {
            return $color;
        }

        switch ($color) {
            case 'blue':
                return '#0000FF';
            case 'red':
                return '#ff0000';
            case 'orange':
                return '#ffa500';
            case 'green':
                return '#00ff00';
            case 'black':
                return '#000000';
            case 'purple':
                return '#800080';
            case 'darkgreen':
                return '#006400';
            case   'brown':
                return '#a52a2a';
            default:
                return '#000000';
        }
    }


    /**
     * importArmyGroupAction
     * @Route("/army_group/{start}", name="import_army_group", defaults={"start" = 0})
     *
     * @access public
     * @return void
     */
    public function importArmyGroupAction ($start)
    {
        // conf
        $this->configure();
        $entityClass = 'SitiowebArmyCreatorBundle:ArmyGroup';
        if ($start == 0) {
            $this->clearEntityList($entityClass);
        }

        // inserting
        $limit = 300;
        $importList = $this->emImport->query("
            SELECT *
            FROM wac_armee_groupe
            ORDER BY id
            LIMIT " . (int) $start . ", " . $limit . "
        ");

        if ($importList->rowCount() >= $limit) {
            $continue = $this->generateUrl('import_army_group', array('start' => (int) $start + $limit));
        } else {
            $continue = null;
        }

        while ($row = $importList->fetch()) {
            $entity = new \Sitioweb\Bundle\ArmyCreatorBundle\Entity\ArmyGroup();
            $entity->setId((int) $row['id']);
            $name = ($row['type_groupe'] == 'T' ? 'Type' : 'Brouillon');
            $entity->setName($name . ' | ' . utf8_encode($row['name']));

            $user = $this->em->getRepository('SitiowebArmyCreatorBundle:User')->findOneByForumId($row['joueur_id']);
            $entity->setUser($user);

            $this->em->persist($entity);
        }
        $this->em->getClassMetaData($entityClass)->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        $this->em->flush();

        $this->get('session')->getFlashBag()->add('notice', $entityClass . ' imported');
        if ($continue) {
            return $this->redirect($continue);
        } else {
            return $this->redirect($this->generateUrl('import_index'));
        }
    }

    /**
     * importArmyAction
     * @Route("/army/{start}", name="import_army", defaults={"start" = 0})
     *
     * @access public
     * @return void
     */
    public function importArmyAction ($start)
    {
        $minId = 0;

        // conf
        $this->configure();
        $entityClass = 'SitiowebArmyCreatorBundle:Army';
        if ($start == 0 && $minId == 0) {
            $this->clearEntityList($entityClass);
        }
        $this->em->getClassMetaData($entityClass)->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

        $query = $this->em->getConnection()->executeUpdate("
             INSERT INTO " . $this->getDbName() . ".Army (
                id, breed_id, user_id, `status`, name, slug, description, wantedPoints,
                    points, isShared, createDate, updateDate, armyGroup_id
                     )
             SELECT wa.id, wa.race_id, u.id, IF(wa.type_armee = 'T','finish','draft'), wa.nom, CONCAT('army-', wa.id), wa.description,
                wa.nbPointsSouhaites, wa.nbPoints, IF(wa.isShared='1',1,0), null, null, wa.groupe_id
                FROM wkarmycr_copy.armee wa
                JOIN " . $this->getDbName() . ".Users u ON u.forumId = wa.joueur_id
                ");

        /*
        $armyList = $this->em->getRepository('SitiowebArmyCreatorBundle:Army')->findAll();
        foreach ($armyList as $army) {
            $army->setSlug(null);
        }
        $this->em->flush();
        */

        return $this->redirect($this->generateUrl('import_index'));

        // inserting
        /*
        $limit = 5000;
        $importList = $this->emImport->query("
            SELECT *
            FROM armee
            WHERE id > " . (int) $minId . "
            ORDER BY id
            LIMIT " . (int) $start . ", " . $limit . "
        ");

        if ($importList->rowCount() >= $limit) {
            $continue = $this->generateUrl('import_army', array('start' => (int) $start + $limit, 'minId' => (int) $minId));
        } else {
            $continue = null;
        }

        $cpt = 0;
        while ($row = $importList->fetch()) {
            $user = $this->em->getRepository('SitiowebArmyCreatorBundle:User')->findOneByForumId($row['joueur_id']);
            $entity = new \Sitioweb\Bundle\ArmyCreatorBundle\Entity\Army();
            $entity->setId((int) $row['id']);
            $entity->setName(!empty($row['nom']) ? utf8_encode($row['nom']) : 'Sans nom');
            $entity->setStatus($row['type_armee'] == 'T' ? 'finish' : 'draft');
            $entity->setDescription(utf8_encode($row['description']));
            $entity->setWantedPoints((int) $row['nbPointsSouhaites']);
            $entity->setPoints((int) $row['nbPoints']);
            $entity->setIsShared((int) $row['isShared']);

            $breed = $this->em->getRepository('SitiowebArmyCreatorBundle:Breed')->find($row['race_id']);
            $entity->setBreed($breed);

            $entity->setUser($user);

            if ($row['groupe_id'] > 0) {
                $armyGroup = $this->em->getRepository('SitiowebArmyCreatorBundle:ArmyGroup')->find($row['groupe_id']);
                $entity->setArmyGroup($armyGroup);
            }

            $this->em->persist($entity);
            if ($cpt >= 100) {
                $cpt = 0;
                set_time_limit(30);
                $this->em->flush();
                $this->em->clear();
            }
            $cpt++;

        }
        $this->em->flush();

        $this->get('session')->getFlashBag()->add('notice', $entityClass . ' imported');
        if ($continue) {
            return $this->redirect($continue);
        } else {
            return $this->redirect($this->generateUrl('import_index'));
        }
            */
    }

    /**
     * importUserHasUnitAction
     * @Route("/user_has_unit/{start}", name="import_user_has_unit", defaults={"start" = 0})
     *
     * @access public
     * @return void
     */
    public function importUserHasUnitAction ($start)
    {
        // conf
        $this->configure();
        $entityClass = 'SitiowebArmyCreatorBundle:UserHasUnit';
        if ($start == 0) {
            $this->clearEntityList($entityClass);
        }

        $query = $this->em->getConnection()->executeUpdate("
            INSERT INTO UserHasUnit (user_id, unit_id, number)
            SELECT u.id as user_id, au.id as unit_id, wcu.nb
            FROM wkarmycr_copy.wac_collection_unite wcu
            JOIN " . $this->getDbName() . ".Users u ON u.forumId = wcu.id_joueur
            JOIN " . $this->getDbName() . ".AbstractUnit au
                ON au.discriminator = 'unit'
                    AND au.importedId = wcu.id_unite
        ");
        return $this->redirect($this->generateUrl('import_index'));

/*
        // inserting
        $limit = 5000;
        $importList = $this->emImport->query("
            SELECT *
            FROM wac_collection_unite
            ORDER BY id
            LIMIT " . (int) $start . ", " . $limit . "
        ");

        if ($importList->rowCount() >= $limit) {
            $continue = $this->generateUrl('import_user_has_unit', array('start' => (int) $start + $limit));
        } else {
            $continue = null;
        }

        while ($row = $importList->fetch()) {
            $entity = new \Sitioweb\Bundle\ArmyCreatorBundle\Entity\UserHasUnit();
            $user = $this->em->getRepository('SitiowebArmyCreatorBundle:User')->findOneByForumId($row['id_joueur']);
            $entity->setUser($user);

            $unit = $this->em->getRepository('SitiowebArmyCreatorBundle:Unit')->findOneByImportedId($row['id_unite']);
            $entity->setUnit($unit);

            $entity->setNumber((int) $row['nb']);

            $this->em->persist($entity);
        }
        //$this->em->getClassMetaData($entityClass)->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        $this->em->flush();

        $this->get('session')->getFlashBag()->add('notice', $entityClass . ' imported');
        if ($continue) {
            return $this->redirect($continue);
        } else {
            return $this->redirect($this->generateUrl('import_index'));
        }
        */
    }

    /**
     * importSquadAction
     * @Route("/squad/{start}", name="import_squad", defaults={"start" = 0})
     *
     * @access public
     * @return void
     */
    public function importSquadAction ($start)
    {
        $minId = 0;

        // conf
        $this->configure();
        $entityClass = 'SitiowebArmyCreatorBundle:Squad';
        if ($start == 0 && $minId == 0) {
            //$this->clearEntityList('SitiowebArmyCreatorBundle:SquadLine');
            $this->clearEntityList($entityClass);
        }

        $query = $this->em->getConnection()->executeUpdate("
             INSERT INTO " . $this->getDbName() . ".Squad
              (id, army_id, name, position, updateDate, unitType_id, unitGroup_id)

              SELECT e.id, e.armee_id, e.nomPerso, e.position, FROM_UNIXTIME(e.lastUpdate),
              ut.id as unitType_id, au.id
              FROM wkarmycr_copy.escouade e
              JOIN wkarmycr_copy.unite wu ON wu.id = e.unite_id
              JOIN wkarmycr_copy.armee wa ON wa.id = e.armee_id

              LEFT JOIN " . $this->getDbName() . ".UnitType ut
                  ON ut.importedId = IFNULL(e.type_unite, wu.type_unite_id)
                  AND ut.breed_id = wa.race_id

              LEFT JOIN " . $this->getDbName() . ".AbstractUnit au
                  ON au.discriminator = 'group'
                  AND au.importedType = 'unit_group'
                  AND au.importedId = e.from_regroupement_id

              WHERE e.parent_id IS NULL
                ");

            /*>
              SELECT e.id, e.armee_id, e.nomPerso, e.position, FROM_UNIXTIME(e.lastUpdate),
              ut.id as unitType_id, au.id
              FROM wkarmycr_copy.escouade e
              JOIN wkarmycr_copy.armee wa ON wa.id = e.armee_id
              LEFT JOIN armycreator.UnitType ut
                ON ut.importedId = e.type_unite
                AND ut.breed_id = wa.race_id
                AND e.parent_id IS NULL

              LEFT JOIN armycreator.AbstractUnit au
                ON au.discriminator = 'group'
                AND au.importedId = e.from_regroupement_id

              WHERE parent_id IS NULL
              */

        return $this->redirect($this->generateUrl('import_index'));

        // inserting
        /*
        $this->em->getClassMetaData($entityClass)->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        $this->em->getClassMetaData('SitiowebArmyCreatorBundle:SquadLine')->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        $limit = 5000;

        $tmpQuery = $this->em->createQuery("
            SELECT MAX(army.id)
            FROM SitiowebArmyCreatorBundle:Army army
        ");
        $maxId = (int) $tmpQuery->getSingleScalarResult();

        $importList = $this->emImport->query("
            SELECT *
            FROM escouade
            WHERE armee_id <= " . $maxId . "
            ORDER BY id ASC
            LIMIT " . (int) $start . ", " . $limit . "
        ");

        if ($importList->rowCount() >= $limit) {
            $continue = $this->generateUrl('import_squad', array('start' => (int) $start + $limit));
        } else {
            $continue = null;
        }

        $cpt = 0;
        $prevIdParent = null;
        while ($row = $importList->fetch()) {
            $entity = null;
            $squadLine = null;
            $army = null;

            // cas break passage id parent > 0
            if (!$prevIdParent && $row['parent_id'] > 0) {
                //$this->em->flush();
            }

            $unit = $this->em->getRepository('SitiowebArmyCreatorBundle:Unit')->findOneByImportedId((int) $row['unite_id']);

            // ---- SQUAD
            if (!$row['parent_id']) {
                $entity = new \Sitioweb\Bundle\ArmyCreatorBundle\Entity\Squad();
                $entity->setId((int) $row['id']);

                $entity->setName($row['nomPerso']);

                $entity->setPosition((int) $row['position']);

                if ($row['lastUpdate'] > 0) {
                    $updateDate = new \DateTime();
                    $updateDate->setTimestamp((int) $row['lastUpdate']);
                    $entity->setUpdateDate($updateDate);
                }

                $army = $this->em->getRepository('SitiowebArmyCreatorBundle:Army')->find($row['armee_id']);

                $this->em->persist($army);
                $entity->setArmy($army);

                if ((int) $row['type_unite'] > 0) {
                    $unitType = $this->em->getRepository('SitiowebArmyCreatorBundle:UnitType')->findOneBy(array(
                        'importedId' => (int) $row['type_unite'],
                        'breed' => $unit->getBreed()
                    ));
                }  else {
                    $unitType = $unit->getUnitType();
                }
                $entity->setUnitType($unitType);

                if ($row['from_regroupement_id'] > 0) {
                    $unitGroup = $this->em->getRepository('SitiowebArmyCreatorBundle:UnitGroup')->findOneByImportedId((int) $row['from_regroupement_id']);
                    $entity->setUnitGroup($unitGroup);

                }
                $this->em->persist($entity);
            }

            // ---- SQUAD LINE
            $squadLine = new \Sitioweb\Bundle\ArmyCreatorBundle\Entity\SquadLine();
            $squadLine->setId((int) $row['id']);

            $squadLine->setPosition((int) $row['position']);
            $squadLine->setNumber((int) $row['nb_unite']);
            $squadLine->setUnit($unit);
            if ($row['parent_id'] > 0) {
                $squad = $this->em->getRepository('SitiowebArmyCreatorBundle:Squad')->find($row['parent_id']);
                $squadLine->setSquad($squad);
            } else {
                $squadLine->setSquad($entity);
            }

            $prevIdParent = $row['parent_id'];

            $this->em->persist($squadLine);
            if ($cpt >= 500) {
                $cpt = 0;
                set_time_limit(30);
                $this->em->flush();
                $this->em->clear();
            }
            $cpt++;
        }
        $this->em->flush();

        $this->get('session')->getFlashBag()->add('notice', $entityClass . ' imported');
        if ($continue) {
            return $this->redirect($continue);
        } else {
            return $this->redirect($this->generateUrl('import_index'));
        }
        */
    }

    /**
     * importSquadAction
     * @Route("/squad_line/{start}", name="import_squad_line", defaults={"start" = 0})
     *
     * @access public
     * @return void
     */
    public function importSquadLineAction ($start)
    {
        $minId = 0;

        // conf
        $this->configure();
        $entityClass = 'SitiowebArmyCreatorBundle:SquadLine';
        if ($start == 0 && $minId == 0) {
            $this->clearEntityList($entityClass);
        }

        $query = $this->em->getConnection()->executeUpdate("
              INSERT INTO " . $this->getDbName() . ".SquadLine
               (id, unit_id, squad_id, number, position, updateDate)

               SELECT e.id, au.id as unit_id, IFNULL(e.parent_id, e.id) as squad_id, e.nb_unite, e.position, FROM_UNIXTIME(e.lastUpdate)
               FROM wkarmycr_copy.escouade e

                LEFT JOIN " . $this->getDbName() . ".AbstractUnit au
                    ON au.discriminator = 'unit'
                        AND au.importedId = e.unite_id
                ");

        return $this->redirect($this->generateUrl('import_index'));
    }

    /**
     *
     * @Route("/squad_line_equipement/{start}", name="import_squad_line_equipement", defaults={"start" = 0})
     *
     * @access public
     * @return void
     */
    public function importSquadLineEquipementAction ($start)
    {
        // conf
        set_time_limit(300);
        $this->configure();
        $entityClass = 'SitiowebArmyCreatorBundle:SquadLineStuff';
        if ($start == 0) {
            //$this->clearEntityList($entityClass);
        }

        // inserting
        $this->em->getConnection()->executeUpdate("
            INSERT INTO " . $this->getDbName() . ".SquadLineStuff (number, unitStuff_id, squadLine_id)
            SELECT  ehe.nb_unite, us.id as unitStuff_id, ehe.escouade_id as squadLine_id
            FROM wkarmycr_copy.`escouade_has_equipement` ehe
            JOIN wkarmycr_copy.escouade e ON ehe.escouade_id = e.id
            JOIN wkarmycr_copy.unite u ON u.id = e.unite_id

            JOIN " . $this->getDbName() . ".AbstractUnit au
                ON au.discriminator = 'unit'
                AND au.importedId = u.id

            JOIN " . $this->getDbName() . ".Stuff stuff
                ON stuff.breed_id = u.race_id
                AND stuff.importedId = equipement_id
                AND stuff.discriminator  = 'equipement'

            JOIN " . $this->getDbName() . ".UnitStuff us
                ON us.stuff_id = stuff.id
                AND us.unit_id = au.id

            WHERE ehe.equipement_id > 0
        ");

        $this->get('session')->getFlashBag()->add('notice', $entityClass . ' imported : ' . $start);

        return $this->redirect($this->generateUrl('import_index'));
    }

    /**
     *
     * @Route("/squad_line_weapon/{start}", name="import_squad_line_weapon", defaults={"start" = 0})
     *
     * @access public
     * @return void
     */
    public function importSquadLineWeaponAction ($start)
    {
        // conf
        set_time_limit(300);
        $this->configure();
        $entityClass = 'SitiowebArmyCreatorBundle:SquadLineStuff';
        if ($start == 0) {
            //$this->clearEntityList($entityClass);
        }

        // inserting
        $this->em->getConnection()->executeUpdate("
            INSERT INTO " . $this->getDbName() . ".SquadLineStuff (number, unitStuff_id, squadLine_id)
            SELECT  ehe.nb_unite, us.id as unitStuff_id, ehe.escouade_id as squadLine_id
            FROM wkarmycr_copy.`escouade_has_equipement` ehe
            JOIN wkarmycr_copy.escouade e ON ehe.escouade_id = e.id
            JOIN wkarmycr_copy.unite u ON u.id = e.unite_id

            JOIN " . $this->getDbName() . ".AbstractUnit au
                ON au.discriminator = 'unit'
                AND au.importedId = u.id

            JOIN " . $this->getDbName() . ".Stuff stuff
                ON stuff.breed_id = u.race_id
                AND stuff.importedId = arme_id
                AND stuff.discriminator  = 'weapon'

            JOIN " . $this->getDbName() . ".UnitStuff us
                ON us.stuff_id = stuff.id
                AND us.unit_id = au.id

            WHERE ehe.arme_id > 0
        ");

        $this->get('session')->getFlashBag()->add('notice', $entityClass . ' imported : ' . $start);

        return $this->redirect($this->generateUrl('import_index'));
    }
}
