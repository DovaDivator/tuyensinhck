<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Nhận dữ liệu từ form
    $ten = $_POST['ten'] ?? '';
    $chi_tieu = $_POST['chi_tieu'] ?? '';
    $chuong_trinh = $_POST['chuong_trinh'] ?? '';
    $to_hop = $_POST['to_hop'] ?? '';
    $date_end_day = $_POST['date_end_day'] ?? '';
    $date_end_time = $_POST['date_end_time'] ?? '';
    $diem_chuan = $_POST['diem_chuan'] ?? '';

    // Hiển thị dữ liệu đã nhận
    echo "<h1>Dữ Liệu Nhận Được</h1>";
    echo "<p><strong>Tên:</strong> $ten</p>";
    echo "<p><strong>Chỉ Tiêu:</strong> $chi_tieu</p>";
    echo "<p><strong>Chương Trình:</strong> $chuong_trinh</p>";
    echo "<p><strong>Tổ Hợp:</strong> $to_hop</p>";
    echo "<p><strong>Ngày Kết Thúc:</strong> $date_end_day</p>";
    echo "<p><strong>Giờ Kết Thúc:</strong> $date_end_time</p>";
    echo "<p><strong>Điểm Chuẩn:</strong> $diem_chuan</p>";
} else {
    // Nếu không phải POST, hiển thị form
    echo "<p>Không có dữ liệu từ form gửi đến.</p>";
}
?>
