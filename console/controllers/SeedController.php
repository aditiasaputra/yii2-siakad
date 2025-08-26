<?php

namespace console\controllers;

use backend\models\Faculty;
use Yii;
use Faker\Factory;
use common\models\User;
use common\models\Lecture;
use common\models\Student;
use common\models\Employee;
use yii\console\Controller;
use backend\models\University;

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

        Yii::$app->db->createCommand()->truncateTable(University::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(User::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(Student::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(Employee::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(Lecture::tableName())->execute();

        echo "\nSeeding university, users, employee, students, and lectures...\n";

        $avatars = ['avatar.png', 'avatar2.png', 'avatar3.png', 'avatar4.png', 'avatar5.png'];

        // 1. Administrator
        $admin = new User();
        $admin->name = 'Administrator';
        $admin->username = 'administrator';
        $admin->email = 'admin@admin.com';
        $admin->personal_id = rand(100000000000000, 999999999999999);
        $admin->family_id = rand(100000000000000, 999999999999999);
        $admin->religion_id = rand(1, 6);
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
            $user->religion_id = rand(1, 6);
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
            $user->religion_id = rand(1, 6);
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

        // $this->seedSql();
        $this->seedUniversity();
        $this->seedFaculties();
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
    
    private function seedUniversity(): void
    {
        // Create sample university data
        $faker = Factory::create('id_ID');
        
        $university = new University();
        
        $university->unit_code = 'UGM';
        $university->unit_name = 'Universitas Gadjah Mada';
        $university->unit_name_en = 'Gadjah Mada University';
        $university->abbreviation = 'UGM';
        $university->address = 'Jalan Sosio Yustisia No. 1, Bulaksumur, Caturtunggal, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55281';
        $university->work_unit = 'Perguruan Tinggi Negeri';
        $university->phone = '+62-274-588688';
        $university->accreditation = University::ACCREDITATION_UNGGUL;
        $university->accreditation_sk_number = 'SK/BAN-PT/Ak-PPJ/PT/XII/2019';
        $university->establishment_permit_number = 'SK Menteri Pendidikan No. 31 Tahun 1949';
        $university->rector = 'Prof. Dr. Ova Emilia, M.Med.Ed., Sp.OG(K)., Ph.D';
        $university->vice_rector_1 = 'Prof. Dr. Ir. Suratman, M.Sc.';
        $university->vice_rector_2 = 'Prof. Dr. drg. Ika Dewi Ana, S.U.';
        $university->vice_rector_3 = 'Dr. Ir. Nizam, M.Sc.';
        $university->website = 'https://www.ugm.ac.id';
        $university->email = 'humas@ugm.ac.id';
        $university->logo = null;
        $university->created_at = time();
        $university->updated_at = time();
        $university->created_by = 1;
        $university->updated_by = 1;

        if ($university->save()) {
            echo "✅ University seeded successfully: {$university->unit_name}\n";
        } else {
            echo "❌ Failed to seed university\n";
            print_r($university->getErrors());
        }
    }

    private function seedFaculties(): void
    {
        $faculties = [
            [
                'unit_code' => 'FK',
                'unit_name' => 'Fakultas Kedokteran',
                'unit_name_en' => 'Faculty of Medicine',
                'abbreviation' => 'FK',
                'address' => 'Jl. Farmako, Sekip Utara, Yogyakarta 55281',
                'work_unit' => 'Fakultas',
                'phone' => '0274-6492492',
                'dean' => 'Prof. dr. Dra. Yodi Mahendradhata, M.Sc., Ph.D.',
                'vice_dean_1' => 'dr. Mora Claramita, MHPE., Ph.D.',
                'vice_dean_2' => 'dr. Carla Nunes Oliveira, M.Med.Ed., Ph.D.',
                'vice_dean_3' => 'dr. Dwi Pudjonarko, M.Kes.',
            ],
            [
                'unit_code' => 'FT',
                'unit_name' => 'Fakultas Teknik',
                'unit_name_en' => 'Faculty of Engineering',
                'abbreviation' => 'FT',
                'address' => 'Jl. Grafika No.2, Yogyakarta 55281',
                'work_unit' => 'Fakultas',
                'phone' => '0274-902102',
                'dean' => 'Prof. Ir. Nizam, M.Sc., D.Eng.',
                'vice_dean_1' => 'Prof. Dr. Ir. Subyakto, M.S.',
                'vice_dean_2' => 'Dr. Ir. Sigit Pranowo Hadiwardoyo, M.Eng.',
                'vice_dean_3' => 'Ir. Rini Dharmastiti, M.Eng., Ph.D.',
            ],
            [
                'unit_code' => 'FMIPA',
                'unit_name' => 'Fakultas Matematika dan Ilmu Pengetahuan Alam',
                'unit_name_en' => 'Faculty of Mathematics and Natural Sciences',
                'abbreviation' => 'FMIPA',
                'address' => 'Sekip Utara BLS 21, Yogyakarta 55281',
                'work_unit' => 'Fakultas',
                'phone' => '0274-6492599',
                'dean' => 'Dr. Rer.nat. Ahmad Kusumaatmadja',
                'vice_dean_1' => 'Dr. Eng. Wei Handayani, S.Si., M.Si.',
                'vice_dean_2' => 'Prof. Dr. Retno Dwi Suyanti, M.Si.',
                'vice_dean_3' => 'Drs. Bambang Supriyadi, M.Si.',
            ],
            [
                'unit_code' => 'FEB',
                'unit_name' => 'Fakultas Ekonomika dan Bisnis',
                'unit_name_en' => 'Faculty of Economics and Business',
                'abbreviation' => 'FEB',
                'address' => 'Jl. Sosio Humaniora No.1, Bulaksumur, Yogyakarta 55281',
                'work_unit' => 'Fakultas',
                'phone' => '0274-548510',
                'dean' => 'Prof. Dr. Eko Suwardi, M.Sc.',
                'vice_dean_1' => 'Dr. Nurul Indarti, Siviløkonom, Cand.Merc.',
                'vice_dean_2' => 'Sahid Susilo Nugroho, M.Sc., Ph.D.',
                'vice_dean_3' => 'Prof. Jogiyanto Hartono, M.B.A., Ph.D.',
            ],
            [
                'unit_code' => 'FH',
                'unit_name' => 'Fakultas Hukum',
                'unit_name_en' => 'Faculty of Law',
                'abbreviation' => 'FH',
                'address' => 'Jl. Sosio Yustisia No.1, Bulaksumur, Yogyakarta 55281',
                'work_unit' => 'Fakultas',
                'phone' => '0274-512781',
                'dean' => 'Dr. Sigit Riyanto, S.H., LL.M.',
                'vice_dean_1' => 'Prof. Dr. Marsudi Triatmodjo, S.H., LL.M.',
                'vice_dean_2' => 'Sekar Anggun Gading P., S.H., LL.M., Ph.D.',
                'vice_dean_3' => 'Dr. Ujang Bahar, S.H., M.Hum.',
            ],
            [
                'unit_code' => 'FISIPOL',
                'unit_name' => 'Fakultas Ilmu Sosial dan Ilmu Politik',
                'unit_name_en' => 'Faculty of Social and Political Sciences',
                'abbreviation' => 'Fisipol',
                'address' => 'Jl. Sosio Yustisia No.2, Bulaksumur, Yogyakarta 55281',
                'work_unit' => 'Fakultas',
                'phone' => '0274-563362',
                'dean' => 'Dr. Wawan Mas\'udi, M.P.A.',
                'vice_dean_1' => 'Hermin Indah Wahyuni, S.Sos., M.A., Ph.D.',
                'vice_dean_2' => 'Prof. Dr. Pratikno, M.Soc.Sc.',
                'vice_dean_3' => 'Drs. Djoko Soerjo, M.Si.',
            ],
            [
                'unit_code' => 'FIB',
                'unit_name' => 'Fakultas Ilmu Budaya',
                'unit_name_en' => 'Faculty of Cultural Sciences',
                'abbreviation' => 'FIB',
                'address' => 'Jl. Sosio Humaniora No.2, Bulaksumur, Yogyakarta 55281',
                'work_unit' => 'Fakultas',
                'phone' => '0274-513096',
                'dean' => 'Dr. Setiadi, M.Hum.',
                'vice_dean_1' => 'Prof. Dr. Heddy Shri Ahimsa-Putra, M.A., M.Phil.',
                'vice_dean_2' => 'Drs. Harkristuti Harkrisnowo, M.A., Ph.D.',
                'vice_dean_3' => 'Dra. Suzie Handayani, M.A.',
            ],
            [
                'unit_code' => 'FP',
                'unit_name' => 'Fakultas Pertanian',
                'unit_name_en' => 'Faculty of Agriculture',
                'abbreviation' => 'FP',
                'address' => 'Jl. Flora No.1, Bulaksumur, Yogyakarta 55281',
                'work_unit' => 'Fakultas',
                'phone' => '0274-523926',
                'dean' => 'Prof. Dr. Ir. Jamhari, M.A.',
                'vice_dean_1' => 'Prof. Dr. Ir. Sunarru Samsi Hariadi, M.Sc.',
                'vice_dean_2' => 'Prof. Dr. Ir. Edi Santosa, M.Sc.',
                'vice_dean_3' => 'Dr. Ir. Lies Mira Yusiati, S.U.',
            ],
            [
                'unit_code' => 'FKH',
                'unit_name' => 'Fakultas Kedokteran Hewan',
                'unit_name_en' => 'Faculty of Veterinary Medicine',
                'abbreviation' => 'FKH',
                'address' => 'Jl. Fauna No.2, Karangmalang, Yogyakarta 55281',
                'work_unit' => 'Fakultas',
                'phone' => '0274-560862',
                'dean' => 'Prof. Dr. drh. Bambang Pontjo Priosoeryanto, M.P.',
                'vice_dean_1' => 'Prof. Dr. drh. Sitarina Widyarini, M.P.',
                'vice_dean_2' => 'Dr. drh. Yudhi Kurniawan Wibowo, M.P.',
                'vice_dean_3' => 'drh. Tri Akhdiyanto, M.P.',
            ],
            [
                'unit_code' => 'FKKMK',
                'unit_name' => 'Fakultas Kedokteran, Kesehatan Masyarakat, dan Keperawatan',
                'unit_name_en' => 'Faculty of Medicine, Public Health and Nursing',
                'abbreviation' => 'FKKMK',
                'address' => 'Jl. Farmako, Sekip Utara, Yogyakarta 55281',
                'work_unit' => 'Fakultas',
                'phone' => '0274-6492492',
                'dean' => 'Dr. dr. Laksono Trisnantoro, M.Sc., Ph.D.',
                'vice_dean_1' => 'Prof. dr. Ova Emilia, M.Med.Ed., Sp.OG(K)., Ph.D.',
                'vice_dean_2' => 'Dr. dr. Andreasta Meliala, D.T.M.&H., M.Kes.',
                'vice_dean_3' => 'ns. Haryani, S.Kep., M.N.',
            ],
            [
                'unit_code' => 'FKG',
                'unit_name' => 'Fakultas Kedokteran Gigi',
                'unit_name_en' => 'Faculty of Dentistry',
                'abbreviation' => 'FKG',
                'address' => 'Jl. Denta No.1, Sekip Utara, Yogyakarta 55281',
                'work_unit' => 'Fakultas',
                'phone' => '0274-515307',
                'dean' => 'Prof. drg. Indah Listiana Kriswandini, Ph.D.',
                'vice_dean_1' => 'drg. Haryani, M.Kes., Sp.Perio.',
                'vice_dean_2' => 'drg. Mohammad Khursheed Alam, BDS., Ph.D.',
                'vice_dean_3' => 'drg. Siti Rusdiana Puspa Dewi, M.Kes., Sp.KGA.',
            ],
            [
                'unit_code' => 'FF',
                'unit_name' => 'Fakultas Farmasi',
                'unit_name_en' => 'Faculty of Pharmacy',
                'abbreviation' => 'FF',
                'address' => 'Sekip Utara, Yogyakarta 55281',
                'work_unit' => 'Fakultas',
                'phone' => '0274-543120',
                'dean' => 'Prof. Dr. Agung Endro Nugroho, M.Si., Apt.',
                'vice_dean_1' => 'Prof. Dr. Zullies Ikawati, Apt.',
                'vice_dean_2' => 'Dr. Yosi Bayu Murti, M.Si., Apt.',
                'vice_dean_3' => 'Dra. Sudibyo Martono, M.S., Apt.',
            ],
            [
                'unit_code' => 'FGD',
                'unit_name' => 'Fakultas Geografi',
                'unit_name_en' => 'Faculty of Geography',
                'abbreviation' => 'FGD',
                'address' => 'Sekip Utara, Bulaksumur, Yogyakarta 55281',
                'work_unit' => 'Fakultas',
                'phone' => '0274-6492343',
                'dean' => 'Dr. Hartono, M.Si.',
                'vice_dean_1' => 'Dr. Dyah Rahmawati Hizbaron, M.Si.',
                'vice_dean_2' => 'Drs. R. Rijanta, M.Sc., Ph.D.',
                'vice_dean_3' => 'Ahmad Cahyadi, S.Si., M.Sc., Ph.D.',
            ],
            [
                'unit_code' => 'FPSI',
                'unit_name' => 'Fakultas Psikologi',
                'unit_name_en' => 'Faculty of Psychology',
                'abbreviation' => 'Fpsi',
                'address' => 'Jl. Sosio Humaniora, Bulaksumur, Yogyakarta 55281',
                'work_unit' => 'Fakultas',
                'phone' => '0274-550435',
                'dean' => 'Prof. Dr. Faturochman, M.A.',
                'vice_dean_1' => 'Dr. Diana Setiyawati, M.HSc., Psikolog',
                'vice_dean_2' => 'Neila Ramdhani, S.Psi., M.Si., M.A., Ph.D.',
                'vice_dean_3' => 'Dr. Rahmat Hidayat, M.Si., Psikolog',
            ],
            [
                'unit_code' => 'SV',
                'unit_name' => 'Sekolah Vokasi',
                'unit_name_en' => 'Vocational School',
                'abbreviation' => 'SV',
                'address' => 'Jl. Yacaranda, Sekip Unit IV, Yogyakarta 55281',
                'work_unit' => 'Sekolah Vokasi',
                'phone' => '0274-523037',
                'dean' => 'Prof. Dr. Ir. Djagal Wiseso Marseno, M.Agr.',
                'vice_dean_1' => 'Dr. Ir. Titi Candra Sunarti, M.Si.',
                'vice_dean_2' => 'Drs. Mardjuki, M.Si.',
                'vice_dean_3' => 'Dr. Hartrisari Hardjomidjojo, DEA.',
            ],
        ];

        
        foreach ($faculties as $facultyData) {
            $faculty = new Faculty();
            $faculty->attributes = $facultyData;
            $faculty->is_active = true;
            
            if (!$faculty->save()) {
                echo "Error saving faculty: " . $facultyData['unit_name'] . "\n";
                print_r($faculty->errors);
            }
        }

        echo "Seeded " . count($faculties) . " UGM faculties successfully.\n";
    }
}
