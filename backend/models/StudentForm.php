<?php

namespace backend\models;

use yii\base\Model;
use common\models\Student;
use common\models\User;
use Yii;

class StudentForm extends Model
{
    public $student;
    public $user;

    public function __construct(Student $student = null, $config = [])
    {
        $this->student = $student ?: new Student();
        $this->user = $this->student->user ?? new User(['scenario' => 'student']);
        parent::__construct($config);
    }

    public function rules()
    {
        return array_merge(
            $this->user->rules(),
            $this->student->rules()
        );
    }

    public function load($data, $formName = null)
    {
        return $this->user->load($data) && $this->student->load($data);
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        $valid = parent::validate($attributeNames, $clearErrors);

        $valid = $this->user->validate() && $valid;
        $valid = $this->student->validate() && $valid;

        return $valid;
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

            $this->student->user_id = $this->user->id;
            if (!$this->student->save(false)) {
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
