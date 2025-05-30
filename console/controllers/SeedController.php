<?php

namespace console\controllers;

use Yii;
use Faker\Factory;
use common\models\User;
use yii\console\Controller;

class SeedController extends Controller
{
    public $defaultAction = 'main';

    public function actionMain()
    {
        $this->user();
    }

    private function user()
    {
        $faker = Factory::create();

        // Truncate table
        Yii::$app->db->createCommand()->truncateTable(User::tableName())->execute();

        echo "Seeding users...\n";

        // 1. Administrator
        $admin = new User();
        $admin->username = 'administrator';
        $admin->email = 'admin@admin.com';
        $admin->setPassword('admin123');
        $admin->generateAuthKey();
        $admin->status = User::STATUS_ACTIVE;
        $admin->role_id = 1;
        $admin->created_at = time();
        $admin->updated_at = time();
        if (!$admin->save()) {
            print_r($admin->getErrors());
        }

        // 2. Random users
        for ($i = 0; $i < 24; $i++) {
            $user = new User();
            $user->username = $faker->userName;
            $user->email = $faker->unique()->safeEmail;
            $user->setPassword('user123'); // default password
            $user->generateAuthKey();
            $user->status = User::STATUS_ACTIVE;
            $user->created_at = time();
            $user->updated_at = time();
            if (!$user->save()) {
                print_r($user->getErrors());
            }
        }

        echo "User has been seed.\n";
    }
}