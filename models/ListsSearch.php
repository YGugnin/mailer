<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Lists;

/**
 * ListsSearch represents the model behind the search form about `app\models\Lists`.
 */
class ListsSearch extends Lists
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['users_count'], 'safe'],
            [['name', 'last_sent', 'created', 'modified'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Lists::find();

        $query->select($this->tableName().'.*, COUNT('.UserLists::tableName().'.user_id) AS users_count');
        $query->leftJoin(UserLists::tableName(), UserLists::tableName().'.list_id = '.$this->tableName().'.id');
        $query->groupBy([$this->tableName().'.id']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'DATE(last_sent)' => $this->last_sent,
            'DATE(created)' => $this->created,
            'DATE(modified)' => $this->modified,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'name',
                'last_sent',
                'created',
                'modified',
                'users_count' => [
                    'asc' => [
                        'users_count' => SORT_ASC
                    ],
                    'desc' => [
                        'users_count' => SORT_DESC
                    ],
                    'label' => 'Parent Name',
                    'default' => SORT_ASC
                ],

                //'country_id'
            ]
        ]);

        return $dataProvider;
    }
}
