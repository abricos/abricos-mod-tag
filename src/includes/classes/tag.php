<?php
/**
 * @package Abricos
 * @subpackage Tag
 * @copyright 2015 Alexander Kuzmin
 * @license http://opensource.org/licenses/mit-license.php MIT License (MIT)
 * @author Alexander Kuzmin <roosit@abricos.org>
 */


require_once 'models.php';

class Tag {

    /**
     * @var TagManager
     */
    public $manager;

    /**
     * @var Ab_Database
     */
    public $db;

    /**
     * @var AbricosModelManager
     */
    public $models;

    public function __construct(TagManager $manager){
        $this->manager = $manager;
        $this->db = $manager->db;

        $models = $this->models = AbricosModelManager::GetManager('tag');

        $models->RegisterClass('Tag', 'TagItem');
        $models->RegisterClass('TagList', 'TagItemList');
    }

    public function AppStructureToJSON(){
        $modelManager = AbricosModelManager::GetManager('tag');

        $res = $modelManager->ToJSON('Tag');
        if (empty($res)){
            return null;
        }

        $ret = new stdClass();
        $ret->appStructure = $res;
        return $ret;
    }

    public static function TagsParse($tags){
        if (!is_array($tags)){
            return array();
        }
        $ret = array();
        $count = min(count($tags), 16);
        for ($i = 0; $i < $count; $i++){
            $tag = mb_strtolower(trim($tags[$i]), 'UTF-8');
            if (strlen($tag) === 0){
                continue;
            }
            $ret[$i] = $tag;
        }
        return $ret;
    }

    public function TagsSave($module, $owner, $ownerid, $tags, $groupid = 0){
        TagQuery::TagsAppendInBase($this->db, $tags);
        TagQuery::TagsSave($this->db, $module, $owner, $ownerid, $tags, $groupid);
    }

    public function TagsByQuery($module, $config){
        $ret = [];
        $rows = TagQuery::TagsByQuery($this->db, $module, $config);
        while (($d = $this->db->fetch_array($rows))){
            $ret[] = $d['tag'];
        }
        return $ret;
    }

}

?>