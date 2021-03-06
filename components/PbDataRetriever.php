<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 9/21/16
 * Time: 2:12 AM
 */

namespace app\components;


use yii\base\Component;

class PbDataRetriever extends Component{
    protected  $returnDataRaw;
    public function init(){
        $this->returnDataRaw  = file_get_contents("http://pb.site8.co/exportAll.php?quack=INVOKOdyWUGw2bc");
    }


    public function getRawData(){
        return $this->returnDataRaw;
    }
    public function getDataArr()
    {
        //write to temp file
        $tempFileContainer = tempnam(sys_get_temp_dir(), 'sadasd');
        file_put_contents($tempFileContainer, $this->getRawData());
        $csvFileRes = fopen($tempFileContainer, "r+");
        $agentDataCollection = [];
        //parse the csv
        fgetcsv($csvFileRes);//skip first line ,
        while(!feof($csvFileRes)){
            $currentCsvRow = fgetcsv($csvFileRes);
            if (!isset(  $agentDataCollection[$currentCsvRow[1]]  )) {
                //collect the agent name
                $agentDataCollection[$currentCsvRow[1]] = [
                    'agent_name'=>$currentCsvRow[1],
                    'submissions'=>0,
                ];
            }
            $agentDataCollection[$currentCsvRow[1]]['submissions'] = $agentDataCollection[$currentCsvRow[1]]['submissions'] +1 ;
                // if agent is in collection
                // add/update value
        }
        fclose($csvFileRes);
        return array_values($agentDataCollection);
    }
    public function getRawAsArr(){
        //write to temp file
        $tempFileContainer = tempnam(sys_get_temp_dir(), 'sadasd');
        file_put_contents($tempFileContainer, $this->getRawData());
        $csvFileRes = fopen($tempFileContainer, "r+");
        $rawArrLine = [];
        //parse the csv
        fgetcsv($csvFileRes);//skip first line ,
        while(!feof($csvFileRes)){
            $rawArrLine[] = fgetcsv($csvFileRes);
        }
        fclose($csvFileRes);
        return $rawArrLine;
    }


} 