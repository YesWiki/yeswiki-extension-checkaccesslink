<?php

/**
 * wiki.php
 *
 * Description : fichier de configuration de checkaccesslink
 *
 *@package wkcheckaccesslink
 *
 *@author        Olivier PICOT <sylvain@boyer.earth>
 *@author        Sylvain BOYER <sylvain@boyer.earth>
 *@author        Florian SCHMITT <mrflos@lilo.org>
 *
 */

if (!defined("WIKINI_VERSION")) {
    die("acc&egrave;s direct interdit");
}

// We check the string of right checking in config
if (!isset($wakkaConfig['alter_management_string'])) {
    // default value if not set = cacher_si_pas_autorise
    $wakkaConfig['alter_management_string'] = 'cacher_si_pas_autorise';
}
