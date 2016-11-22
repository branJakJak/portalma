<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11/22/16
 * Time: 10:15 PM
 */

namespace app\components;


class ForceDownloadCsv {

    public static function export($fileOutput , $filename)
    {
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$filename.csv\";");
        header("Content-Transfer-Encoding: binary");
        echo file_get_contents($fileOutput);
    }
} 