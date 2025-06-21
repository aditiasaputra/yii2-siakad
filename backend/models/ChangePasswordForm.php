<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;

class ChangePasswordForm extends Model
{
    public $id, $new_password, $repeat_password;

    private $_user;

    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['new_password', 'repeat_password'], 'required'],
            [['new_password', 'repeat_password'], 'string', 'min' => 6],
            ['repeat_password', 'compare', 'compareAttribute' => 'new_password', 'message' => 'Password baru tidak cocok.'],
        ];
    }

    public function changePassword()
    {
        $user = $this->getUser();
        $user->setPassword($this->new_password);
        $user->generateAuthKey();
        return $user->save(false);
    }

    /**
     * Get the user based on the id
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findOne($this->id);
        }
        return $this->_user;
    }
}
