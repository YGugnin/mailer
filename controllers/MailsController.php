<?php

namespace app\controllers;

use app\models\Lists;
use app\models\SendLog;
use app\models\SendLogSearch;
use app\models\UserLists;
use app\models\Users;
use Yii;
use app\models\Mails;
use app\models\MailsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\User;

/**
 * MailsController implements the CRUD actions for Mails model.
 */
class MailsController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Mails models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Mails model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new SendLogSearch();
        $dataProvider = $searchModel->search(['mail_id' => $id]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Mails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Mails();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->send($model);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the Mails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mails::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function send($model){
        $list_id = $model->list_id;
        $records = UserLists::find()->joinwith('user')->where(['=','list_id', $list_id])->asArray()->all();

        $content = $this->renderPartial('layout', ['content' => $model->body]);

        $users = [];

        foreach($records as $record){
            $users[$record['user']['id']] = $record['user']['email'];
        }

        if($model->send_as_copy){
            $result = $this->sendMail(implode(', ', $users), $model->subject,$content);
            foreach($users as $user_id => $user){
                $this->saveResult($model->id, $user_id, $result );
            }
        } else {
            foreach($users as $user_id => $user){
                $result = $this->sendMail($user, $model->subject,$content);
                $this->saveResult($model->id, $user_id, $result );
            }
        }
    }

    private function sendMail($to , $subject , $message){
        $headers  = 'MIME-Version: 1.0' . "\r\n";
    	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        return (int)mail($to , $subject , $message, $headers);
    }

    private function saveResult($mail_id, $user_id, $result){
        $model = new SendLog();
        $model->user_id = $user_id;
        $model->mail_id = $mail_id;
        $model->success = $result;
        $model->save();
    }
}
