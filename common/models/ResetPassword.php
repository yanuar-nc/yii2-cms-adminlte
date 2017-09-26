<?php
namespace common\models;

use Yii;

class ResetPassword extends \yii\db\ActiveRecord
{

    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['newPassword', 'confirmPassword'], 'required', 'message' => '{attribute} tidak boleh kosong'],
        ];
    }


}
