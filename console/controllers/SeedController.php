<?php

namespace console\controllers;

use Yii;
use Faker\Factory;
use common\models\Lecture;
use common\models\Student;
use common\models\User;
use yii\console\Controller;

class SeedController extends Controller
{
    public $defaultAction = 'main';

    public function actionMain()
    {
        $this->seedData();
    }

    private function seedData()
    {
        $faker = Factory::create('id_ID');

        // Truncate all related tables
        Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS = 0')->execute();

        Yii::$app->db->createCommand()->truncateTable(Student::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(Lecture::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(User::tableName())->execute();

        Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS = 1')->execute();


        echo "Seeding users, students, and lectures...\n";

        $avatars = ['avatar.png', 'avatar2.png', 'avatar3.png', 'avatar4.png', 'avatar5.png'];

        // 1. Administrator
        $admin = new User();
        $admin->name = 'Administrator';
        $admin->username = 'administrator';
        $admin->email = 'admin@admin.com';
        $admin->personal_id = rand(100000000000000, 1000000000000000);
        $admin->family_id = rand(100000000000000, 1000000000000000);
        $admin->image = 'img/' . $avatars[array_rand($avatars)];
        $admin->birth_date = $faker->date('Y-m-d', '-20 years');
        $admin->address = $faker->address;
        $admin->phone = '08' . rand(111, 999) . rand(1000000, 9999999);
        $admin->setPassword('admin123');
        $admin->generateAuthKey();
        $admin->status = User::STATUS_ACTIVE;
        $admin->role_id = 1; // Admin role
        $admin->gender = rand(0, 1);
        if (!$admin->save()) {
            print_r($admin->getErrors());
        }

        // 2. 12 Mahasiswa (Students)
        for ($i = 1; $i <= 12; $i++) {
            $user = new User();
            $user->name = $faker->name;
            $user->username = $faker->unique()->userName;
            $user->email = $faker->unique()->safeEmail;
            $user->personal_id = rand(100000000000000, 1000000000000000);
            $user->family_id = rand(100000000000000, 1000000000000000);
            $user->image = 'img/' . $avatars[array_rand($avatars)];
            $user->birth_date = $faker->date('Y-m-d', '-22 years');
            $user->phone = '08' . rand(111, 999) . rand(1000000, 9999999);
            $user->address = $faker->address;
            $user->setPassword('user123');
            $user->generateAuthKey();
            $user->status = User::STATUS_ACTIVE;
            $user->role_id = 5; // Student role
            $user->gender = rand(0, 1);

            if ($user->save()) {
                $student = new Student();
                $student->user_id = $user->id;
                $student->student_id = 'NIM' . str_pad($i, 5, '0', STR_PAD_LEFT);
                $student->created_at = date('Y-m-d H:i:s');
                $student->updated_at = date('Y-m-d H:i:s');
                if (!$student->save()) {
                    echo "Student Gagal Disimpan: ";
                    print_r($student->getErrors());
                }
            } else {
                echo "User Mahasiswa Gagal: ";
                print_r($user->getErrors());
            }
        }

        // 3. 12 Dosen (Lectures)
        for ($i = 1; $i <= 12; $i++) {
            $user = new User();
            $user->name = $faker->name;
            $user->username = $faker->unique()->userName;
            $user->email = $faker->unique()->safeEmail;
            $user->personal_id = rand(100000000000000, 1000000000000000);
            $user->family_id = rand(100000000000000, 1000000000000000);
            $user->image = 'img/' . $avatars[array_rand($avatars)];
            $user->birth_date = $faker->date('Y-m-d', '-30 years');
            $user->phone = '08' . rand(111, 999) . rand(1000000, 9999999);
            $user->address = $faker->address;
            $user->setPassword('user123');
            $user->generateAuthKey();
            $user->status = User::STATUS_ACTIVE;
            $user->role_id = 4; // Lecturer role
            $user->gender = rand(0, 1);

            if ($user->save()) {
                $lecture = new Lecture();
                $lecture->user_id = $user->id;
                $lecture->lecture_nationality_number = 'NIDN' . str_pad($i, 3, '0', STR_PAD_LEFT);
                $lecture->employee_id = 'EMP' . str_pad($i, 3, '0', STR_PAD_LEFT);
                $lecture->created_at = date('Y-m-d H:i:s');
                $lecture->updated_at = date('Y-m-d H:i:s');
                if (!$lecture->save()) {
                    echo "Lecture Gagal Disimpan: ";
                    print_r($lecture->getErrors());
                }
            } else {
                echo "User Dosen Gagal: ";
                print_r($user->getErrors());
            }
        }

        echo "✅ Seed selesai.\n";
        Yii::$app->cache->flush();
    }
}
