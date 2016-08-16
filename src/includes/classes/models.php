<?php
/**
 * @package Abricos
 * @subpackage Tag
 * @copyright 2015 Alexander Kuzmin
 * @license http://opensource.org/licenses/mit-license.php MIT License (MIT)
 * @author Alexander Kuzmin <roosit@abricos.org>
 */

/**
 * Class TagItem
 *
 * @property int $id User ID
 * @property int $role User Role Value
 */
class TagItem extends AbricosModel {
    protected $_structModule = 'tag';
    protected $_structName = 'Tag';
}

/**
 * Class TagItemList
 * @method TagItem Get(int $userid)
 * @method TagItem GetByIndex(int $index)
 */
class TagItemList extends AbricosModelList {

}
