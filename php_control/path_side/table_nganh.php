<link rel="stylesheet" href="../assets/style/table.css?v=<?php echo filemtime("../assets/style/table.css")?>"> 
<<<<<<< HEAD
<div class="table_body_scroll" style="height:600px;">
    <table class="choose_list" id="top_tuyen_sinh">
        <thead>
            <tr>
                <th id='ma_nganh'>Mã tuyển sinh</th>
                <th id='ten_nganh'>Tên ngành</th>
                <?php if ($_SESSION['user']['role'] != 'Student') { 
                    echo "<th id='so_luong_dang_ky'>Số lượng đăng ký</th>";
                }?>
                <th id='to_hop_xet_tuyen'>Tổ hợp xét tuyển</th>
                <th id='thoi_gian'>Thời gian tuyển sinh</th>
            </tr>
        </thead>
        <tbody id="course_table_tuyen_sinh" >
            <script>
                var userRole = <?php echo json_encode($_SESSION['user']['role']); ?>;
                loadAndRenderCourses(userRole);
            </script>
        </tbody>
    </table>
</div>
=======
<table class="choose_list" id="top_tuyen_sinh">
    <thead>
        <tr>
            <th id='ma_nganh'>Mã tuyển sinh</th>
            <th id='ten_nganh'>Tên ngành</th>
            <th id='chi_tieu_du_kien'>Chỉ tiêu dự kiến</th>
            <?php if ($_SESSION['user']['role'] != 'Student') { 
                echo "<th id='so_luong_dang_ky'>Số lượng đăng ký</th>";
            }?>
            <th id='to_hop_xet_tuyen'>Tổ hợp xét tuyển</th>
            <th id='thoi_gian'>Thời gian tuyển sinh</th>
            <th id='ghi_chu'>Ghi chú</th>
        </tr>
    </thead>
    <tbody id="course-table-body">
        <script>
            var userRole = <?php echo json_encode($_SESSION['user']['role']); ?>;
            loadAndRenderCourses(userRole);
        </script>
    </tbody>
</table>
>>>>>>> 2a47d47965ae2a53c5cbe13f6b38375dc275a797
