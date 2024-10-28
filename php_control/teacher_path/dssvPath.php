<link rel="stylesheet" href="../assets/style/table.css?v=<?php echo filemtime("../assets/style/table.css")?>">
<div class="body_container">
    <div class="body_path">
        <h1>Danh sách sinh viên</h1>
        <div class='linediv' style="align-items: flex-start;">
            <h2 style='margin-left: 50px; color:#DC143C; margin-top: 0;'>Ngành đào tạo:</h2>
            <form method="get"  style='margin-left: 20px;'>
                <select name='ma_nganh_sv' style=' min-width: 350px;' onchange="this.form.submit()">
                    <?php
                        $danh_nganh = [
                            (object) ['ma_nganh' => 'CNTT', 'ten_nganh' => 'Công nghệ thông tin'],
                            (object) ['ma_nganh' => 'QTKD', 'ten_nganh' => 'Quản trị kinh doanh'],
                            (object) ['ma_nganh' => 'KETOAN', 'ten_nganh' => 'Kế toán'],
                            (object) ['ma_nganh' => 'LUAT', 'ten_nganh' => 'Luật'],
                            (object) ['ma_nganh' => 'NN', 'ten_nganh' => 'Ngôn ngữ Anh']
                    ];
                   ?>
                   <?php foreach($danh_nganh as $nganh): ?>
                    <option value='<?php echo $nganh->ma_nganh;?>' <?php if(isset($_GET['ma_nganh_sv']) && $_GET['ma_nganh_sv'] === $nganh->ma_nganh) echo "selected";?>>
                        <?php echo $nganh->ma_nganh;?> - <?php echo $nganh->ten_nganh;?>
                    </option>
                   <?php endforeach;?>
                </select>
            </form>
        </div>
        <div class="UI_qlnd_container">
            <div class="table_body_scroll" style="height:500px;">
               <table class="choose_list danh_sach_ng" id="danh_sach_sv_nganh">
                   <thead>
                        <tr>
                           <th id='ma_sv'>Mã tuyển sinh</th>
                           <th id='ten_sv'>Tên sinh viên</th>
                           <th id='ngay_sinh'>Ngày sinh</th>
                           <th id='que_quan'>Quê quán</th>
                           <th id='khoi_xt'>Tổ hợp xét tuyển</th>
                           <th id='diem'>Điểm</th>
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