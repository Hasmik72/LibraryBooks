<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_user}}".
 *
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string $username
 * @property string $password
 *
 * @property UsersBooks[] $tblUsersBooks
 */
class User1 extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;
    public $rawPassword;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tbl_user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname', 'username', 'password'], 'required'],
            [['firstname', 'lastname'], 'string', 'max' => 255],
            [['username'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 255],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'username' => 'Username',
            'password' => 'Password',
        ];
    }

    /**
     * Gets query for [[TblUsersBooks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsersBooks()
    {
        return $this->hasMany(UsersBooks::class, ['user_id' => 'id']);
    }

     /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return self::find(['username'=>$username]);
    }

/**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
        //return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
        // foreach (self::$users as $user) {
        //     if ($user['accessToken'] === $token) {
        //         return new static($user);
        //     }
        // }

        // return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }


    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function setPassword($password)
    {
        $this->password = \Yii::$app->security->generatePasswordHash($password);
        
    }

    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password);
        //return $this->password === $password;
    }

/**
     * Authentication
     * @return boolean
     */
     public function authenticate($username, $password) {
        $user = User::findOne(['username' => $username]);   
        $this->id = $user->id;
        Yii::$app->session->set('user.' . $this->id, true);
        $cookieName = 'userID';
        $cookieValue = $this->id;
        setcookie($cookieName, $cookieValue, strtotime('+30 days'));
        return ['result' => true];
    }

}


