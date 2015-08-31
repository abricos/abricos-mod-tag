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

    protected $_cache = array();

    public function __construct(TagManager $manager){
        $this->manager = $manager;
        $this->db = $manager->db;

        $models = $this->models = AbricosModelManager::GetManager('tag');

        $models->RegisterClass('Tag', 'TagItem');
        $models->RegisterClass('TagList', 'TagItemList');
    }

    public function AJAX($d){
        switch ($d->do){
            case "appStructure":
                return $this->AppStructureToJSON();
        }
        return null;
    }

    public function ClearCache(){
        $this->_cache = array();
    }

    private function ResultToJSON($name, $res){
        $ret = new stdClass();

        if (is_integer($res)){
            $ret->err = $res;
            return $ret;
        }
        $ret->$name = $res->ToJSON();

        return $ret;
    }

    private function ImplodeJSON($jsons, $ret = null){
        if (empty($ret)){
            $ret = new stdClass();
        }
        foreach ($jsons as $json){
            foreach ($json as $key => $value){
                $ret->$key = $value;
            }
        }
        return $ret;
    }

    public function AppStructureToJSON(){
        if (!$this->manager->IsViewRole()){
            return 403;
        }

        $modelManager = AbricosModelManager::GetManager('money');

        $res = $modelManager->ToJSON('Tag'        );
        if (empty($res)){
            return null;
        }

        $ret = new stdClass();
        $ret->appStructure = $res;
        return $ret;
    }

}

?>