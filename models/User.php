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
 * @property string|null $auth_key
 * @property string|null $access_token
 *
 * @property UsersBooks[] $tblUsersBooks
 */
class User extends \yii\db\ActiveRecord
{
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
            [['firstname', 'lastname', 'password'], 'string', 'max' => 255],
            [['username'], 'string', 'max' => 50],
            [['auth_key', 'access_token'], 'string', 'max' => 32],
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
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
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


}
