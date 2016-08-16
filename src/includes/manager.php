<?php
/**
 * @package Abricos
 * @subpackage Tag
 * @copyright 2015 Alexander Kuzmin
 * @license http://opensource.org/licenses/mit-license.php MIT License (MIT)
 * @author Alexander Kuzmin <roosit@abricos.org>
 */

require_once 'dbquery.php';

class TagManager extends Ab_ModuleManager {

    /**
     * @var TagModule
     */
    public $module = null;

    /**
     * @var TagManager
     */
    public static $instance = null;

    public function __construct(TagModule $module){
        parent::__construct($module);

        TagManager::$instance = $this;
    }

    public function IsAdminRole(){
        return $this->IsRoleEnable(TagAction::ADMIN);
    }

    private $_tag = null;

    /**
     * @return Tag
     */
    public function GetTag(){
        if (!is_null($this->_tag)){
            return $this->_tag;
        }
        require_once 'classes/tag.php';
        $this->_tag = new Tag($this);
        return $this->_tag;
    }

    public function AJAX($d){
        return $this->GetTag()->AJAX($d);
    }

}
