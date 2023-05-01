<?php
namespace app\models;

use Yii;
use yii\base\Model;

class SignupForm extends Model
{
    public $username;
    public $password;
    public $firstname;
    public $lastname;

    public function rules()
    {
        return [
            [['username', 'password', 'firstname', 'lastname'], 'required'],
            [['username', 'password', 'firstname', 'lastname'], 'string', 'max' => 255],
            [['username'], 'unique', 'targetClass' => User::className(), 'message' => 'This username has already been taken.'],
        ];
    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->password = md5($this->password);
        $user->firstname = $this->firstname;
        $user->lastname = $this->lastname;

        return $user->save() ? $user : null;
    }
}