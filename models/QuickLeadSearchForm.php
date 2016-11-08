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
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['searchTerm'], 'required'],
            [['searchTerm'], 'safe'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'searchTerm'=>'Name'
        ];
    }
    public function search(){
        return MoneyActiveClaims::find()
            ->andFilterWhere([
                'or',
                ['like', 'title', $this->searchTerm],
                ['like', 'firstname', $this->searchTerm],
                ['like', 'surname', $this->searchTerm],
            ])
            ->all();
    }
} 