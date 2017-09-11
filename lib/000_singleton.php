<?php

if (version_compare(phpversion(), '5.3', '>=')) {
    $singleton_file = dirname(__FILE__) . '/000_singleton.inc';
} else { // less than 5.2
    $singleton_file = dirname(__FILE__) . '/000_singleton_compat.inc';
}

include_once $singleton_file;
