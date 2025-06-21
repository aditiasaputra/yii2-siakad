<?php

namespace console\controllers;

use Yii;
use Faker\Factory;
use common\models\User;
use common\models\Lecture;
use common\models\Student;
use common\models\Employee;
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

        Yii::$app->db->createCommand()->truncateTable(User::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(Student::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(Employee::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(Lecture::tableName())->execute();

        echo "\nSeeding users, employee, students, and lectures...\n";

        $avatars = ['avatar.png', 'avatar2.png', 'avatar3.png', 'avatar4.png', 'avatar5.png'];

        // 1. Administrator
        $admin = new User();
        $admin->name = 'Administrator';
        $admin->username = 'administrator';
        $admin->email = 'admin@admin.com';
        $admin->personal_id = rand(100000000000000, 999999999999999);
        $admin->family_id = rand(100000000000000, 999999999999999);
        $admin->image = 'img/' . $avatars[array_rand($avatars)];
        $admin->birth_date = $faker->date('Y-m-d', '-30 years');
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
            $user->personal_id = rand(100000000000000, 999999999999999);
            $user->family_id = rand(100000000000000, 999999999999999);
            $user->image = 'img/' . $avatars[array_rand($avatars)];
            $user->birth_date = $faker->date('Y-m-d', '-22 years');
            $user->address = $faker->address;
            $user->phone = '08' . rand(111, 999) . rand(1000000, 9999999);
            $user->setPassword('user123');
            $user->generateAuthKey();
            $user->status = User::STATUS_ACTIVE;
            $user->role_id = 5; // Student
            $user->gender = rand(0, 1);

            if ($user->save()) {
                $student = new Student();
                $student->user_id = $user->id;
                $student->student_nationality_number = 'NIM' . str_pad($i, 5, '0', STR_PAD_LEFT);
                $student->created_at = date('Y-m-d H:i:s');
                $student->updated_at = date('Y-m-d H:i:s');
                if (!$student->save()) {
                    echo "Student gagal disimpan:\n";
                    print_r($student->getErrors());
                }
            } else {
                echo "User Mahasiswa gagal disimpan:\n";
                print_r($user->getErrors());
            }
        }

        // 3. 12 Dosen (Lectures)
        for ($i = 1; $i <= 12; $i++) {
            $user = new User();
            $user->name = $faker->name;
            $user->username = $faker->unique()->userName;
            $user->email = $faker->unique()->safeEmail;
            $user->personal_id = rand(100000000000000, 999999999999999);
            $user->family_id = rand(100000000000000, 999999999999999);
            $user->image = 'img/' . $avatars[array_rand($avatars)];
            $user->birth_date = $faker->date('Y-m-d', '-30 years');
            $user->address = $faker->address;
            $user->phone = '08' . rand(111, 999) . rand(1000000, 9999999);
            $user->setPassword('user123');
            $user->generateAuthKey();
            $user->status = User::STATUS_ACTIVE;
            $user->role_id = 4; // Lecturer
            $user->gender = rand(0, 1);

            if ($user->save()) {
                $employee = new Employee();
                $employee->user_id = $user->id;
                $employee->employee_number = 'EMP' . str_pad($i, 4, '0', STR_PAD_LEFT);
                $employee->account_name = $user->name;
                $employee->account_number = '001' . rand(10000000, 99999999);
                $employee->branch_name = 'Cabang ' . $faker->city;

                if ($employee->save()) {
                    $lecture = new Lecture();
                    $lecture->employee_id = $employee->id;
                    $lecture->lecture_nationality_number = (int) str_pad($i, 4, '0', STR_PAD_LEFT);
                    $lecture->competence = $faker->jobTitle;
                    $lecture->field_of_study = $faker->word;
                    $lecture->is_match_field = rand(0, 1);
                    $lecture->certificate_date = date('Y-m-d');
                    $lecture->created_at = date('Y-m-d H:i:s');
                    $lecture->updated_at = date('Y-m-d H:i:s');

                    if (!$lecture->save()) {
                        echo "Lecture gagal disimpan:\n";
                        print_r($lecture->getErrors());
                    }
                } else {
                    echo "Employee gagal disimpan:\n";
                    print_r($employee->getErrors());
                }
            } else {
                echo "User Dosen gagal disimpan:\n";
                print_r($user->getErrors());
            }
        }

        $this->seedSql();
        Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS = 1')->execute();

        echo "\n✅ Seed selesai.\n";
        Yii::$app->cache->flush();
    }

    private function seedSql()
    {
        $path = Yii::getAlias('@console/sql');
        $sqlFiles = glob($path . '/*.sql');
        sort($sqlFiles, SORT_DESC);

        if (empty($sqlFiles)) {
            echo "\n❗ Tidak ada file .sql ditemukan di folder: $path\n";
            return;
        }

        foreach ($sqlFiles as $sqlFile) {
            echo "\n⚙️  Menjalankan: " . basename($sqlFile) . "\n";

            try {
                $sql = file_get_contents($sqlFile);
                Yii::$app->db->createCommand($sql)->execute();
                echo "✅ Sukses: " . basename($sqlFile) . "\n";
            } catch (\yii\db\Exception $e) {
                echo "❌ Error pada file: " . basename($sqlFile) . "\n";
                echo "   Pesan: " . $e->getMessage() . "\n";
            }
        }
    }
}
