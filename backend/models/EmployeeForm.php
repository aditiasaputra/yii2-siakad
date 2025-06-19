<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\Employee;
use common\models\User;

class EmployeeForm extends Model
{
    public User $user;
    public Employee $employee;

    public function __construct(Employee $employee = null, $config = [])
    {
        $this->employee = $employee ?: new Employee();
        $this->user = $this->employee->user ?? new User(['scenario' => 'employee']);

        parent::__construct($config);
    }

    public function rules(): array
    {
        return array_merge(
            $this->user->rules(),
            $this->employee->rules()
        );
    }

    public function load($data, $formName = null): bool
    {
        $userLoaded = $this->user->load($data);
        $employeeLoaded = $this->employee->load($data);
        return $userLoaded && $employeeLoaded;
    }

    public function validate($attributeNames = null, $clearErrors = true): bool
    {
        $parentValid = parent::validate($attributeNames, $clearErrors);
        $userValid = $this->user->validate($attributeNames, $clearErrors);
        $employeeValid = $this->employee->validate($attributeNames, $clearErrors);

        return $parentValid && $userValid && $employeeValid;
    }

    public function save(): bool
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

    public function __get($name)
    {
        if ($name === 'password') {
            return $this->user->password;
        }
    }

    public function __set($name, $value)
    {
        if ($name === 'password') {
            $this->user->password = $value;
            return;
        }
    }

    public function formName(): string
    {
        return '';
    }
}
