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
				
			title varchar(100) NOT NULL DEFAULT '' COMMENT 'Title',
				
			PRIMARY KEY (tagid),
			UNIQUE KEY title (title)
		)".$charset
    );

    $db->query_write("
		CREATE TABLE IF NOT EXISTS ".$pfx."tag_owner (
			ownerid integer(10) unsigned NOT NULL COMMENT 'Owner ID',
			tagid integer(10) unsigned NOT NULL COMMENT 'Tag ID',
			module varchar(50) NOT NULL DEFAULT '' COMMENT '',

			UNIQUE KEY tag (ownerid, tagid, module)
		)".$charset
    );
}

?>