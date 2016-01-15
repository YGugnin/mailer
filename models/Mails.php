<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mails".
 *
 * @property integer $id
 * @property string $subject
 * @property string $body
 * @property integer $list_id
 * @property integer $send_as_copy
 * @property string $created
 *
 * @property Lists $list
 */
class Mails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mails';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject', 'body', 'list_id', 'send_as_copy'], 'required'],
            [['body'], 'string'],
            [['list_id', 'send_as_copy'], 'integer'],
            [['created'], 'safe'],
            [['subject'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'Subject',
            'body' => 'Body',
            'list_id' => 'List',
            'send_as_copy' => 'Send As Copy',
            'created' => 'Created',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getList()
    {
        return $this->hasOne(Lists::className(), ['id' => 'list_id']);
    }
}
