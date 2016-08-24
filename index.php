<?php

    /*
        Plugin Name: Simple User Meta Editor
        Description: This plugin allows site admin's to edit user meta data from back-end or admin panel.
        Author: Anjan Bhowmik <anjan011@gmail.com>
        Author URI: http://anjan.me
        Version: 1.0.0
    */

    if(!is_admin()) { // We will not do anything if not on back-end!
        return;
    }

    define('ME_ANJAN_SUME_PREFIX','me_anjan_sume_');

    /* Plugin base file, that is this file */

    define('ME_ANJAN_SUME_BASE_FILE',__FILE__);

    /* Plugin text domain */

    define('ME_ANJAN_SUME_TEXT_DOMAIN','me_anjan_simple_user_meta_editor');

    /* Plugin dir root */

    define('ME_ANJAN_SUME_DIR',plugin_dir_path(__FILE__));

    /* Plugin dir url */

    define('ME_ANJAN_SUME_URL',plugin_dir_url(__FILE__));

    /* Auto Load Classes */

    function me_anjan_sume_auto_loader($className) {

        $classDir = ME_ANJAN_SUME_DIR.'/includes/classes/';

        $fileName = $classDir.'class.'.$className.'.php';

        if(file_exists($fileName)) {
            require_once($fileName);
        }

    }

    spl_autoload_register('me_anjan_sume_auto_loader');

    /* Start the process */

    $sume_Main = new sume_main();

    $sume_Main->init();

