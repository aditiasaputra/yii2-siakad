<?php

namespace backend\models;

use yii\base\Model;
use common\models\Lecture;
use common\models\User;
use Yii;

class LectureForm extends Model
{
    public $lecture;
    public $user;

    public function __construct(Lecture $lecture = null, $config = [])
    {
        $this->lecture = $lecture ?: new Lecture();
        $this->user = $this->lecture->user ?? new User(['scenario' => 'lecture']);
        parent::__construct($config);
    }

    public function rules()
    {
        return array_merge(
            $this->user->rules(),
            $this->lecture->rules()
        );
    }

    public function load($data, $formName = null)
    {
        return $this->user->load($data) && $this->lecture->load($data);
    }

    public function validate()
    {
        return $this->user->validate() & $this->lecture->validate();
    }

    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!$this->user->save(false)) {
                $transaction->rollBack();
                return false;
            }

            $this->lecture->user_id = $this->user->id;
            if (!$this->lecture->save(false)) {
                $transaction->rollBack();
                return false;
            }

            $transaction->commit();
            return true;

        } catch (\Throwable $e) {
            $transaction->rollBack();
            Yii::error($e->getMessage(), __METHOD__);
            return false;
        }
    }
}
