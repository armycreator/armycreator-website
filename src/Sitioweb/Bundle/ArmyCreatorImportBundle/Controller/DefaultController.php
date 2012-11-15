<?php

namespace Sitioweb\Bundle\ArmyCreatorImportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
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
            'import_breed' => 'SitiowebArmyCreatorBundle:Breed',
            'import_unit_type' => 'SitiowebArmyCreatorBundle:UnitType',
            'import_unit_group' => 'SitiowebArmyCreatorBundle:UnitGroup',
            'import_unit' => 'SitiowebArmyCreatorBundle:Unit',
            'import_unit_has_unit_group' => 'SitiowebArmyCreatorBundle:UnitHasUnitGroup',

        );

        $em = $this->get('doctrine')->getEntityManager();

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

    /**
     * configure
     *
     * @access public
     * @return void
     */
    public function configure()
    {
        // conf
        $this->em = $this->get('doctrine')->getEntityManager();
        $this->emImport = $this->get('doctrine')->getEntityManager('import')->getConnection();
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
        $entityList = $this->em->getRepository($entityClass)->findAll();
        
        foreach ($entityList as $entity) {
            $this->em->remove($entity);
        }
        $this->em->flush();
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
        $this->get('session')->setFlash('notice', $entityClass . ' cleared');
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
            if ($row['new_version_id'] > 0) {
                $nv = $this->em->getRepository('SitiowebArmyCreatorBundle:Breed')->find((int) $row['new_version_id']);
                $breed->setNewVersion($nv);
            }
            $breed->setAvailable((int) $row['disponible']);
            $breed->setGame($this->w40k);

            $this->em->persist($breed);
            $this->em->getClassMetaData(get_class($breed))->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            $this->em->flush();
        }
        
        $this->get('session')->setFlash('notice', 'Breed imported');
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
                $this->em->flush();
            }
        }
        
        $this->get('session')->setFlash('notice', $entityClass . ' imported');
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
            $entity->setName(utf8_encode($row['nom']));

            $breed = $this->em->getRepository('SitiowebArmyCreatorBundle:Breed')->find($row['race_id']);
            $entity->setBreed($breed);

            $unitType = $this->em->getRepository('SitiowebArmyCreatorBundle:UnitType')->findOneBy(array('breed' => $breed, 'importedId' => $row['type_unite_id']));
            $entity->setUnitType($unitType);

            $this->em->persist($entity);
            //$this->em->getClassMetaData($entityClass)->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            $this->em->flush();
        }
        
        $this->get('session')->setFlash('notice', $entityClass . ' imported');
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
            $entity->setName(utf8_encode($row['nom']));

            $breed = $this->em->getRepository('SitiowebArmyCreatorBundle:Breed')->find($row['race_id']);
            $entity->setBreed($breed);

            $unitType = $this->em->getRepository('SitiowebArmyCreatorBundle:UnitType')->findOneBy(array('breed' => $breed, 'importedId' => $row['type_unite_id']));
            $entity->setUnitType($unitType);

            $entity->setViewInList((int) $row['viewInList']);
            $entity->setCanModifyNumber((int) $row['canModifyNumber']);

            if ($row['parent_id']) {
                $parent = $this->em->getRepository('SitiowebArmyCreatorBundle:Unit')->findOneByImportedId($row['parent_id']);
                
                $entity->setParent($parent);
            }

            $this->em->persist($entity);
            //$this->em->getClassMetaData($entityClass)->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            $this->em->flush();
        }
        
        $this->get('session')->setFlash('notice', $entityClass . ' imported : ' . $start);

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
            $entity->setUnit($unit);
            $group = $this->em->getRepository('SitiowebArmyCreatorBundle:UnitGroup')->findOneByImportedId($row['regroupement_id']);
            $entity->setGroup($group);

            $entity->setCanChooseNumber((int) $row['canChooseNumber']);
            $entity->setMainUnit((int) $row['unite_principale']);
            $entity->setUnitNumber((int) $row['nb_unite']);

            $this->em->persist($entity);
            //$this->em->getClassMetaData($entityClass)->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            $this->em->flush();
        }
        
        $this->get('session')->setFlash('notice', $entityClass . ' imported : ' . $start);

        if ($continue) {
            return $this->redirect($continue);
        } else {
            return $this->redirect($this->generateUrl('import_index'));
        }
    }
}
