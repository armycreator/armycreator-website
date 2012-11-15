<?php

namespace Sitioweb\Bundle\ArmyCreatorImportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array('name' => $name);
    }

    /**
     * importBreed
     * @Route("/breed")
     *
     * @access public
     * @return void
     */
    public function importBreed()
    {
        // conf
        $em = $this->get('doctrine')->getEntityManager();
        $emImport = $this->get('doctrine')->getEntityManager('import')->getConnection();
        $w40k = $em->getRepository('SitiowebArmyCreatorBundle:Game')->findOneByCode('W40K');

        // delete
        $breedList = $em->getRepository('SitiowebArmyCreatorBundle:Breed')->findAll();
        
        foreach ($breedList as $breed) {
            $em->remove($breed);
        }
        $em->flush();

        // inserting
        $importBreedList = $emImport->query("SELECT * FROM race ORDER BY id DESC");
        while ($row = $importBreedList->fetch()) {
            ladybug_dump($row['nom']);
            
            $breed = new \Sitioweb\Bundle\ArmyCreatorBundle\Entity\Breed();
            $breed->setId((int) $row['id']);
            $breed->setName(utf8_encode($row['nom']));
            if ($row['new_version_id'] > 0) {
                $nv = $em->getRepository('SitiowebArmyCreatorBundle:Breed')->find((int) $row['new_version_id']);
                $breed->setNewVersion($nv);
            }
            $breed->setAvailable((int) $row['disponible']);
            $breed->setGame($w40k);
            ladybug_dump($breed);
            

            $em->persist($breed);

            $metadata = $em->getClassMetaData(get_class($breed));
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            $em->flush();
        }
        
        return array();
    }
}
