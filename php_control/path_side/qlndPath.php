<link rel="stylesheet" href="../assets/style/table.css?v=<?php echo filemtime("../assets/style/table.css")?>">
<div class="body_container">
    <div class="body_path">
        <h1>Danh sách người dùng</h1>
        <div class="UI_qlnd_container">
            <?php if ($_SESSION['user']['role'] === 'Admin'):?>
            <h3 class='title_heading'>Danh sách giáo viên:</h3>
            <div class="table_body_scroll" style="height:500px;">
               <table class="choose_list danh_sach_ng" id="danh_sach_giao_vien">
                   <thead>
                       <tr>
                           <th id='ma_gv'>Mã giáo viên</th>
                           <th id='ten_gv'>Tên giáo viên</th>
                           <th id='khoa'>Khoa</th>
                           <th id='nganh_quan_ly'>Ngành phụ trách</th>
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
            <div style="margin: 30px auto; width: 80%; align-items:center; height: 1px; background-color: grey;"></div>
            <?php endif; ?>
            <h3 class='title_heading'>Danh sách tuyển sinh:</h3>
            <div class="table_body_scroll" style="min-height: 500px; max-height:700px;">
               <table class="choose_list danh_sach_ng" id="danh_sach_sinh_vien">
                   <thead>
                       <tr>
                           <th id='ma_sv'>Mã tuyển sinh</th>
                           <th id='ten_sv'>Tên sinh viên</th>
                           <th id='date_reg'>Ngày đăng ký</th>
                           <th id='khoi_xt'>Khối xét tuyển</th>
                           <th id='hoso'>Trạng thái hồ sơ</th>
                           <th id='dk'>Trạng thái đăng ký</th>
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
        </div>
    </div>
</div>