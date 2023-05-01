<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Library;
use app\models\LibraryBooks;
use app\models\UsersBooks;
use app\models\SignupForm;
use yii\helpers\Html;
use app\models\User;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['login', 'logout', 'signup'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup'],
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        // \yii\helpers\VarDumper::dump(Yii::$app->user->isGuest, 10, true);die;
        // $identity = \app\models\User::findOne(['username' => 'ppoghos']);
        // Yii::$app->user->login($identity, 3000000);
        
        
        // $userData = User::findOne(['username' => 'ppoghos']);
        // var_dump(Yii::$app->user->identity);die;
        // var_dump("Here we go");exit("Ashtaraki popoq");
        // $value = '';
        // if(!empty($_GET['test'])){
        //     $value = 'test';
        // }
        $value = !empty($_GET['test']) ? 'test' : '';
        return $this->render('index',['value'=>$value]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) { 
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
           // Yii::$app->session->setFlash('success', 'Login successful!');
            //return $this->render('dashboard', ['model' => $model]); 
            return $this->goBack();
        } 

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }


    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionDashboard() 
    {

       
        //var_dump(\app\models\User::tableName());

        $table = \app\models\User::tableName();
        $query = "SELECT * FROM {$table}";
        $result = Yii::$app->db->createCommand($query)->queryAll();
        $duration = 15;
        $userID = Yii::$app->user->id;

        if (Yii::$app->request->isPost) {
            $selectedBooks = Yii::$app->request->post('book');
            
            
            foreach ($selectedBooks as $bookID) {
                $book = LibraryBooks::findOne($bookID);
                $alreadyTaken = UsersBooks::find()->where(['user_id' => $userID, 'library_book_id' => $bookID])->all();
                if ($alreadyTaken) {
                    Yii::$app->session->setFlash('warning', 'The book "'.$book->name.'" is already taken.');
                } else {
                    $userBook = new UsersBooks();
                    $userBook->user_id = $userID;
                    $userBook->when_taken = date('Y-m-d');
                    $userBook->duration = $duration;
                    $userBook->library_book_id = $bookID;             
                    $userBook->save();
                }
            }
        }
        
        
        $libraries = Library::find()->all();
        $libraryList = \yii\helpers\ArrayHelper::map($libraries, 'id', 'name');
        $userBooks = UsersBooks::find()->where(['user_id' => Yii::$app->user->id])->all();

        return $this->render('dashboard', ['libraryList' => $libraryList, 'userBooks' => $userBooks]); 
    } 




    public function actionBooks()
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            $libraryId = $this->request->post('library_id');
            $books = LibraryBooks::find()->where(['library_id' => $libraryId])->all();

            return $this->renderAjax('books', ['books' => $books,]);   
        }
    }

    public function actionSignup()
    {
        $model = new SignupForm();
    
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->goHome();
        }
    
        return $this->render('signup', [
            'model' => $model,
        ]);
    }


    
    public function actionDecreaseDuration()
    {
        $userBooks = UsersBooks::find()->all();
        foreach ($userBooks as $userBook) {
            $userBook->duration--;
            $userBook->save();
        }
    }
     
    // public function actionSaveBooks()
    // {
    //     if (Yii::$app->request->isPost) {
    //         $selectedBooks = Yii::$app->request->post('book');
    
    //         foreach ($selectedBooks as $bookId) {
    //             $userBook = new UsersBooks();
    //             $userBook->user_id = 2;
    //             $userBook->when_taken = "2023-04-12"; //date('Y-m-d')
    //             $userBook->duration = 15;
    //             $userBook->library_book_id = $bookId;             
    //             $userBook->save();
    //         }

    //         Yii::$app->session->setFlash('success', 'Selected books have been saved successfully.');
    //         return $this->redirect(['dashboard']);
    //     }
    // }



}





