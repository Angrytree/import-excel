<?php

namespace App\Helpers;

class PhpSettings {

    /**
     * Get php.ini upload_max_filesize value.
     */
    public static function uploadMaxFilesize() {
        return ini_get('upload_max_filesize');
    }

    /**
     * Get php.ini post_max_size value.
     */
    public static function postMaxSize() {
        return ini_get('post_max_size');
    }

}