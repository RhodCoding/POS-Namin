<?php
session_start();
// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Bakery POS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <?php include 'components/navbar.php'; ?>

            <!-- Main content -->
            <main class="col-md-10 ms-sm-auto px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1>Settings</h1>
                </div>

                <!-- Settings Sections -->
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <!-- Business Information -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Business Information</h5>
                            </div>
                            <div class="card-body">
                                <form id="businessForm">
                                    <div class="mb-3">
                                        <label class="form-label">Business Name</label>
                                        <input type="text" class="form-control" id="businessName">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Address</label>
                                        <textarea class="form-control" rows="2" id="businessAddress"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Contact Number</label>
                                        <input type="text" class="form-control" id="businessContact">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <!-- Receipt Settings -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Receipt Settings</h5>
                            </div>
                            <div class="card-body">
                                <form id="receiptForm">
                                    <div class="mb-3">
                                        <label class="form-label">Receipt Header</label>
                                        <textarea class="form-control" rows="2" id="receiptHeader"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Receipt Footer</label>
                                        <textarea class="form-control" rows="2" id="receiptFooter"></textarea>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="row mb-4">
                    <div class="col-12">
                        <button type="button" class="btn btn-primary" id="saveSettings">
                            <i class="bi bi-save"></i> Save Settings
                        </button>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/settings.js"></script>
</body>
</html>