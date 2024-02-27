<?php 

function rupiah($angka){
	
	$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	echo $hasil_rupiah;
 
}

function printJSON($v){
	header('Access-Control-Allow-Origin: *');
	header("Content-type: application/json");
	echo json_encode($v, JSON_PRETTY_PRINT);
	exit;
}