require('../inc/db_config.php');
require('../inc/essentials.php');
adminLogin();

$input_data = json_decode(file_get_contents('php://input'), true); // Menerima data JSON

if (isset($input_data['action'])) {
    if ($input_data['action'] == 'get_general') {
        // Query untuk mendapatkan data pengaturan
        $q = "SELECT * FROM `setting` WHERE `no` = ?";
        $values = [1];
        
        // Gunakan fungsi select (pastikan sudah sesuai implementasinya)
        $res = select($q, $values, "i");

        if ($res) {
            $data = mysqli_fetch_assoc($res);
            if ($data) {
                // Kirimkan response dalam format JSON
                echo json_encode($data);
            } else {
                // Tidak ada data ditemukan
                echo json_encode(["status" => "error", "message" => "No data found"]);
            }
        } else {
            // Jika query gagal
            echo json_encode(["status" => "error", "message" => "Database query failed"]);
        }
    } elseif ($input_data['action'] == 'update_general') {
        $site_title = $input_data['site_title'] ?? '';
        $site_about = $input_data['site_about'] ?? '';

        // Validasi data
        if (!$site_title || !$site_about) {
            echo json_encode(["status" => "error", "message" => "Missing required fields"]);
            exit;
        }

        // Query untuk update data pengaturan
        $q = "UPDATE `setting` SET `site_title`=?, `site_about`=? WHERE `no`=?";
        $values = [$site_title, $site_about, 1];

        // Eksekusi query update
        $res = update($q, $values, 'ssi'); // Fungsi update yang sesuai

        if ($res) {
            echo json_encode(["status" => "success", "message" => "Settings updated successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update settings"]);
        }
    }
}
