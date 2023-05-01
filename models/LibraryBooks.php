<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_library_books}}".
 *
 * @property int $id
 * @property int $library_id
 * @property string $name
 * @property string $description
 * @property int $creator_id
 * @property string $created_date
 *
 * @property Library $library
 */
class LibraryBooks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tbl_library_books}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['library_id', 'name', 'description', 'creator_id'], 'required'],
            [['library_id', 'creator_id'], 'integer'],
            [['created_date'], 'safe'],
            [['name', 'description'], 'string', 'max' => 255],
            [['library_id'], 'exist', 'skipOnError' => true, 'targetClass' => Library::class, 'targetAttribute' => ['library_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'library_id' => Yii::t('app', 'Library ID'),
            'name' => 'Name',
            'description' => 'Description',
            'creator_id' => 'Creator ID',
            'created_date' => 'Created Date',
        ];
    }

    /**
     * Gets query for [[Library]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLibrary()
    {
        return $this->hasOne(Library::class, ['id' => 'library_id']);
    }
}
