<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "lists".
 *
 * @property integer $id
 * @property string $name
 * @property string $last_sent
 * @property string $created
 * @property string $modified
 */
class Lists extends \yii\db\ActiveRecord
{
    public $users_count;
    public $users;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lists';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'unique'],
            [['users_count', 'users'], 'safe'],
            [['last_sent', 'created', 'modified'], 'safe'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'last_sent' => 'Last Sent',
            'created' => 'Created',
            'modified' => 'Modified',
            'users_count' => 'Count users',
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), [$this->tableName().'.users_count']);
    }


    public function getListCount(){
        return $this->hasMany(UserLists::className(), ["list_id" => "id"])->count();

    }
    public function getUsers(){
        return $this->hasMany(UserLists::className(), ['list_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes){
        \Yii::$app->db->createCommand()->delete(UserLists::tableName(), 'list_id = '.(int) $this->id)->execute();

        foreach ($this->users as $id) { //Write new values
            $model = new UserLists();
            $model->list_id = $this->id;
            $model->user_id = $id;
            $model->save();
        }
    }
}
