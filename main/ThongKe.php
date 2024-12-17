<!-- Hàm kiểm tra trang đã đăng nhập chưa -->
<?php

session_start();
if (isset($_SESSION['user'])) {
    if (!($_SESSION['user']['role'] === "Admin")) {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Tuyển sinh - Thống kê số liệu</title>
    <link rel="icon" href="../assets/images/logo.png?v=<?php echo filemtime('../assets/images/logo.png'); ?>" type="image/png">
    <link rel="stylesheet" href="../assets/style/style.css?v=<?php echo filemtime('../assets/style/style.css'); ?>">
    <link rel="stylesheet" href="../assets/style/admin_path.css?v=<?php echo filemtime("../assets/style/admin_path.css")?>">
    <script src="../js_backend/events.js?v=<?php echo filemtime('../js_backend/events.js'); ?>"></script>
</head>
<body>
    <div class="body_container">
        <?php include '../php_control/path_side/nav_toggle.php'; ?>
        <?php include '../php_control/path_side/sidebar.php'; ?>

        <div class="notification layout" id="notificationLayout">
            <?php include '../php_control/path_side/notification.php'; ?>
        </div>
        
        <div class="right-side">
            <?php include '../php_control/path_side/toolbar.php'; ?>
            <!-- Nội dung chính kết nối trang -->
            <div class="main-content">
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <div class="body_container">
                <div class="body_path">
                <h1>Thống kê chi tiết</h1>
                <!-- Điều hướng thông số -->
                <div class="linediv">
                <p>&emsp;&emsp;Hiển thị thông tin:&ensp;</p>
                    <form method="GET">
                        <select id="chart_info_options" name="chart_info_options"  onchange="this.form.submit()">
                            <option value="chart1"
                                <?php
                                    if(!isset($_GET['chart_info_options']) || $_GET['chart_info_options'] === 'chart1'){
                                        echo "selected";
                                    }
                                ?>
                            >Thông kê hồ tuyển sinh 1</option>
                            <option value="chart2"
                                <?php
                                    if(isset($_GET['chart_info_options']) && $_GET['chart_info_options'] === 'chart2'){
                                        echo "selected";
                                    }
                                ?>
                            >Thông kê hồ sơ tuyển sinh 2</option>
                        </select>
                    </form>
                </div>
                <!-- Biểu đồ -->
                <h3 style='text-align: center;'>Thống kê hồ sơ</h3>
                <div class="chart_div">
                    <canvas id="chart"></canvas>
                </div>
                <!-- Thông số đánh giá -->
                <div class="info_div">
                    <h4>Thông số đánh giá: </h4>
                    <p>Tổng số:ewqeqeq</p>
                    <p>Trnone !important;!important;ình: eweqeq</p>
                    <p>Trung bình: eweqeq</p>
                    <p>Trung bình: eweqeq</p>
                    <p>Trung bình: eweqeq</p>
                    <p>Trung bình: eweqeq</p>
                </div> 

            <script>
                    const ctx = document.getElementById('chart').getContext('2d');
                    const myChart = new Chart(ctx, {
                        type: 'bar', 
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'], 
                            datasets: [{
                                label: 'Doanh thu hàng tháng',
                                data: [1200, 1900, 3000, 5000, 2200, 3200], 
                                backgroundColor: [
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)',
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)',
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return tooltipItem.dataset.label + ': $' + tooltipItem.raw;
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    beginAtZero: true,
                                    grid: {
                                        display: false
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.1)',
                                    },
                                    ticks: {
                                        callback: function(value) {
                                            return '$' + value;
                                        }
                                    }
                                }
                            }
                        }
                    });
                </script>
    
            </div>
        </div>
    </div>
</body>
</html>


<!-- Log kiểm tra dữ liệu, không được xóa -->
<?php
echo '<script>';
echo 'var sessionData = ' . json_encode($_SESSION) . ';';
echo 'console.log("Session Data:", sessionData);';

echo 'var getData = ' . json_encode($_GET) . ';';
echo 'console.log("GET Data:", getData);';

echo 'var postData = ' . json_encode($_POST) . ';';
echo 'console.log("POST Data:", postData);';
echo '</script>';
?>