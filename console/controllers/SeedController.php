<?php

namespace console\controllers;

use backend\models\Faculty;
use backend\models\Concentration;
use backend\models\EducationLevel;
use backend\models\LectureSystem;
use backend\models\LectureRoom;
use backend\models\AcademicActivity;
use backend\models\AcademicCalendar;
use backend\models\ExternalUniversity;
use backend\models\Company;
use backend\models\CompanyContact;
use backend\models\GradeElement;
use backend\models\Job;
use backend\models\Income;
use backend\models\StudentStatus;
use backend\models\Transportation;
use backend\models\EmployeeType;
use backend\models\Rank;
use backend\models\FunctionalPosition;
use backend\models\StructuralPosition;
use backend\models\Country;
use backend\models\StudyProgram;
use backend\models\UniversityEducationLevel;
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

    public function actionEmployeeTypes()
    {
        $this->seedEmployeeTypes();
        echo "Seed Jenis Pegawai selesai.\n";
    }

    public function actionRanks()
    {
        $this->seedRanks();
        echo "Seed Golongan selesai.\n";
    }

    public function actionFunctionalPositions()
    {
        $this->seedFunctionalPositions();
        echo "Seed Jabatan Fungsional selesai.\n";
    }

    public function actionStructuralPositions()
    {
        $this->seedStructuralPositions();
        echo "Seed Jabatan Struktural selesai.\n";
    }

    public function actionCountries()
    {
        $this->seedCountries();
        echo "Seed Negara selesai.\n";
    }

    private function seedData()
    {
        $faker = Factory::create('id_ID');

        // Truncate all related tables
        Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS = 0')->execute();

        Yii::$app->db->createCommand()->truncateTable(Concentration::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(LectureRoom::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(AcademicActivity::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(AcademicCalendar::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(ExternalUniversity::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(Company::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(CompanyContact::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(GradeElement::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(Job::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(Income::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(StudentStatus::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(Transportation::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(EmployeeType::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(Rank::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(FunctionalPosition::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(StructuralPosition::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(Country::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(StudyProgram::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(EducationLevel::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(UniversityEducationLevel::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(LectureSystem::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(University::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(Faculty::tableName())->execute();
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
                    $lecture->field_of_study = $faker->randomElement([
                        'Teknik Informatika',
                        'Sistem Informasi',
                        'Matematika Terapan',
                        'Manajemen Pendidikan',
                        'Ilmu Komputer',
                    ]);
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
        $this->seedUniversity();
        $this->seedFaculties();
        $this->seedEducationLevels();
        $this->seedUniversityEducationLevels();
        $this->seedStudyPrograms();
        $this->seedLectureRooms();
        $this->seedAcademicActivities();
        $this->seedAcademicCalendars();
        $this->seedExternalUniversities();
        $this->seedCompanies();
        $this->seedCompanyContacts();
        $this->seedGradeElements();
        $this->seedJobs();
        $this->seedIncomes();
        $this->seedStudentStatuses();
        $this->seedTransportations();
        $this->seedEmployeeTypes();
        $this->seedRanks();
        $this->seedFunctionalPositions();
        $this->seedStructuralPositions();
        $this->seedCountries();
        $this->seedConcentrations();
        $this->seedLectureSystems();
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

    private function seedEducationLevels(): void
    {
        $levels = [
            ['SD', 'Sekolah Dasar', 2, false], ['SMP', 'Sekolah Menengah Pertama', 3, false],
            ['SMA', 'Sekolah Menengah Atas', 4, false], ['D1', 'Diploma Satu', 5, true],
            ['D2', 'Diploma Dua', 6, true], ['D3', 'Diploma Tiga', 7, true],
            ['S1', 'Strata Satu', 8, true], ['S2', 'Strata Dua', 9, true], ['S3', 'Strata Tiga', 10, true],
        ];

        foreach ($levels as [$level, $name, $sortOrder, $isUniversity]) {
            $model = new EducationLevel([
                'level' => $level, 'name' => $name, 'sort_order' => $sortOrder, 'is_university' => $isUniversity,
            ]);
            $this->saveSeedModel($model, "jenjang pendidikan {$level}");
        }
    }

    private function seedStudyPrograms(): void
    {
        $facultyIds = Faculty::find()->select('id')->indexBy('unit_code')->column();
        $programs = [
            ['55201', 'Teknik Informatika', 'Informatika', 'Informatics', 'FT', 'S1', 'Fakultas Teknik', 'TI', 120, 'Unggul'],
            ['55202', 'Sistem Informasi', 'Sistem Informasi', 'Information Systems', 'FT', 'S1', 'Fakultas Teknik', 'SI', 100, 'Baik Sekali'],
            ['84201', 'Matematika', 'Matematika', 'Mathematics', 'FMIPA', 'S1', 'Fakultas Matematika dan Ilmu Pengetahuan Alam', 'MAT', 80, 'A'],
            ['79201', 'Sastra Inggris', 'Sastra Inggris', 'English Literature', 'FIB', 'S1', 'Fakultas Ilmu Budaya', 'SING', 80, 'A'],
            ['15401', 'Kebidanan', 'D3 Kebidanan', 'Midwifery', 'FKKMK', 'D3', 'Fakultas Kedokteran, Kesehatan Masyarakat, dan Keperawatan', 'BID', 75, 'Baik Sekali'],
        ];

        foreach ($programs as [$code, $name, $shortName, $nameEn, $facultyCode, $type, $workUnit, $nimPrefix, $capacity, $grade]) {
            if (!isset($facultyIds[$facultyCode])) {
                echo "Faculty {$facultyCode} tidak ditemukan; program {$code} dilewati.\n";
                continue;
            }
            $model = new StudyProgram([
                'code' => $code, 'name' => $name, 'short_name' => $shortName, 'name_en' => $nameEn,
                'faculty_id' => $facultyIds[$facultyCode], 'program_type' => $type, 'work_unit' => $workUnit,
                'phone' => '0274-000000', 'address' => 'Kampus Bulaksumur, Yogyakarta', 'capacity' => $capacity,
                'grade' => $grade, 'nim_prefix' => $nimPrefix, 'nim_sequence_length' => 3,
                'allow_choice_1' => true, 'allow_choice_2' => true, 'allow_choice_3' => true, 'is_active' => true,
                'minimum_graduation_credits' => $type === 'D3' ? 108 : 144, 'minimum_graduation_gpa' => 2.00,
                'degree' => $type === 'D3' ? 'Ahli Madya' : 'Sarjana', 'degree_abbreviation' => $type === 'D3' ? 'A.Md.' : 'S.T.',
            ]);
            $this->saveSeedModel($model, "program studi {$name}");
        }
    }

    private function seedUniversityEducationLevels(): void
    {
        $levelIds = EducationLevel::find()->select('id')->indexBy('level')->column();
        $data = [
            ['D1', 2, 2, 4], ['D2', 3, 2, 12], ['D3', 6, 4, 10],
            ['S1', 8, 6, 14], ['S2', 4, 4, 8], ['S3', 6, 6, 14],
        ];
        foreach ($data as [$level, $studyPeriod, $maxLeave, $maxStudy]) {
            if (!isset($levelIds[$level])) {
                continue;
            }
            $this->saveSeedModel(new UniversityEducationLevel([
                'education_level_id' => $levelIds[$level], 'study_period_semesters' => $studyPeriod,
                'max_leave_semesters' => $maxLeave, 'max_study_semesters' => $maxStudy,
            ]), "tingkat pendidikan universitas {$level}");
        }
    }

    private function seedLectureRooms(): void
    {
        $programIds = StudyProgram::find()->select('id')->indexBy('code')->column();
        $rooms = [
            ['55201', '01', 'Ruang Kuliah 1', 'G.202', 30],
            ['55201', '02', 'Laboratorium Komputer', 'G.203', 25],
            ['55202', '03', 'Ruang Sistem Informasi', 'B.002', 25],
        ];

        foreach ($rooms as [$programCode, $code, $name, $location, $capacity]) {
            if (!isset($programIds[$programCode])) {
                continue;
            }
            $this->saveSeedModel(new LectureRoom([
                'study_program_id' => $programIds[$programCode],
                'code' => $code,
                'name' => $name,
                'location' => $location,
                'capacity' => $capacity,
                'is_active' => true,
            ]), "ruang kuliah {$name}");
        }
    }

    private function seedAcademicActivities(): void
    {
        $activities = [
            ['01', 'KKN', '#ff0080'], ['02', 'PKL', '#000000'], ['021', 'Orientasi Mahasiswa', '#ef9a12'],
            ['023', 'Seminar Proposal', '#00ff00'], ['024', 'Seminar Hasil', '#000000'], ['03', 'Workshop', '#4caf50'],
            ['04', 'Pameran', '#2196f3'], ['05', 'Penelitian', '#404fc7'], ['07', 'Asistensi', '#795548'],
        ];
        foreach ($activities as [$code, $name, $background]) {
            $this->saveSeedModel(new AcademicActivity(compact('code', 'name', 'background')), "kegiatan akademik {$name}");
        }
    }

    private function seedAcademicCalendars(): void
    {
        $activityIds = AcademicActivity::find()->select('id')->indexBy('code')->column();
        foreach ([['01', '2017/2018 Ganjil', '2017-08-07', '2017-08-14', 'KKN 2017', true, false], ['021', '2017/2018 Ganjil', '2017-09-04', '2017-09-11', 'Orientasi Mahasiswa', false, false]] as [$code, $period, $start, $end, $description, $academicHoliday, $nationalHoliday]) {
            if (isset($activityIds[$code])) $this->saveSeedModel(new AcademicCalendar(['academic_activity_id' => $activityIds[$code], 'period' => $period, 'start_date' => $start, 'end_date' => $end, 'description' => $description, 'is_academic_holiday' => $academicHoliday, 'is_national_holiday' => $nationalHoliday]), "kalender akademik {$description}");
        }
    }

    private function seedExternalUniversities(): void
    {
        foreach ([['001001', 'Universitas Gadjah Mada', 'Bulaksumur, Kec. Depok', '0274-588688'], ['001002', 'Universitas Indonesia', 'Jalan Salemba Raya 4, Kota Jakarta Pusat', '021-7270020'], ['001003', 'Universitas Sumatera Utara', 'Jalan Dr T Mansur No 9, Medan', '061-8214033']] as [$code, $name, $address, $phone]) {
            $this->saveSeedModel(new ExternalUniversity(compact('code', 'name', 'address', 'phone')), "universitas luar {$name}");
        }
    }

    private function seedCompanies(): void
    {
        foreach ([['1', 'PT. Sevima', 'Jalan Medokan Asri Tengah MA 2 Blok Q 16', '03125426589'], ['2', 'PT Sentra Vidya Utama', 'Jalan Medokan Asri Tengah MA 2 Blok Q 16', '234567']] as [$number, $name, $address, $phone]) $this->saveSeedModel(new Company(compact('number', 'name', 'address', 'phone')), "perusahaan {$name}");
    }

    private function seedCompanyContacts(): void
    {
        $companyIds = Company::find()->select('id')->indexBy('number')->column();
        $contacts = [
            ['1', 'Ali Shadikin', '085730075044', 'ali.shadikin@sevima.com', 'Jalan Medokan Asri Tengah MA 2 Blok Q 16'],
            ['2', 'Dewi Lestari', '081234567890', 'dewi.lestari@sentra-vidya.co.id', 'Jalan Medokan Asri Tengah MA 2 Blok Q 16'],
        ];

        foreach ($contacts as [$companyNumber, $name, $phone, $email, $address]) {
            if (!isset($companyIds[$companyNumber])) {
                continue;
            }
            $this->saveSeedModel(new CompanyContact([
                'company_id' => $companyIds[$companyNumber],
                'name' => $name,
                'phone' => $phone,
                'email' => $email,
                'address' => $address,
                'gender' => 1,
            ]), "contact person {$name}");
        }
    }

    private function seedGradeElements(): void
    {
        foreach ([['1','TUGAS INDIVIDU','TGINV'],['2','UTS','UTS'],['3','UAS','UAS'],['4','PRAKTIKUM','PRAK'],['5','DISKUSI','DICS'],['6','KEHADIRAN','ABS']] as [$code,$name,$shortName]) $this->saveSeedModel(new GradeElement(['code'=>$code,'name'=>$name,'short_name'=>$shortName]), "unsur nilai {$name}");
    }

    private function seedJobs(): void
    {
        foreach ([
            ['0', 'Tidak Bekerja'],
            ['1', 'Bekerja'],
            ['2', 'Ibu Rumah Tangga'],
            ['3', 'Belum Bekerja'],
            ['4', 'PNS'],
            ['5', 'BUMN'],
            ['6', 'Pelajar'],
            ['7', 'Wiraswasta'],
            ['8', 'Pegawai Swasta'],
            ['9', 'Profesional'],
        ] as [$code, $name]) {
            $this->saveSeedModel(new Job(['code' => $code, 'name' => $name]), "pekerjaan {$name}");
        }
    }

    private function seedIncomes(): void
    {
        foreach ([
            ['0', 'Kurang dari 500.000'],
            ['1', '500.000 - 999.999'],
            ['2', '1.000.000 - 1.999.999'],
            ['3', '2.000.000 - 4.999.999'],
            ['4', '5.000.000 - 20.000.000'],
            ['5', 'Lebih dari 20.000.000'],
        ] as [$code, $name]) {
            $this->saveSeedModel(new Income(['code' => $code, 'name' => $name]), "penghasilan {$name}");
        }
    }

    private function seedStudentStatuses(): void
    {
        foreach ([
            ['A', 'Aktif'], ['C', 'Cuti'], ['D', 'Drop Out / Dikeluarkan'], ['G', 'Sedang Double Degree'],
            ['K', 'Mengundurkan Diri / Keluar'], ['L', 'Lulus'], ['N', 'Non Aktif'], ['T', 'Transfer / Mutasi'], ['W', 'Wafat'],
        ] as [$code, $name]) {
            $this->saveSeedModel(new StudentStatus(['code' => $code, 'name' => $name]), "status mahasiswa {$name}");
        }
    }

    private function seedTransportations(): void
    {
        foreach ([['0', 'Kendaraan Umum'], ['1', 'Sepeda'], ['2', 'Motor'], ['3', 'Mobil']] as [$code, $name]) {
            $this->saveSeedModel(new Transportation(['code' => $code, 'name' => $name]), "transportasi {$name}");
        }
    }

    private function seedEmployeeTypes(): void
    {
        $employeeTypes = [
            ['1', 'Dosen Tetap Yayasan'],
            ['2', 'Dosen Tetap DPK'],
            ['3', 'Dosen Luar Biasa'],
            ['4', 'Dosen Tamu'],
            ['5', 'Asisten Dosen'],
            ['6', 'Asisten Laboratorium'],
            ['7', 'Pegawai BAK'],
            ['8', 'Pendidik'],
        ];

        foreach ($employeeTypes as [$code, $name]) {
            $model = EmployeeType::findOne(['code' => $code]) ?? new EmployeeType(['code' => $code]);
            $model->name = $name;
            $this->saveSeedModel($model, "jenis pegawai {$name}");
        }
    }

    private function seedRanks(): void
    {
        $ranks = [
            ['I A', 'Juru Muda'],
            ['I B', 'Juru Muda Tingkat I'],
            ['I C', 'Juru'],
            ['I D', 'Juru Tingkat I'],
            ['II A', 'Pengatur Muda'],
            ['II B', 'Pengatur Muda Tingkat I'],
            ['II C', 'Pengatur'],
            ['II D', 'Pengatur Tingkat I'],
            ['III A', 'Penata Muda'],
            ['III B', 'Penata Muda Tingkat I'],
            ['III C', 'Penata'],
            ['III D', 'Penata Tingkat I'],
            ['IV A', 'Pembina'],
            ['IV B', 'Pembina Tingkat I'],
            ['IV C', 'Pembina Utama Muda'],
            ['IV D', 'Pembina Utama Madya'],
            ['IV E', 'Pembina Utama'],
        ];

        foreach ($ranks as [$code, $name]) {
            $model = Rank::findOne(['code' => $code]) ?? new Rank(['code' => $code]);
            $model->name = $name;
            $this->saveSeedModel($model, "golongan {$code}");
        }
    }

    private function seedFunctionalPositions(): void
    {
        $positions = [
            ['01', 'Tenaga Pengajar'],
            ['02', 'Asisten Ahli 100'],
            ['03', 'Asisten Ahli 150'],
            ['04', 'Lektor 200'],
            ['05', 'Lektor 300'],
            ['06', 'Lektor Kepala 400'],
            ['07', 'Lektor Kepala 550'],
            ['08', 'Lektor Kepala 700'],
            ['09', 'Profesor 850'],
            ['10', 'Profesor 1050'],
        ];

        foreach ($positions as [$code, $name]) {
            $model = FunctionalPosition::findOne(['code' => $code]) ?? new FunctionalPosition(['code' => $code]);
            $model->name = $name;
            $this->saveSeedModel($model, "jabatan fungsional {$name}");
        }
    }

    private function seedStructuralPositions(): void
    {
        $positions = [
            ['01', 'Rektor'],
            ['011', 'Wakil Rektor I'],
            ['012', 'Wakil Rektor II'],
            ['021', 'Dekan'],
            ['022', 'Wakil Dekan I'],
            ['023', 'Wakil Dekan II'],
            ['031', 'Kaprodi'],
            ['032', 'Sekretaris Prodi'],
        ];

        foreach ($positions as [$code, $name]) {
            $model = StructuralPosition::findOne(['code' => $code]) ?? new StructuralPosition(['code' => $code]);
            $model->name = $name;
            $this->saveSeedModel($model, "jabatan struktural {$name}");
        }
    }

    private function seedCountries(): void
    {
        $countries = [
            ['ABW', 'Aruba'],
            ['AFG', 'Afganistan'],
            ['AGO', 'Angola'],
            ['AIA', 'Anguilla'],
            ['ALA', 'Åland, Kepulauan'],
            ['ALB', 'Albania'],
            ['AND', 'Andorra'],
            ['ANT', 'Antillen Belanda'],
            ['ARE', 'Uni Emirat Arab'],
            ['ARG', 'Argentina'],
        ];

        foreach ($countries as [$code, $name]) {
            $model = Country::findOne(['code' => $code]) ?? new Country(['code' => $code]);
            $model->name = $name;
            $this->saveSeedModel($model, "negara {$name}");
        }
    }

    private function seedConcentrations(): void
    {
        $programIds = StudyProgram::find()->select('id')->indexBy('code')->column();
        $concentrations = [
            ['55201', '01', 'Sistem Cerdas', 'Intelligent Systems'],
            ['55201', '02', 'Rekayasa Perangkat Lunak', 'Software Engineering'],
            ['55201', '03', 'Jaringan dan Keamanan Siber', 'Network and Cyber Security'],
            ['55202', '01', 'Sistem Informasi Manajemen', 'Management Information Systems'],
            ['55202', '02', 'Analitik Data Bisnis', 'Business Data Analytics'],
        ];

        foreach ($concentrations as [$programCode, $code, $name, $nameEn]) {
            if (!isset($programIds[$programCode])) {
                continue;
            }
            $this->saveSeedModel(new Concentration([
                'study_program_id' => $programIds[$programCode], 'code' => $code, 'name' => $name, 'name_en' => $nameEn,
            ]), "konsentrasi {$name}");
        }
    }

    private function seedLectureSystems(): void
    {
        $systems = [
            ['1', 'Reguler'],
            ['2', 'Non Reguler'],
            ['3', 'Kelas Karyawan'],
        ];

        foreach ($systems as [$code, $name]) {
            $this->saveSeedModel(new LectureSystem([
                'code' => $code,
                'name' => $name,
            ]), "sistem kuliah {$name}");
        }
    }

    private function saveSeedModel($model, string $label): void
    {
        if (!$model->save()) {
            echo "Gagal menyimpan {$label}:\n";
            print_r($model->getErrors());
        }
    }
}
