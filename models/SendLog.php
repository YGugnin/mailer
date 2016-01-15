<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "send_log".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $mail_id
 * @property string $send_time
 * @property integer $success
 *
 * @property Mails $mail
 * @property Users $user
 */
class SendLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'send_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'mail_id', 'success'], 'required'],
            [['user_id', 'mail_id', 'success'], 'integer'],
            [['send_time'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User',
            'mail_id' => 'Mail',
            'send_time' => 'Sent',
            'success' => 'Success',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMail()
    {
        return $this->hasOne(Mails::className(), ['id' => 'mail_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
