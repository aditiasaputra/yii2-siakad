<?php

namespace backend\models;

use yii\base\Model;
use common\models\Employee;
use common\models\User;
use Yii;

class EmployeeForm extends Model
{
    public $user, $employee;

    public function __construct(Employee $employee = null, $config = [])
    {
        $this->employee = $employee ?: new Employee();
        $this->user = $this->employee->user ?? new User(['scenario' => 'employee']);
        parent::__construct($config);
    }

    public function rules()
    {
        return array_merge(
            $this->user->rules(),
            $this->employee->rules()
        );
    }

    public function load($data, $formName = null)
    {
        return $this->user->load($data) && $this->employee->load($data);
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        $valid = parent::validate($attributeNames, $clearErrors);

        $valid = $this->user->validate() && $valid;
        $valid = $this->employee->validate() && $valid;

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

            $this->employee->user_id = $this->user->id;
            if (!$this->employee->save(false)) {
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
