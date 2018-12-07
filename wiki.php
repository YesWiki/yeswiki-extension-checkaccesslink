<?php

/**
 * wiki.php
 *
 * Description : fichier de configuration de bazar
 *
 *@package wkbazar
 *
 *@author        Florian SCHMITT <florian@outils-reseaux.org>
 *
 *@copyright     outils-reseaux.org 2008
 *@version       $Revision: 1.12 $ $Date: 2010-12-01 17:01:38 $
 *  +------------------------------------------------------------------------------------------------------+
 */



if (!defined("WIKINI_VERSION")) {
    die("acc&egrave;s direct interdit");
}

$wikiClasses[] = 'checkaccesslink';

// fonctions supplementaires a ajouter la classe wiki
$fp = @fopen('tools/checkaccesslink/includes/YesWiki.php', 'r');
$contents = fread($fp, filesize('tools/checkaccesslink/includes/YesWiki.php'));
fclose($fp);
$wikiClassesContent [] = str_replace('<?php', '', $contents);
