<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11/22/16
 * Time: 10:13 PM
 */

namespace app\components;


class QueryResultToCsv {
    public function writeToFile($rawArrResult){
        $tempFile = tempnam(sys_get_temp_dir(), "container");
        $fileRes = fopen($tempFile,'w+');
        foreach ($rawArrResult as $index => $currentRow) {
            if($index === 0){
                $headers = array_keys($currentRow);
                fputcsv($fileRes, $headers);
            }
            $curValContainer = array_values($currentRow);
            fputcsv($fileRes, $curValContainer);
        }
        fclose($fileRes);
        return $tempFile;
    }
} 