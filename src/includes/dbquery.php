<?php
/**
 * @package Abricos
 * @subpackage Tag
 * @copyright 2015 Alexander Kuzmin
 * @license http://opensource.org/licenses/mit-license.php MIT License (MIT)
 * @author Alexander Kuzmin <roosit@abricos.org>
 */


/**
 * Class TagQuery
 */
class TagQuery {

    public static function TagsAppendInBase(Ab_Database $db, $tags){
        $tags = Tag::TagsParse($tags);
        if (count($tags) === 0){
            return;
        }
        $vals = array();
        for ($i = 0; $i < count($tags); $i++){
            array_push($vals, "('".bkstr($tags[$i])."')");
        }
        $sql = "
			INSERT IGNORE INTO ".$db->prefix."tag
			(tag) VALUES ".implode(",", $vals)."
		";
        $db->query_write($sql);
    }

    public static function TagsByTags(Ab_Database $db, $tags){
        $tags = Tag::TagsParse($tags);
        if (count($tags) === 0){
            return null;
        }
        $whs = array();
        for ($i = 0; $i < count($tags); $i++){
            array_push($whs, "tag='".bkstr($tags[$i])."'");
        }
        $sql = "
			SELECT *
			FROM ".$db->prefix."tag
			WHERE ".implode(" OR ", $whs)."
		";
        return $db->query_read($sql);
    }

    public static function TagsSave(Ab_Database $db, $module, $owner, $ownerid, $tags, $groupid = 0){
        $sql = "
          DELETE FROM ".$db->prefix."tag_owner
          WHERE modname='".bkstr($module)."'
              AND owner='".bkstr($owner)."'
              AND ownerid=".intval($ownerid)."
        ";

        $db->query_write($sql);

        $rows = TagQuery::TagsByTags($db, $tags);
        while (($d = $db->fetch_array($rows))){
            $sql = "
                INSERT INTO ".$db->prefix."tag_owner
                    (modname,owner,ownerid,tagid,groupid,userid)
                VALUES (
                    '".bkstr($module)."',
                    '".bkstr($owner)."',
                    ".intval($ownerid).",
                    ".intval($d['tagid']).",
                    ".intval($groupid).",
                    ".intval(Abricos::$user->id)."
                )
            ";
            $db->query_write($sql);
        }
    }
}

?>