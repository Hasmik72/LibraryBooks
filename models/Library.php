<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_library}}".
 *
 * @property int $id
 * @property string $name
 * @property string $location
 * @property string $created_date
 * @property int $creator_id
 */
class Library extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tbl_library}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'location', 'creator_id'], 'required'],
            [['created_date'], 'safe'],
            [['creator_id'], 'integer'],
            [['name', 'location'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'location' => 'Location',
            'created_date' => 'Created Date',
            'creator_id' => 'Creator ID',
        ];
    }
}
