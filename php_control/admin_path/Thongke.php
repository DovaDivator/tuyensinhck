<link rel="stylesheet" href="../assets/style/thongke.css?v=<?php echo filemtime("../assets/style/thongke.css")?>">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="body_path">
    <h1>Thống kê chi tiết</h1>
    <!-- Điều hướng thông số -->
    <div class="linediv">
    <p>&emsp;&emsp;Hiển thị thông tin:&ensp;</p>
        <form>
            <select id="chart_info_options" name="chart_info_options">
                <option value="chart1">Thông kê hồ sơ thịt chó</option>
                <option value="chart2">Thông kê hồ sơ thịt mèo</option>
                <option value="chart3">Thông kê hồ sơ thịt chuột</option>
                <option value="chart4">Thông kê hồ sơ thịt Thắng</option>
            </select>
        </form>
        <button type="submit" class="icon-button">
        <img src="../assets/icon/filter.png?v=<?php echo filemtime("../assets/icon/filter.png"); ?>" 
        alt="Tùy chọn" title="Tùy chọn" class="chart_option" onclick="showChartOption('options layout chart_div_options')">
        </button>
    </div>
    <div class="chart_div_options options layout" onsubmit="hideDiv()">
        <form method="GET">
            <div class="input_div">
                <label>Loại biểu đồ: </label>
                <select id="chart_type_options" name="chart_type_options">
                    <option value="bar">Biểu đồ cột</option>
                    <option value="line">Biểu đồ đường</option>
                    <option value="pie">Biểu đồ tròn</option>
                </select>
            </div>
            <div class="button_div">
                <input type="submit" value="Xác nhận" name="set_change_chart">
            </div>
        </form>
    </div>
    <!-- Biểu đồ -->
    <h3>Thống kê hồ sơ thịt chó</h3>
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
