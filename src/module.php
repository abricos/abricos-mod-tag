<?php
/**
 * @package Abricos
 * @subpackage Tag
 * @copyright 2015 Alexander Kuzmin
 * @license http://opensource.org/licenses/mit-license.php MIT License (MIT)
 * @author Alexander Kuzmin <roosit@abricos.org>
 */

/**
 * Модуль Финансы
 */
class TagModule extends Ab_Module {

    private $_manager;

    /**
     * Конструктор
     */
    public function __construct(){
        $this->version = "0.0.1";
        $this->name = "tag";
        $this->permission = new TagPermission($this);
    }

    /**
     * @return TagManager
     */
    public function GetManager(){
        if (!isset($this->_manager)){
            require_once 'includes/manager.php';
            $this->_manager = new TagManager($this);
        }
        return $this->_manager;
    }
}

class TagAction {
    const ADMIN = 50;
}

class TagPermission extends Ab_UserPermission {

    public function TagPermission(TagModule $module){
        $defRoles = array(
            new Ab_UserRole(TagAction::ADMIN, Ab_UserGroup::ADMIN)
        );
        parent::__construct($module, $defRoles);
    }

    public function GetRoles(){
        return array(
            TagAction::ADMIN => $this->CheckAction(TagAction::ADMIN)
        );
    }
}

Abricos::ModuleRegister(new TagModule());

?>