<?php
include_once "inc.session.php";
include_once "../../library/inc.connection.php";
include_once "../../library/inc.library.php";

// Baca Kode Pelanggan yang Login
$KodePelanggan	= $_SESSION['SES_PELANGGAN'];
?> 

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>Daftar Pesanan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%" class="text-center">No</th>
                                    <th width="12%">No. Pesan</th>
                                    <th width="12%">Tanggal</th>
                                    <th width="20%">Nama Penerima</th>
                                    <th width="12%" class="text-end">Total (Rp)</th>
                                    <th width="12%" class="text-end">Biaya Kirim (Rp)</th>
                                    <th width="12%" class="text-center">Status Pesanan</th>
                                    <th width="10%" class="text-center">Status Bayar</th>
                                    <th width="7%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Deklrasi variabel
                                $biayaKirim	= 0;
                                $totalBayar 	= 0;
                                
                                // Menampilkan semua data Pesanan Lunas (yang sudah lunas)
                                $mySql = "SELECT pemesanan.*, pelanggan.nm_pelanggan FROM pemesanan LEFT JOIN pelanggan ON pemesanan.kd_pelanggan = pelanggan.kd_pelanggan WHERE pemesanan.kd_pelanggan = '$KodePelanggan' ORDER BY no_pemesanan DESC";
                                $myQry = mysqli_query($mysqli, $mySql) or die ("Gagal query".mysqli_error($mysqli));
                                $nomor = 0;
                                
                                if(mysqli_num_rows($myQry) > 0) {
                                    while ($myData = mysqli_fetch_array($myQry)) {
                                        $nomor++;
                                        $Kode = $myData['no_pemesanan'];
                                        
                                        // Deklarasi variabel data
                                        $diskonHarga = 0;
                                        $hargaDiskon = 0;
                                        $totalHarga  = 0;
                                        $totalBarang = 0;
                                        
                                        // Menampilkan data di pemesanan_item
                                        $hitungSql	= "SELECT SUM(harga * jumlah) As total_harga, SUM(jumlah) As total_barang FROM pemesanan_item WHERE no_pemesanan='$Kode'";
                                        $hitungQry 	= mysqli_query($mysqli, $hitungSql) or die ("Gagal query 2 ".mysqli_error($mysqli));
                                        $hitungData = mysqli_fetch_array($hitungQry);
                                        
                                        $totalHarga  = $hitungData['total_harga'];
                                        $totalBarang = $hitungData['total_barang'];
                                        
                                        // Hitung total yang harus dibayar
                                        $totalBayar	= $totalHarga + $biayaKirim;
                                        
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $nomor; ?></td>
                                    <td><strong><?php echo $myData['no_pemesanan']; ?></strong></td>
                                    <td><?php echo IndonesiaTgl($myData['tgl_pemesanan']); ?></td>
                                    <td><?php echo $myData['nama_penerima']; ?></td>
                                    <td class="text-end"><strong>Rp <?php echo format_angka($totalHarga); ?></strong></td>
                                    <td class="text-end">Rp <?php echo format_angka($biayaKirim); ?></td>
                                    <td class="text-center">
                                        <?php 
                                            $statusPesanan = isset($myData['status_pesanan']) ? $myData['status_pesanan'] : 'Menunggu';
                                            $statusClass = '';
                                            switch($statusPesanan) {
                                                case 'Diproses':
                                                    $statusClass = 'bg-success';
                                                    break;
                                                case 'Dikirim':
                                                    $statusClass = 'bg-warning';
                                                    break;
                                                case 'Terkirim':
                                                    $statusClass = 'bg-info';
                                                    break;
                                                default:
                                                    $statusClass = 'bg-secondary';
                                            }
                                        ?>
                                        <span class="badge <?php echo $statusClass; ?> <?php echo in_array($statusClass, ['bg-primary','bg-success','bg-danger','bg-info','bg-secondary']) ? 'text-white' : ($statusClass == 'bg-warning' ? 'text-dark' : ''); ?>">
                                            <?php echo $statusPesanan; ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php 
                                            $statusBayar = $myData['status_bayar'];
                                            $bayarClass = ($statusBayar == 'Lunas') ? 'bg-success' : 'bg-warning';
                                        ?>
                                        <span class="badge <?php echo $bayarClass; ?> <?php echo ($bayarClass == 'bg-success') ? 'text-white' : ($bayarClass == 'bg-warning' ? 'text-dark' : ''); ?>">
                                            <?php echo $statusBayar; ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if ( $myData['metode_pembayaran'] == 'transfer' ) { ?>
                                            <?php if ($myData['status_bayar'] == 'Lunas') { ?>
                                                <a href="transaksi_lihat.php?Kode=<?php echo $Kode; ?>" 
                                                   class="btn btn-sm btn-info" 
                                                   title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            <?php } else { ?>
                                                <a href="?open=Konfirmasi&Kode=<?php echo $Kode; ?>" 
                                                   class="btn btn-sm btn-warning" 
                                                   title="Konfirmasi Pembayaran">
                                                    <i class="fas fa-credit-card"></i>
                                                </a>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <a href="transaksi_lihat.php?Kode=<?php echo $Kode; ?>" 
                                               class="btn btn-sm btn-info" 
                                               title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php 
                                    }
                                } else {
                                    echo '<tr><td colspan="9" class="text-center text-muted">Belum ada pesanan</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Keterangan Status -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Keterangan Status</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Status Pesanan:</h6>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-secondary text-white">Menunggu</span>
                                <span class="badge bg-success text-white">Diproses</span>
                                <span class="badge bg-warning text-dark">Dikirim</span>
                                <span class="badge bg-info text-white">Terkirim</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>Status Pembayaran:</h6>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-warning text-dark">Belum Lunas</span>
                                <span class="badge bg-success text-white">Lunas</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
