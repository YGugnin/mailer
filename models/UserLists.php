<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_lists".
 *
 * @property integer $user_id
 * @property integer $list_id
 *
 * @property Lists $list
 * @property Users $user
 */
class UserLists extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_lists';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'list_id'], 'required'],
            [['user_id', 'list_id'], 'integer'],
            [['user_id', 'list_id'], 'unique', 'targetAttribute' => ['user_id', 'list_id'], 'message' => 'The combination of User ID and List ID has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'list_id' => 'List ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getList()
    {
        return $this->hasOne(Lists::className(), ['id' => 'list_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
