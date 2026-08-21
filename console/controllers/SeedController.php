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
use backend\models\SubjectType;
use backend\models\SubjectGroup;
use backend\models\FieldOfStudy;
use backend\models\CourseClass;
use backend\models\TimeSlot;
use backend\models\AttendanceStatus;
use backend\models\CurriculumYear;
use backend\models\Subject;
use backend\models\StudyProgramCurriculum;
use backend\models\SubjectPrerequisite;
use backend\models\SubjectEquivalence;
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

    public function actionSubjectTypes()
    {
        $this->seedSubjectTypes();
        echo "Seed Jenis Mata Kuliah selesai.\n";
    }

    public function actionSubjectGroups()
    {
        $this->seedSubjectGroups();
        echo "Seed Kelompok Mata Kuliah selesai.\n";
    }

    public function actionFieldsOfStudy()
    {
        $this->seedFieldsOfStudy();
        echo "Seed Bidang Ilmu selesai.\n";
    }

    public function actionCourseClasses()
    {
        $this->seedCourseClasses();
        echo "Seed Kelas Perkuliahan selesai.\n";
    }

    public function actionTimeSlots()
    {
        $this->seedTimeSlots();
        echo "Seed Slot Waktu selesai.\n";
    }

    public function actionAttendanceStatuses()
    {
        $this->seedAttendanceStatuses();
        echo "Seed Status Hadir selesai.\n";
    }

    public function actionCurriculumYears()
    {
        $this->seedCurriculumYears();
        echo "Seed Tahun Kurikulum selesai.\n";
    }

    public function actionSubjects()
    {
        $this->seedSubjects();
        echo "Seed Mata Kuliah selesai.\n";
    }

    public function actionStudyProgramCurricula()
    {
        $this->seedStudyProgramCurricula();
        echo "Seed Kurikulum Prodi selesai.\n";
    }

    public function actionSubjectPrerequisites()
    {
        $this->seedSubjectPrerequisites();
        echo "Seed Prasyarat Mata Kuliah selesai.\n";
    }

    public function actionSubjectEquivalences()
    {
        $this->seedSubjectEquivalences();
        echo "Seed Ekivalensi Mata Kuliah selesai.\n";
    }

    private function seedData()
    {
        $faker = Factory::create('id_ID');

        // Truncate all related tables
        Yii::$app->db->createCommand('SET FOREIGN_KEY_CHECKS = 0')->execute();

        Yii::$app->db->createCommand()->truncateTable(SubjectEquivalence::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(SubjectPrerequisite::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(StudyProgramCurriculum::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable('subject_lecturers')->execute();
        Yii::$app->db->createCommand()->truncateTable(Subject::tableName())->execute();
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
        Yii::$app->db->createCommand()->truncateTable(SubjectType::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(SubjectGroup::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(FieldOfStudy::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(CourseClass::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(TimeSlot::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(AttendanceStatus::tableName())->execute();
        Yii::$app->db->createCommand()->truncateTable(CurriculumYear::tableName())->execute();
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
        $this->seedSubjectTypes();
        $this->seedSubjectGroups();
        $this->seedFieldsOfStudy();
        $this->seedCourseClasses();
        $this->seedTimeSlots();
        $this->seedAttendanceStatuses();
        $this->seedCurriculumYears();
        $this->seedSubjects();
        $this->seedStudyProgramCurricula();
        $this->seedSubjectPrerequisites();
        $this->seedSubjectEquivalences();
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

    private function seedSubjectTypes(): void
    {
        $subjectTypes = [
            ['A', 'Kuliah'],
            ['B', 'Blok'],
            ['KP', 'Kuliah dan Praktikum'],
            ['MG', 'Magang Kerja'],
            ['P', 'Praktikum'],
            ['PK', 'Praktek Kerja'],
            ['PS', 'Proposal Skripsi'],
            ['S', 'Skripsi'],
        ];

        foreach ($subjectTypes as [$code, $name]) {
            $model = SubjectType::findOne(['code' => $code]) ?? new SubjectType(['code' => $code]);
            $model->name = $name;
            $this->saveSeedModel($model, "jenis mata kuliah {$name}");
        }
    }

    private function seedSubjectGroups(): void
    {
        $subjectGroups = [
            ['KSG', 'Kosong'],
            ['MBB', 'Mata Kuliah Berkehidupan Bermasyarakat'],
            ['MKB', 'Mata Kuliah Keahlian Berkarya'],
            ['MKK', 'Mata Kuliah Keilmuan dan Kepribadian'],
            ['MKU', 'Mata Kuliah Umum'],
            ['MPB', 'Mata Kuliah Perilaku Berkarya'],
            ['MPK', 'Mata Kuliah Pengembangan Kepribadian'],
        ];

        foreach ($subjectGroups as [$code, $name]) {
            $model = SubjectGroup::findOne(['code' => $code]) ?? new SubjectGroup(['code' => $code]);
            $model->name = $name;
            $this->saveSeedModel($model, "kelompok mata kuliah {$name}");
        }
    }

    private function seedFieldsOfStudy(): void
    {
        $fields = [
            ['ACC1', 'Accounting'],
            ['FINC', 'Finance'],
            ['MRKT', 'Marketing'],
            ['ORG', 'Organization'],
        ];

        foreach ($fields as [$code, $name]) {
            $model = FieldOfStudy::findOne(['code' => $code]) ?? new FieldOfStudy(['code' => $code]);
            $model->name = $name;
            $this->saveSeedModel($model, "bidang ilmu {$name}");
        }
    }

    private function seedCourseClasses(): void
    {
        $classes = [
            ['A', 'Kelas A'],
            ['B', 'Kelas B'],
            ['K', 'Kelas K'],
            ['NA', 'Tidak Ada Kelas'],
        ];

        foreach ($classes as [$code, $name]) {
            $model = CourseClass::findOne(['code' => $code]) ?? new CourseClass(['code' => $code]);
            $model->name = $name;
            $this->saveSeedModel($model, "kelas perkuliahan {$name}");
        }
    }

    private function seedTimeSlots(): void
    {
        $times = [
            '07:15', '07:30', '08:00', '08:15', '08:50', '09:00', '09:15', '09:40', '11:20',
            '12:00', '12:15', '13:00', '14:40', '15:30', '17:10', '17:30',
            '18:20', '18:30', '19:10', '20:00', '20:10', '20:50', '21:40', '22:30',
        ];

        foreach ($times as $time) {
            $databaseTime = $time . ':00';
            $model = TimeSlot::findOne(['time' => $databaseTime]) ?? new TimeSlot(['time' => $time]);
            $model->time = $time;
            $this->saveSeedModel($model, "slot waktu {$time}");
        }
    }

    private function seedAttendanceStatuses(): void
    {
        $statuses = [
            ['A', 'Alfa', false, true, true],
            ['H', 'Hadir', true, true, true],
            ['I', 'Izin', false, false, true],
            ['S', 'Sakit', false, false, true],
        ];

        foreach ($statuses as [$code, $name, $countsAsPresent, $appliesToLecturers, $appliesToStudents]) {
            $model = AttendanceStatus::findOne(['code' => $code]) ?? new AttendanceStatus(['code' => $code]);
            $model->name = $name;
            $model->counts_as_present = $countsAsPresent;
            $model->applies_to_lecturers = $appliesToLecturers;
            $model->applies_to_students = $appliesToStudents;
            $this->saveSeedModel($model, "status hadir {$name}");
        }
    }

    private function seedCurriculumYears(): void
    {
        for ($year = 2018; $year <= 2028; $year++) {
            $model = CurriculumYear::findOne(['year' => $year]) ?? new CurriculumYear(['year' => $year]);
            $model->description = $year === 2022 ? 'Kurikulum Berbasis KKNI' : "Kurikulum {$year}";
            $this->saveSeedModel($model, "tahun kurikulum {$year}");
        }
    }

    private function seedSubjects(): void
    {
        $curriculumId = CurriculumYear::find()->select('id')->where(['year' => 2028])->scalar();
        $typeIds = SubjectType::find()->select('id')->indexBy('code')->column();
        $groupIds = SubjectGroup::find()->select('id')->indexBy('code')->column();
        $programs = StudyProgram::find()->orderBy('code')->all();
        $lecturerIds = Lecture::find()->select('id')->orderBy('id')->column();

        if (!$curriculumId || !$programs || !isset($typeIds['A'], $typeIds['KP'], $groupIds['MKK'], $groupIds['MKB'])) {
            echo "Seed Mata Kuliah dilewati karena data relasi belum lengkap.\n";
            return;
        }

        $courseTemplates = [
            ['Landasan Keilmuan', 'Scientific Foundations', 2],
            ['Teori dan Konsep', 'Theory and Concepts', 3],
            ['Metode dan Analisis', 'Methods and Analysis', 3],
            ['Praktik Profesional', 'Professional Practice', 2],
            ['Teknologi Terapan', 'Applied Technology', 3],
            ['Proyek Terintegrasi', 'Integrated Project', 4],
            ['Seminar Akademik', 'Academic Seminar', 1],
            ['Studi Pilihan', 'Elective Study', 2],
        ];

        $subjectIndex = 0;
        foreach ($programs as $program) {
            $prefix = strtoupper(preg_replace('/[^A-Z0-9]/', '', $program->nim_prefix ?: $program->short_name ?: $program->code));
            $prefix = substr($prefix, 0, 8) ?: 'PRODI';
            for ($semester = 1; $semester <= 8; $semester++) {
                $courseCount = $semester <= 6 ? 8 : ($semester === 7 ? 5 : 3);
                foreach (array_slice($courseTemplates, 0, $courseCount) as $sequence => [$templateName, $templateNameEn, $credits]) {
                    $number = $sequence + 1;
                    $code = sprintf('%s-S%02d-%02d', $prefix, $semester, $number);
                    $name = "{$templateName} {$program->name} {$semester}.{$number}";
                    $nameEn = "{$templateNameEn} {$program->name_en} {$semester}.{$number}";
                    $isPracticum = $number >= 5;
                    $model = Subject::findOne(['curriculum_year_id' => $curriculumId, 'code' => $code]) ?? new Subject();
                    $model->setAttributes([
                        'curriculum_year_id' => $curriculumId, 'code' => $code, 'name' => $name, 'name_en' => $nameEn,
                        'subject_type_id' => $typeIds[$isPracticum ? 'KP' : 'A'],
                        'subject_group_id' => $groupIds[$isPracticum ? 'MKB' : 'MKK'],
                        'study_program_id' => $program->id, 'credits' => $credits,
                        'face_to_face_credits' => $isPracticum ? max(1, $credits - 1) : $credits,
                        'practicum_credits' => $isPracticum && $credits > 1 ? 1 : 0,
                        'lab_credits' => 0, 'ksk_credits' => 0, 'pbl_credits' => 0,
                        'syllabus' => "Silabus {$name}",
                    ]);
                    if (!$model->save()) {
                        echo "Gagal menyimpan mata kuliah {$name}:\n";
                        print_r($model->errors);
                        continue;
                    }
                    Yii::$app->db->createCommand()->delete('subject_lecturers', ['subject_id' => $model->id])->execute();
                    if ($lecturerIds) {
                        Yii::$app->db->createCommand()->insert('subject_lecturers', [
                            'subject_id' => $model->id,
                            'lecturer_id' => $lecturerIds[$subjectIndex % count($lecturerIds)],
                        ])->execute();
                    }
                    $subjectIndex++;
                }
            }
        }
    }

    private function seedStudyProgramCurricula(): void
    {
        $subjects = Subject::find()->with('curriculumYear')->orderBy('code')->all();
        $semesterCredits = [];
        foreach ($subjects as $index => $subject) {
            $isGenerated = preg_match('/-S(0[1-8])-(0[1-8])$/', $subject->code, $matches);
            if ($isGenerated) {
                $semester = (int) $matches[1];
                $sequence = (int) $matches[2];
                $allowedCourseCount = $semester <= 6 ? 8 : ($semester === 7 ? 5 : 3);
                if ($sequence > $allowedCourseCount) {
                    $obsolete = StudyProgramCurriculum::findOne([
                        'study_program_id' => $subject->study_program_id,
                        'curriculum_year_id' => $subject->curriculum_year_id,
                        'subject_id' => $subject->id,
                    ]);
                    if ($obsolete) {
                        $obsolete->delete();
                    }
                    continue;
                }
            } else {
                $semester = ($index % 2) + 1;
            }
            $creditKey = $subject->study_program_id . ':' . $subject->curriculum_year_id . ':' . $semester;
            $currentCredits = $semesterCredits[$creditKey] ?? (float) StudyProgramCurriculum::find()
                ->alias('spc')->joinWith('subject s')->where([
                    'spc.study_program_id' => $subject->study_program_id,
                    'spc.curriculum_year_id' => $subject->curriculum_year_id,
                    'spc.semester' => $semester,
                ])->sum('s.credits');
            $existing = StudyProgramCurriculum::findOne([
                'study_program_id' => $subject->study_program_id,
                'curriculum_year_id' => $subject->curriculum_year_id,
                'subject_id' => $subject->id,
            ]);
            if (!$existing && $currentCredits + (float) $subject->credits > 23) {
                echo "Mata kuliah {$subject->code} dilewati: total semester {$semester} akan melebihi 23 SKS.\n";
                continue;
            }
            $model = StudyProgramCurriculum::findOne([
                'study_program_id' => $subject->study_program_id,
                'curriculum_year_id' => $subject->curriculum_year_id,
                'subject_id' => $subject->id,
            ]) ?? new StudyProgramCurriculum();
            $model->setAttributes([
                'study_program_id' => $subject->study_program_id,
                'curriculum_year_id' => $subject->curriculum_year_id,
                'subject_id' => $subject->id,
                'semester' => $semester,
                'minimum_grade' => 'E',
                'is_mandatory' => true,
                'is_package' => $index < 6,
                'minimum_credits' => 0,
            ]);
            $this->saveSeedModel($model, "kurikulum prodi {$subject->code}");
            $semesterCredits[$creditKey] = $existing ? $currentCredits : $currentCredits + (float) $subject->credits;
        }

        $violations = (new \yii\db\Query())->select(['spc.study_program_id', 'spc.curriculum_year_id', 'spc.semester', 'total_credits' => 'SUM(s.credits)'])
            ->from(['spc' => StudyProgramCurriculum::tableName()])->innerJoin(['s' => Subject::tableName()], 's.id = spc.subject_id')
            ->groupBy(['spc.study_program_id', 'spc.curriculum_year_id', 'spc.semester'])->having(['>', 'SUM(s.credits)', 23])->all();
        if ($violations) {
            throw new \RuntimeException('Seeder Kurikulum Prodi menghasilkan semester dengan total lebih dari 23 SKS.');
        }
    }

    private function seedSubjectPrerequisites(): void
    {
        $curricula = [];
        $generatedCurricula = [];
        foreach (StudyProgramCurriculum::find()->with('subject')->all() as $curriculum) {
            $curricula[$curriculum->subject->code] = $curriculum;
            if (preg_match('/-S(0[1-8])-(0[1-7])$/', $curriculum->subject->code, $matches)) {
                $generatedCurricula[$curriculum->study_program_id][(int) $matches[1]][(int) $matches[2]] = $curriculum;
            }
        }
        $prerequisites = [
            ['IF202803', 'IF202802', 'passed', 'C'],
            ['IF202804', 'IF202801', 'passed', 'C'],
            ['IF202805', 'IF202802', 'passed', 'D'],
            ['SI202803', 'SI202801', 'passed', 'C'],
            ['SI202805', 'SI202804', 'passed', 'C'],
        ];

        foreach ($prerequisites as [$courseCode, $prerequisiteCode, $type, $minimumGrade]) {
            if (!isset($curricula[$courseCode], $curricula[$prerequisiteCode])) { continue; }
            $model = SubjectPrerequisite::findOne([
                'course_curriculum_id' => $curricula[$courseCode]->id,
                'prerequisite_curriculum_id' => $curricula[$prerequisiteCode]->id,
            ]) ?? new SubjectPrerequisite();
            $model->setAttributes([
                'course_curriculum_id' => $curricula[$courseCode]->id,
                'prerequisite_curriculum_id' => $curricula[$prerequisiteCode]->id,
                'requirement_type' => $type,
                'minimum_grade' => $minimumGrade,
            ]);
            $this->saveSeedModel($model, "prasyarat {$courseCode} - {$prerequisiteCode}");
        }

        foreach ($generatedCurricula as $programId => $semesters) {
            for ($semester = 2; $semester <= 8; $semester++) {
                foreach ([1, 2] as $sequence) {
                    if (!isset($semesters[$semester][$sequence], $semesters[$semester - 1][$sequence])) {
                        continue;
                    }
                    $course = $semesters[$semester][$sequence];
                    $prerequisite = $semesters[$semester - 1][$sequence];
                    $model = SubjectPrerequisite::findOne([
                        'course_curriculum_id' => $course->id,
                        'prerequisite_curriculum_id' => $prerequisite->id,
                    ]) ?? new SubjectPrerequisite();
                    $model->setAttributes([
                        'course_curriculum_id' => $course->id,
                        'prerequisite_curriculum_id' => $prerequisite->id,
                        'requirement_type' => 'passed',
                        'minimum_grade' => 'C',
                    ]);
                    $this->saveSeedModel($model, "prasyarat {$course->subject->code} - {$prerequisite->subject->code}");
                }
            }
        }
    }

    private function seedSubjectEquivalences(): void
    {
        $newYearId = CurriculumYear::find()->select('id')->where(['year' => 2028])->scalar();
        $oldYearId = CurriculumYear::find()->select('id')->where(['year' => 2027])->scalar();
        if (!$newYearId || !$oldYearId) {
            echo "Seed Ekivalensi Mata Kuliah dilewati karena Kurikulum 2028 atau 2027 tidak ditemukan.\n";
            return;
        }

        $newSubjects = Subject::find()->where(['curriculum_year_id' => $newYearId])->orderBy(['study_program_id' => SORT_ASC, 'code' => SORT_ASC])->all();
        foreach ($newSubjects as $newSubject) {
            $oldSubject = Subject::findOne([
                'curriculum_year_id' => $oldYearId,
                'study_program_id' => $newSubject->study_program_id,
                'code' => $newSubject->code,
            ]);
            if (!$oldSubject) {
                $oldSubject = new Subject($newSubject->getAttributes([
                    'code', 'name', 'name_en', 'subject_type_id', 'subject_group_id', 'credits',
                    'face_to_face_credits', 'practicum_credits', 'lab_credits', 'ksk_credits', 'pbl_credits',
                    'mku', 'sap', 'syllabus', 'teaching_material', 'module',
                ]));
                $oldSubject->curriculum_year_id = $oldYearId;
                $oldSubject->study_program_id = $newSubject->study_program_id;
                if (!$oldSubject->save()) {
                    echo "Gagal membuat Mata Kuliah lama {$newSubject->code}:\n";
                    print_r($oldSubject->errors);
                    continue;
                }
                foreach ($newSubject->getLecturers()->select('lectures.id')->column() as $lecturerId) {
                    Yii::$app->db->createCommand()->insert('subject_lecturers', ['subject_id' => $oldSubject->id, 'lecturer_id' => $lecturerId])->execute();
                }
            }

            $newCurriculum = StudyProgramCurriculum::findOne([
                'study_program_id' => $newSubject->study_program_id,
                'curriculum_year_id' => $newYearId,
                'subject_id' => $newSubject->id,
            ]);
            if ($newCurriculum && !StudyProgramCurriculum::find()->where([
                'study_program_id' => $newSubject->study_program_id,
                'curriculum_year_id' => $oldYearId,
                'subject_id' => $oldSubject->id,
            ])->exists()) {
                $oldCurriculum = new StudyProgramCurriculum($newCurriculum->getAttributes([
                    'semester', 'minimum_grade', 'is_mandatory', 'is_package', 'topic', 'basic_competencies', 'minimum_credits',
                ]));
                $oldCurriculum->study_program_id = $newSubject->study_program_id;
                $oldCurriculum->curriculum_year_id = $oldYearId;
                $oldCurriculum->subject_id = $oldSubject->id;
                $this->saveSeedModel($oldCurriculum, "kurikulum lama {$oldSubject->code}");
            }

            $equivalence = SubjectEquivalence::findOne(['new_subject_id' => $newSubject->id, 'old_subject_id' => $oldSubject->id]) ?? new SubjectEquivalence();
            $equivalence->setAttributes([
                'study_program_id' => $newSubject->study_program_id,
                'new_curriculum_year_id' => $newYearId,
                'old_curriculum_year_id' => $oldYearId,
                'new_subject_id' => $newSubject->id,
                'old_subject_id' => $oldSubject->id,
            ]);
            $this->saveSeedModel($equivalence, "ekivalensi {$newSubject->code} 2028-2027");
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
