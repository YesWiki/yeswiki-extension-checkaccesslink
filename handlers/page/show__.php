<?php

// Vérification de sécurité
if (!defined("WIKINI_VERSION")) {
    die("acc&egrave;s direct interdit");
}
if (!function_exists('check_acls_links')) {
    function check_acls_links($matches)
    {
        $tag = str_replace($GLOBALS['wiki']->config['base_url'], '', $matches[2]);
        // The Target page is not within the scope rights of the user. Link is ignored.
        if (! $GLOBALS['wiki']->HasAccess('read', $tag)){
            return '';
        } else {
            return $matches[1].$matches[3].'</a>';
        }
    }
}

// search in the buffer if some links contain the alter management string
$plugin_output_new = preg_replace_callback(
    '/(\<a.*href="(.*)".*\>)(.*)'.preg_quote($this->config["alter_management_string"], '/').'\<\/a\>/m',
    'check_acls_links',
    $plugin_output_new
);
