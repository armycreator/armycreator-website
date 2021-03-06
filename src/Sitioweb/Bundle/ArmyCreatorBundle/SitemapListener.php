<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle;

use Doctrine\ORM\EntityManager;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Service\SitemapListenerInterface;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;

use Sitioweb\Bundle\ArmyCreatorBundle\Entity\Army;

use Symfony\Component\Routing\RouterInterface;

/**
 * SitemapListener
 *
 * @uses SitemapListenerInterface
 */
class SitemapListener implements SitemapListenerInterface
{
    /**
     * router
     *
     * @var Router
     * @access private
     */
    private $router;

    /**
     * entityManager
     *
     * @var EntityManager
     * @access private
     */
    private $entityManager;

    /**
     * event
     *
     * @var SitemapPopulateEvent
     * @access private
     */
    private $event;

    /**
     * treatedUsers
     *
     * @var array
     * @access private
     */
    private $treatedUsers;

    /**
     * __construct
     *
     * @param Router $router
     * @param EntityManager $entityManager
     * @access public
     * @return void
     */
    public function __construct(RouterInterface $router, EntityManager $entityManager)
    {
        $this->router = $router;
        $this->entityManager = $entityManager;
    }

    public function populateSitemap(SitemapPopulateEvent $event)
    {
        $this->event = $event;
        $section = $event->getSection();
        $this->populateStatic();
        $this->populatePublicArmyList();
    }

    /**
     * populateStatic
     *
     * @access private
     * @return void
     */
    private function populateStatic()
    {
        $routeList = [
            'toolbox_dice' => UrlConcrete::CHANGEFREQ_MONTHLY,
            'toolbox_weapon_statistic' => UrlConcrete::CHANGEFREQ_MONTHLY,
            'toolbox_infight_statistic' => UrlConcrete::CHANGEFREQ_MONTHLY,
            'army_public_list' => UrlConcrete::CHANGEFREQ_DAILY,
            'homepage' => UrlConcrete::CHANGEFREQ_WEEKLY,
            'forum_index' => UrlConcrete::CHANGEFREQ_HOURLY,
            'user_list' => UrlConcrete::CHANGEFREQ_MONTHLY,
        ];

        foreach ($routeList as $route => $freq) {
            $url = $this->router->generate($route, [], true);
            $urlConcrete = new UrlConcrete($url, new \DateTime(), $freq, 1);
            $this->event->getGenerator()->addUrl($urlConcrete, 'default');
        }
    }


    /**
     * populatePublicArmyList
     *
     * @access private
     * @return void
     */
    private function populatePublicArmyList()
    {
        $publicArmyList = $this->entityManager->getRepository('SitiowebArmyCreatorBundle:Army')
            ->findPublicQueryBuilder()
            ->orderBy('a.updateDate', 'DESC')
            ->getQuery()
            ->getResult();

        foreach ($publicArmyList as $army) {
            $freq = $this->getArmyFrequency($army);

            // army route
            $url = $this->router->generate('army_detail', ['slug' => $army->getSlug()], true);

            $updateDate = $army->getUpdateDate() ?: new \DateTime;
            $urlConcrete = new UrlConcrete($url, $updateDate, $freq, 1);
            $this->event->getGenerator()->addUrl($urlConcrete, 'army');

            // user route
            $this->populateUser($army->getUser(), $updateDate, $freq);
        }
    }

    /**
     * populateUsersList
     *
     * @access private
     * @return void
     */
    private function populateUsersList()
    {
        $userList = $this->get('doctrine.orm.default_entity_manager')
            ->getRepository('SitiowebArmyCreatorBundle:User')
            ->findByWantToPlay(true);

        foreach ($userList as $user) {
            $this->populateUser($user, $user->getLastLogin(), UrlConcrete::CHANGEFREQ_MONTHLY);
        }
    }

    /**
     * populateUser
     *
     * @param User $user
     * @access private
     * @return void
     */
    private function populateUser($user, $updateDate, $freq)
    {
        if (!isset($this->treatedUsers[$user->getId()])) {
            $url = $this->router->generate('user_index', ['userSlug' => $user->getSlug()], true);
            $urlConcrete = new UrlConcrete($url, $updateDate, $freq, 1);
            $this->event->getGenerator()->addUrl($urlConcrete, 'user');
        }
    }

    /**
     * getArmyFrequency
     *
     * @param Army $army
     * @access private
     * @return int
     */
    private function getArmyFrequency(Army $army)
    {
        $now = new \DateTime;
        if (!$army->getUpdateDate()) {
            return UrlConcrete::CHANGEFREQ_MONTHLY;
        }

        $diff = $now->format('U') - $army->getUpdateDate()->format('U');

        if ($diff < 604800) {
            return UrlConcrete::CHANGEFREQ_DAILY;
        } else {
            return UrlConcrete::CHANGEFREQ_MONTHLY;
        }
    }
}
