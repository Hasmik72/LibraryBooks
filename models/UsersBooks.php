<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_users_books}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $library_book_id
 * @property string $when_taken
 * @property int $duration
 */
class UsersBooks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tbl_users_books}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'library_book_id', 'when_taken', 'duration'], 'required'],
            [['user_id', 'library_book_id', 'duration'], 'integer'],
            [['when_taken'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'library_book_id' => 'Library Book ID',
            'when_taken' => 'When Taken',
            'duration' => 'Duration',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getLibraryBook()
    {
        return $this->hasOne(LibraryBooks::class, ['id' => 'library_book_id']);
    }
}
