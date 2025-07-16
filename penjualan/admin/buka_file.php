<?php
if(isset($_GET['open'])) {
	switch($_GET['open']){
		case '' :				
			if(!file_exists ("main.php")) die ("Empty Main Page!"); 
			include "main.php";
			break;
		case 'Login' :				
			if(!file_exists ("login.php")) die ("Sorry Empty Page!"); 
			include "login.php";
			break;
		case 'Login-Validasi' :				
			if(!file_exists ("login_validasi.php")) die ("Sorry Empty Page!"); 
			include "login_validasi.php";
			break; 
		case 'Logout' :				
			if(!file_exists ("login_out.php")) die ("Sorry Empty Page!"); 
			include "login_out.php";
			break;		
		case 'Halaman-Utama' :				
			if(!file_exists ("main.php")) die ("Sorry Empty Page!"); 
			include "main.php";	
			break;		
		case 'Password-Admin' :				
			if(!file_exists ("password_admin.php")) die ("Sorry Empty Page!"); 
			include "password_admin.php";
			break;						
		case 'Kategori-Data' :
			if(!file_exists ("kategori_data.php")) die ("Sorry Empty Page!"); 
			include "kategori_data.php";
			break;		
		case 'Kategori-Add' :
			if(!file_exists ("kategori_add.php")) die ("Sorry Empty Page!"); 
			include "kategori_add.php";	
			break;		
		case 'Kategori-Delete' :
			if(!file_exists ("kategori_delete.php")) die ("Sorry Empty Page!"); 
			include "kategori_delete.php";
			break;		
		case 'Kategori-Edit' :
			if(!file_exists ("kategori_edit.php")) die ("Sorry Empty Page!"); 
			include "kategori_edit.php";
			break;
		case 'Barang-Data':				
			if(!file_exists ("barang_data.php")) die ("Sorry Empty Page!"); 
			include "barang_data.php";
			break;		
		case 'Barang-Add':
			if(!file_exists ("barang_add.php")) die ("Sorry Empty Page!"); 
			include "barang_add.php";
			break;		
		case 'Barang-Delete':
			if(!file_exists ("barang_delete.php")) die ("Sorry Empty Page!"); 
			include "barang_delete.php";
			break;	
		case 'Barang-Edit':
			if(!file_exists ("barang_edit.php")) die ("Sorry Empty Page!"); 
			include "barang_edit.php";
			break;
		case 'Pelanggan-Data' :
			if(!file_exists ("pelanggan_data.php")) die ("Sorry Empty Page!"); 
			include "pelanggan_data.php";
			break;
		case 'Pelanggan-Delete' :
			if(!file_exists ("pelanggan_delete.php")) die ("Sorry Empty Page!"); 
			include "pelanggan_delete.php";
			break;
		case 'Data-Transaksi-Keluar':
			if(!file_exists ("data_transaksi_keluar.php")) die ("Sorry Empty Page!"); 
			include "data_transaksi_keluar.php";
			break;
		case 'Data-Transaksi-Keluar-Add':
			if(!file_exists ("data_transaksi_keluar_add.php")) die ("Sorry Empty Page!"); 
			include "data_transaksi_keluar_add.php";
			break;
		case 'Data-Transaksi-Keluar-Detail':
			if(!file_exists ("data_transaksi_keluar_detail.php")) die ("Sorry Empty Page!"); 
			include "data_transaksi_keluar_detail.php";
			break;
		case 'Data-Transaksi-Keluar-Delete':
			if(!file_exists ("data_transaksi_keluar_delete.php")) die ("Sorry Empty Page!"); 
			include "data_transaksi_keluar_delete.php";
			break;
		case 'Data-Transaksi-Keluar-Proses':
			if(!file_exists ("data_transaksi_keluar_proses.php")) die ("Sorry Empty Page!"); 
			include "data_transaksi_keluar_proses.php";
			break;
		case 'Data-Transaksi-Keluar-Pembayaran':
			if(!file_exists ("data_transaksi_keluar_pembayaran.php")) die ("Sorry Empty Page!"); 
			include "data_transaksi_keluar_pembayaran.php";
			break;
		case 'Data-Transaksi-Keluar-Pelunasan':
			if(!file_exists ("data_transaksi_keluar_pelunasan.php")) die ("Sorry Empty Page!"); 
			include "data_transaksi_keluar_pelunasan.php";
			break;
		case 'Data-Kurir' :				
			if(!file_exists ("data_kurir.php")) die ("Sorry Empty Page!"); 
			include "data_kurir.php";
			break;
		case 'Pemesanan-Barang' :				
			if(!file_exists ("pemesanan_tampil.php")) die ("Sorry Empty Page!"); 
			include "pemesanan_tampil.php";
			break;
		case 'Pemesanan-Lihat' :				
			if(!file_exists ("pemesanan_lihat.php")) die ("Sorry Empty Page!"); 
			include "pemesanan_lihat.php";
			break;
		case 'Pemesanan-Bayar' :				
			if(!file_exists ("pemesanan_bayar.php")) die ("Sorry Empty Page!"); 
			include "pemesanan_bayar.php";
			break;
		case 'Hapus-Pemesanan' :				
			if(!file_exists ("hapus_pemesanan.php")) die ("Sorry Empty Page!"); 
			include "hapus_pemesanan.php";
			break;
		case 'Laporan' :	
			if(!file_exists ("menu_laporan.php")) die ("Sorry Empty Page!"); 
			include "menu_laporan.php";
			break;						
		case 'Laporan-Kategori' :				
			if(!file_exists ("laporan_kategori.php")) die ("Sorry Empty Page!"); 
			include "laporan_kategori.php";
			break;		
		case 'Laporan-Barang' :	
			if(!file_exists ("laporan_barang.php")) die ("Sorry Empty Page!"); 
			include "laporan_barang.php";
			break;
		case 'Laporan-Pelanggan' :
			if(!file_exists ("laporan_pelanggan.php")) die ("Sorry Empty Page!"); 
			include "laporan_pelanggan.php";
			break;
		case 'Penjadwalan_Prioritas' :
			if(!file_exists ("penjadwalan_prioritas.php")) die ("Sorry Empty Page!"); 
			include "penjadwalan_prioritas.php";
			break;
		case 'Update-Status' :
			if(!file_exists ("update_status_pesanan.php")) die ("Sorry Empty Page!"); 
			include "update_status_pesanan.php";
			break;
		case 'Laporan-Pemesanan-Pelanggan' :
			if(!file_exists ("laporan_pemesanan_pelanggan.php")) die ("Sorry Empty Page!"); 
			include "laporan_pemesanan_pelanggan.php";
			break;
		case 'Laporan-Bulanan' :
			if(!file_exists ("laporan_bulanan.php")) die ("Sorry Empty Page!"); 
			include "laporan_bulanan.php";
			break;
		default:
			if(!file_exists ("main.php")) die ("Empty Main Page!"); 
			include "main.php";
			break;
	}
}
else {
	if(!file_exists ("main.php")) die ("Empty Main Page!"); 
			include "main.php";	 
}
?>