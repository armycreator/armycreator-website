<?php

namespace Sitioweb\Bundle\ArmyCreatorBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * NewsController
 *
 * @author Julien Deniau <julien.deniau@mapado.com>
 */
class NewsController extends Controller
{
    /**
     * newsAction
     *
     * @param mixed $forumId
     * @param int $limit
     * @access public
     * @return Response
     *
     * @Template
     */
    public function newsAction($forumId = 2, $limit = 10)
    {
        $query = '
            SELECT t.topic_id, t.topic_title, t.topic_poster, t.topic_first_poster_name,
                t.topic_time, COUNT(p.post_id) as topic_replies,
                fp.post_text
            FROM phpbb_topics t
                LEFT JOIN phpbb_posts fp ON fp.post_id = t.topic_first_post_id
                LEFT JOIN phpbb_posts p ON p.topic_id = t.topic_id
            WHERE t.forum_id = :forumId
            GROUP BY t.topic_id
            ORDER BY topic_time DESC
            LIMIT :limit';

        $news = $this->get('doctrine.dbal.forum_connection')
            ->fetchAll(
                $query,
                ['forumId' => (int) $forumId, 'limit' => (int) $limit],
                ['forumId' => 'integer', 'limit' => 'integer']
            );

        foreach ($news as &$n) {
            $n['post_text'] = urldecode($n['post_text']);
            $n['post_text'] = html_entity_decode($n['post_text']);
            $n['post_text'] = preg_replace('/:[:a-zA-Z0-9]+\]/', ']', $n['post_text']);
            $n['post_text'] = str_replace('[/*]', '', $n['post_text']);
            //$n['post_text'] = preg_replace('/\[\/([a-zA-Z]+)(:[a-zA-Z0-9]+)\]/', '[/$1]', $n['post_text']);
        }


        return [
            'forumId' => $forumId,
            'newsList' => $news
        ];
    }
}
