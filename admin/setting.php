<?php 
    require('inc/essentials.php');
    adminLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Settings</title>
    <?php require('inc/links.php'); ?>
</head>
<body class="bg-light">

    <?php require('inc/header.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">SETTING</h3>

                <!-- General Setting Section -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">General Setting</h5>
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#general-se">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                        </div>
                        <h6 class="card-subtitle mb-1 fw-bold">Site Title</h6>
                        <p class="card-text" id="site_title"></p>
                        <h6 class="card-subtitle mb-1 fw-bold">About Us</h6>
                        <p class="card-text" id="site_about"></p>
                    </div>
                </div>

                <!-- General Setting Modal -->
                <div class="modal fade" id="general-se" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="general-form">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">General Setting</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Site Title</label>
                                        <input type="text" name="site_title" id="site_title_inp" class="form-control shadow-none" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">About Us</label>
                                        <textarea name="site_about" id="site_about_inp" class="form-control shadow-none" rows="6" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="site_title.value = general_data.site_title, site_title.value = general_data.site_about" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                                    <button type="button" onclick="updt_general(site_title.value,site_about.value)" class="btn custom-bg text-white shadow-none" onclick="update_general()">SUBMIT</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php require('inc/scripts.php'); ?>
    <script>
        let general_data;

        // Function to fetch general settings
        function get_general() {
            let site_title = document.getElementById('site_title');
            let site_about = document.getElementById('site_about');

            let site_title_inp = document.getElementById('site_title_inp');
            let site_about_inp = document.getElementById('site_about_inp');            

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/setting_crud.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function () {
                if (this.status == 200) {
                    general_data = JSON.parse(this.responseText);

                    site_title.innerText = general_data.site_title;
                    site_about.innerText = general_data.site_about;

                    site_title_inp.value = general_data.site_title;
                    site_about_inp.value = general_data.site_about;

                    // Populate modal inputs
                    document.getElementById('site_title_input').value = general_data.site_title;
                    document.getElementById('site_about_input').value = general_data.site_about;
                } else {
                    console.error("Failed to fetch settings");
                }
            };

            xhr.send("action=get_general");
        }

        // Function to update general settings
        function update_general() {
            let site_title_input = document.getElementById('site_title_input').value.trim();
            let site_about_input = document.getElementById('site_about_input').value.trim();

            if (site_title_input == "" || site_about_input == "") {
                alert("Please fill out all fields.");
                return;
            }

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/setting_crud.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function () {
                if (this.status == 200) {
                    if (this.responseText == "success") {
                        alert("Settings updated successfully!");
                        get_general();
                        let modal = bootstrap.Modal.getInstance(document.getElementById('general-se'));
                        modal.hide();
                    } else {
                        alert("Failed to update settings. Please try again.");
                    }
                }
            };

            let data = `action=update_general&site_title=${encodeURIComponent(site_title_input)}&site_about=${encodeURIComponent(site_about_input)}`;
            xhr.send(data);
        }

        // Load general settings on page load
        window.onload = function () {
            get_general();
        };
    </script>
</body>
</html>
