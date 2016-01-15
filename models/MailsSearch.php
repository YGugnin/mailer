<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Mails;

/**
 * MailsSearch represents the model behind the search form about `app\models\Mails`.
 */
class MailsSearch extends Mails
{
    public $list;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'list_id', 'send_as_copy'], 'integer'],
            [['subject', 'body', 'created', 'list'], 'safe'],
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
        $query = Mails::find();

        $query->joinWith(['list']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['list'] = [
            'asc' => [Lists::tableName().'.name' => SORT_ASC],
            'desc' => [Lists::tableName().'.name' => SORT_DESC],
        ];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'send_as_copy' => $this->send_as_copy,
            'created' => $this->created,

        ]);
        $query->andFilterWhere(['like', Lists::tableName().'.name', $this->list]);

        $query->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'body', $this->body]);

        return $dataProvider;
    }
}
