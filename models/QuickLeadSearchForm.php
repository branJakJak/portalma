<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11/9/16
 * Time: 12:35 AM
 */

namespace app\models;


use yii\base\Model;

class QuickLeadSearchForm extends Model
{
    public $searchTerm;
    protected $queryInstance;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // [['searchTerm'], 'required'],
            [['searchTerm'], 'safe'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'searchTerm'=>'Search term'
        ];
    }
    public function search(){
        $status = true;
        try {
            $this->queryInstance = MoneyActiveClaims::find()
                ->andFilterWhere([
                    'or',
                    ['like', 'title', $this->searchTerm],
                    ['like', 'firstname', $this->searchTerm],
                    ['like', 'surname', $this->searchTerm],
                    ['like', 'mobile', $this->searchTerm],
                    ['like', 'tm', $this->searchTerm],
                    ['like', 'acc_rej', $this->searchTerm],
                    ['like', 'outcome', $this->searchTerm],
                    ['like', 'packs_out', $this->searchTerm]
                ]);
        } catch (Exception $e) {
            $status = false;
        }
        return $status;
    }
    /**
     * @return yii\db\Query 
     */
    public function getQueryInstance()
    {
        return $this->queryInstance;
    }
    public function getResults()
    {
        return $this->queryInstance->all();
    }

} 