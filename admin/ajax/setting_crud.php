<?php 

require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

if (isset($_POST['action']) && $_POST['action'] == 'get_general') {
    // Query untuk mendapatkan data pengaturan
    $q = "SELECT * FROM `setting` WHERE `no` = ?";
    $values = [1];
    
    // Gunakan fungsi select (pastikan sudah sesuai implementasinya)
    $res = select($q, $values, "i");

    if ($res) {
        $data = mysqli_fetch_assoc($res);
        if ($data) {
            // Kirimkan response dalam format JSON
            header('Content-Type: application/json');
            echo json_encode($data);
        } else {
            // Tidak ada data ditemukan
            echo json_encode(["status" => "error", "message" => "No data found"]);
        }
    } else {
        // Jika query gagal
        echo json_encode(["status" => "error", "message" => "Database query failed"]);
    }
}
?> 