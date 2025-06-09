<?php

/** @var yii\web\View $this */
$this->title = 'Dashboard';
?>

<!-- Content Row -->
<div class="row">

    <!-- IPK Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Nilai IPK</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">4,00</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-star fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tagihan Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Tagihan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp 100.000</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-invoice fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Semester Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Semester</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">3</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SKS Total Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            SKS Total</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-paperclip fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->

<div class="row">
    <div class="col-12 my-3">
        <div class="card shadow mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Jadwal Kuliah</strong>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="thead-dark">
                        <tr>
                            <th width="20px">No</th>
                            <th>Kode Mata Kuliah</th>
                            <th>Mata Kuliah</th>
                            <th>Dosen</th>
                            <th>Kelas</th>
                            <th>Hari</th>
                            <th>Waktu</th>
                            <th>Ruang</th>
                            <th>Pertemuan</th>
                            <th>Hadir</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>MTK101</td>
                            <td style="cursor:pointer;" onclick="rps_mhs('token1', 'token2');">Matematika Dasar</td>
                            <td>Dr. Andi (1001)</td>
                            <td>A</td>
                            <td>Senin</td>
                            <td>08:00 - 10:00</td>
                            <td>R.1.1</td>
                            <td>
                                10/16 <span class="badge badge-success">62%</span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-success" style="width: 62%"></div>
                                </div>
                            </td>
                            <td style="cursor:pointer;" onclick="absensi_mhs('token1', 'token2');">
                                <span class="badge badge-warning">85%</span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-warning" style="width: 85%"></div>
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-outline-info btn-sm" title="Lihat Presensi"><i class="fas fa-check-square"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>FIS102</td>
                            <td style="cursor:pointer;" onclick="rps_mhs('token3', 'token4');">Fisika Lanjut</td>
                            <td>Prof. Budi (1002)</td>
                            <td>B</td>
                            <td>Selasa</td>
                            <td>10:00 - 12:00</td>
                            <td>R.2.3</td>
                            <td>
                                12/16 <span class="badge badge-success">75%</span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-success" style="width: 75%"></div>
                                </div>
                            </td>
                            <td style="cursor:pointer;" onclick="absensi_mhs('token3', 'token4');">
                                <span class="badge badge-warning">90%</span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-warning" style="width: 90%"></div>
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-outline-info btn-sm" title="Lihat Presensi"><i class="fas fa-check-square"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>KIM103</td>
                            <td style="cursor:pointer;" onclick="rps_mhs('token5', 'token6');">Kimia Organik</td>
                            <td>Dr. Sari (1003)</td>
                            <td>C</td>
                            <td>Rabu</td>
                            <td>13:00 - 15:00</td>
                            <td>R.3.2</td>
                            <td>
                                14/16 <span class="badge badge-success">87%</span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-success" style="width: 87%"></div>
                                </div>
                            </td>
                            <td style="cursor:pointer;" onclick="absensi_mhs('token5', 'token6');">
                                <span class="badge badge-warning">95%</span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-warning" style="width: 95%"></div>
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-outline-info btn-sm" title="Lihat Presensi"><i class="fas fa-check-square"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>INF104</td>
                            <td style="cursor:pointer;" onclick="rps_mhs('token7', 'token8');">Pemrograman Web</td>
                            <td>Pak Tono (1004)</td>
                            <td>D</td>
                            <td>Kamis</td>
                            <td>15:00 - 17:00</td>
                            <td>Lab. Komputer</td>
                            <td>
                                13/16 <span class="badge badge-success">81%</span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-success" style="width: 81%"></div>
                                </div>
                            </td>
                            <td style="cursor:pointer;" onclick="absensi_mhs('token7', 'token8');">
                                <span class="badge badge-warning">89%</span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-warning" style="width: 89%"></div>
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-outline-info btn-sm" title="Lihat Presensi"><i class="fas fa-check-square"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>ENG105</td>
                            <td style="cursor:pointer;" onclick="rps_mhs('token9', 'token10');">English for Science</td>
                            <td>Miss Linda (1005)</td>
                            <td>E</td>
                            <td>Jumat</td>
                            <td>10:00 - 12:00</td>
                            <td>R.4.4</td>
                            <td>
                                9/16 <span class="badge badge-success">56%</span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-success" style="width: 56%"></div>
                                </div>
                            </td>
                            <td style="cursor:pointer;" onclick="absensi_mhs('token9', 'token10');">
                                <span class="badge badge-warning">80%</span>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-warning" style="width: 80%"></div>
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-outline-info btn-sm" title="Lihat Presensi"><i class="fas fa-check-square"></i></button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
