<?php
/**
 *
 * @package PhpbbWebsiteInterfaceBundle
 * @copyright (c) 2013 phpBB Group
 * @license http://opensource.org/licenses/gpl-3.0.php GNU General Public License v3
 * @author MichaelC
 *
 */

namespace Phpbb\WebsiteInterfaceBundle\Wrappers;

class PhpbbHandling
{
    public static function bbcodeStripping($text, $uid = '[0-9a-z]{5,}')
    {
        $text = preg_replace("#\[\/?[a-z0-9\*\+\-]+(?:=(?:&quot;.*&quot;|[^\]]*))?(?::[a-z])?(\:$uid)\]#", ' ', $text);
        $match = array(
            '#<!\-\- e \-\-><a href="mailto:(.*?)">.*?</a><!\-\- e \-\->#',
            '#<!\-\- l \-\-><a (?:class="[\w-]+" )?href="(.*?)(?:(&amp;|\?)sid=[0-9a-f]{32})?">.*?</a><!\-\- l \-\->#',
            '#<!\-\- ([mw]) \-\-><a (?:class="[\w-]+" )?href="(.*?)">.*?</a><!\-\- \1 \-\->#',
            '#<!\-\- s(.*?) \-\-><img src="\{SMILIES_PATH\}\/.*? \/><!\-\- s\1 \-\->#',
            '#<!\-\- .*? \-\->#s',
            '#<.*?>#s',
        );
        $replace = array('\1', '\1', '\2', '\1', '', '');

        $text = preg_replace($match, $replace, $text);

        return $text;
    }

    /**
     * @param integer $retrieve_limit
     * @param integer $announcement_forum
     */
    public static function getTopicsFromForum($phpbbConnection, $announcement_forum, $retrieve_limit)
    {
        $sql = 'SELECT t.*, p.post_text, p.bbcode_uid
            FROM community_topics t
            LEFT JOIN community_posts p
                ON t.topic_first_post_id = p.post_id
            WHERE t.forum_id IN (' . $announcement_forum . ', 0)
                AND t.topic_visibility = 1
            ORDER BY topic_time DESC
            LIMIT 0,' . $retrieve_limit;

        $topics = $phpbbConnection->fetchAll($sql);

        return $topics;
    }
}
