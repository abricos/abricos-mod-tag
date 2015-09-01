<?php
/**
 * @package Abricos
 * @subpackage Tag
 * @copyright 2015 Alexander Kuzmin
 * @license http://opensource.org/licenses/mit-license.php MIT License (MIT)
 * @author Alexander Kuzmin <roosit@abricos.org>
 */

$charset = "CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'";
$updateManager = Ab_UpdateManager::$current;
$db = Abricos::$db;
$pfx = $db->prefix;

if ($updateManager->isInstall()){

    Abricos::GetModule('money')->permission->Install();

    $db->query_write("
		CREATE TABLE IF NOT EXISTS ".$pfx."tag (
			tagid integer(10) unsigned NOT NULL auto_increment COMMENT 'Tag ID',
				
			tag varchar(250) NOT NULL DEFAULT '' COMMENT 'Tag',
				
			PRIMARY KEY (tagid),
			UNIQUE KEY tag (tag)
		)".$charset
    );

    $db->query_write("
		CREATE TABLE IF NOT EXISTS ".$pfx."tag_owner (
			modname varchar(50) NOT NULL DEFAULT '' COMMENT '',
			owner varchar(50) NOT NULL DEFAULT '' COMMENT '',
			ownerid integer(10) unsigned NOT NULL COMMENT 'Owner ID',
			tagid integer(10) unsigned NOT NULL COMMENT 'Tag ID',

			groupid integer(10) unsigned NOT NULL COMMENT 'Group ID',
			userid integer(10) unsigned NOT NULL COMMENT 'User ID',

			PRIMARY KEY (modname, owner, ownerid, tagid),
			KEY grpusr (groupid,userid)
		)".$charset
    );
}

?>