<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 10/6/16
 * Time: 1:32 AM
 */

namespace app\commands;


use tests\codeception\unit\components\helper\MoneyActiveDataPopulator;
use yii\console\Controller;

class LocalDataPopulatorController extends Controller{
    public function actionIndex()
    {
//        $nextWeek = date("Y-m-d H:i:s", strtotime("next week wednesday"));
        $thisweekasd = date("Y-m-d H:i:s", strtotime("last month"));
        echo "Preparing to submit data \r\n";
        $dataCollection = MoneyActiveDataPopulator::insertData(10, [
            'date_submitted'=>$thisweekasd,
            'pb_agent'=>'',
            'outcome'=>'POX1',
        ]);

        foreach ($dataCollection as $currentData) {
            /*
             * @var $currentData MoneyActiveClaims
             * */
            $currentData->date_submitted = $thisweekasd;
            $currentData->update(false);
        }
        $dataCollection = MoneyActiveDataPopulator::insertData(10, [
            'date_submitted'=>$thisweekasd,
            'pb_agent'=>'',
            'outcome'=>'CALL BACK',
        ]);
        foreach ($dataCollection as $currentData) {
            /*
             * @var $currentData MoneyActiveClaims
             * */
            $currentData->date_submitted = $thisweekasd;
            $currentData->update(false);
        }

        echo "Data submitted \r\n";
    }
} 