   <!-- panggil file header -->
   <?php include "header.php"; ?>
    
   <?php
   //uji jika tombol simpan diklik
   if(isset($_POST['bsimpan'])){
    //makan lakukan eksekusi didalam sini
    $tgl = date('Y-m-d');

    // htmlspecialchars agar inputan lebih aman dari injection
    $nama = htmlspecialchars( $_POST['nama'], ENT_QUOTES);
    $alamat = htmlspecialchars( $_POST['alamat'], ENT_QUOTES);
    $tujuan = htmlspecialchars( $_POST['tujuan'], ENT_QUOTES);
    $nope = htmlspecialchars( $_POST['nope'], ENT_QUOTES);

    //persiapan query simpan data
    $simpan = mysqli_query($koneksi, "INSERT INTO ttamu VALUES ('','$tgl', '$nama', '$alamat', '$tujuan', '$nope')");

    //uji jika simpan data sukses
    if($simpan){
        echo "<script>alert('Simpan data Sukses, Terimakasih..!');
        document.location='?'</script>";
    }else{
        echo "<script>alert('Simpan data Gagal');
        document.location='?'</script>";
    }
   }
   

   ?>

   <!-- Head -->
    <div class="head text-center">
        <img src="assets/img/logo.png" alt="logo" width="100">
        <h2 class="text-white">Sistem Informasi Buku Tamu <br>Islamic Center</h2>
    </div>

    <!-- End Head -->

    <!-- Awal Row -->
    <div class="row mt-2">
        <!-- col-lg-7 -->
        <div class="col-lg-7 mb-3">
            <div class="card shadow bg-gradient-light">
                <!-- Card Body -->
                <div class="card-body">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Identitas Pengunjung</h1>
                        </div>
                        <form class="user" method="POST" action="">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" name="nama" placeholder="nama pengunjung" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" name="alamat" placeholder="Alamat Pengunjung" required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" name="tujuan" placeholder="Tujuan pengunjung" required>
                            </div> 
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" name="nope" placeholder="No.Hp Pengunjung" required>
                            </div>

                            <button type="submit" name="bsimpan" class="btn btn-primary btn-user btn-block">Simpan Data</button>
                        
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="#">By. Islamic Center | 2021 - <?=date('Y') ?></a>
                        </div>
                    </div>
                <!-- End Card Body -->
            </div>
        </div>
        <!-- end col-lg-7  -->
        <!-- col-lg-5 -->
        <div class="col-lg-5 mb-3">
            <!-- card-->
            <div class="card shadow">
                <!-- Card Body -->
                <div class="card-body">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Statistik Pengunjung</h1>
                    </div>
                    <?php
                    // deklarasi tanggal

                    // menampilak tanggal sekarang
                    $tgl_sekarang = date('Y-m-d');

                    //menampilkan tgl kemarin
                    $kemarin = date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))));

                    $sekarang = date('Y-m-d h:i:s');

                    //mendapatkan 6 hari sebelum tgl sekarang
                    $seminggu = date('Y-m-d h:i:s', strtotime('-1 week +1 day', strtotime($tgl_sekarang)));

                    //mendapatkan 6 hari sebelum tgl sekarang
                    $bulan_ini = date('m');

                   // persiapan query tampilkan jumlah data pengunjung
                   $tgl_sekarang = mysqli_fetch_array(mysqli_query($koneksi, "SELECT 
                   count(*) FROM ttamu where tanggal like '%$tgl_sekarang%' "
                    ));

                    $kemarin = mysqli_fetch_array(mysqli_query($koneksi, "SELECT 
                   count(*) FROM ttamu where tanggal like '%$kemarin%' "
                    ));

                    $seminggu = mysqli_fetch_array(mysqli_query($koneksi, "SELECT 
                   count(*) FROM ttamu where tanggal BETWEEN '$seminggu' and '$sekarang'"
                    ));

                    $sebulan = mysqli_fetch_array(mysqli_query($koneksi, "SELECT 
                   count(*) FROM ttamu where month(tanggal) = '$bulan_ini'"
                    ));

                    $keseluruhan = mysqli_fetch_array(mysqli_query($koneksi, "SELECT 
                   count(*) FROM ttamu"
                    ));

                    ?>
                    <table class="table table-bordered">
                        <tr>
                            <td>Hari Ini</td>
                            <td>: <?= $tgl_sekarang[0] ?></td>
                        </tr>
                        <tr>
                            <td>Kemarin</td>
                            <td>: <?= $kemarin[0] ?></td>
                        </tr>
                        <tr>
                            <td>Minggu Ini</td>
                            <td>: <?= $seminggu[0] ?></td>
                        </tr>
                        <tr>
                            <td>Bulan ini</td>
                            <td>: <?= $sebulan[0] ?></td>
                        </tr>
                        <tr>
                            <td>Keseluruhan</td>
                            <td>: <?= $keseluruhan[0] ?></td>
                        </tr>

                    </table>
                </div>
            <!-- endcard body -->
            </div>
            <!-- end card -->
        </div>
        <!-- col-lg-5 -->

    </div>
    <!-- End Row -->
    <!-- card-->
    <div class="card shadow">
        <!-- Card Body -->
        <!-- DataTable Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Pengunjung Hari ini [<?=date('d-m-Y')?>]</h6>
            </div>
            <div class="card-body">
                <a href="rekapitulasi.php" class="btn btn-success mb-3"><i class="fa fa-table"></i> Rekapitulasi Pengunjung</a>
                <a href="logout.php" class="btn btn-danger mb-3"><i class="fa fa-sign-out-alt"></i> Logout</a>
                
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>Nama Pengunjung</th>
                                <th>Alamat</th>
                                <th>Tujuan</th>
                                <th>No. HP</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>Nama Pengunjung</th>
                                <th>Alamat</th>
                                <th>Tujuan</th>
                                <th>No. HP</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php 
                            $tgl = date('Y-d-m'); 
                                $tampil = mysqli_query($koneksi, "SELECT * FROM ttamu order by id desc");
                                $no = 1;
                                while($data = mysqli_fetch_array($tampil)){
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?=$data['tanggal']?></td>
                                <td><?=$data['nama']?></td>
                                <td><?=$data['alamat']?></td>
                                <td><?=$data['tujuan']?></td>
                                <td><?=$data['nope']?></td>
                            </tr>
                            <?php  } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End DataTable Example -->
    </div>
    <!-- panggil file yang dicari -->
    <?php include "footer.php"; ?>

