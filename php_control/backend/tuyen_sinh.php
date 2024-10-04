<?php
    session_start();

$courses = [
    [
        'ma_tuyen_sinh' => 'CS101',
        'ten_nganh' => 'Khoa học máy tính',
        'chi_tieu' => 50,
        'to_hop_xet_tuyen' => 'A00, A01',
        'thoi_gian_tuyen_sinh' => '2024-2025',
        'ghi_chu' => ''
    ],
    [
        'ma_tuyen_sinh' => 'IT102',
        'ten_nganh' => 'Công nghệ thông tin',
        'chi_tieu' => 60,
        'to_hop_xet_tuyen' => 'A00, A01',
        'thoi_gian_tuyen_sinh' => '2024-2025',
        'ghi_chu' => ''
    ],
    [
        'ma_tuyen_sinh' => 'SE103',
        'ten_nganh' => 'Kỹ thuật phần mềm',
        'chi_tieu' => 40,
        'to_hop_xet_tuyen' => 'A00, A01',
        'thoi_gian_tuyen_sinh' => '2024-2025',
        'ghi_chu' => ''
    ],
    [
        'ma_tuyen_sinh' => 'AI104',
        'ten_nganh' => 'Trí tuệ nhân tạo',
        'chi_tieu' => 30,
        'to_hop_xet_tuyen' => 'A00, A01',
        'thoi_gian_tuyen_sinh' => '2024-2025',
        'ghi_chu' => ''
    ],
    [
        'ma_tuyen_sinh' => 'DS105',
        'ten_nganh' => 'Khoa học dữ liệu',
        'chi_tieu' => 35,
        'to_hop_xet_tuyen' => 'A00, A01',
        'thoi_gian_tuyen_sinh' => '2024-2025',
        'ghi_chu' => ''
    ],
    [
        'ma_tuyen_sinh' => 'CE106',
        'ten_nganh' => 'Kỹ thuật máy tính',
        'chi_tieu' => 45,
        'to_hop_xet_tuyen' => 'A00, A01',
        'thoi_gian_tuyen_sinh' => '2024-2025',
        'ghi_chu' => ''
    ],
    [
        'ma_tuyen_sinh' => 'IS107',
        'ten_nganh' => 'Hệ thống thông tin',
        'chi_tieu' => 50,
        'to_hop_xet_tuyen' => 'A00, A01',
        'thoi_gian_tuyen_sinh' => '2024-2025',
        'ghi_chu' => ''
    ],
    [
        'ma_tuyen_sinh' => 'NT108',
        'ten_nganh' => 'Mạng máy tính',
        'chi_tieu' => 40,
        'to_hop_xet_tuyen' => 'A00, A01',
        'thoi_gian_tuyen_sinh' => '2024-2025',
        'ghi_chu' => ''
    ],
    [
        'ma_tuyen_sinh' => 'CS109',
        'ten_nganh' => 'An toàn thông tin',
        'chi_tieu' => 30,
        'to_hop_xet_tuyen' => 'A00, A01',
        'thoi_gian_tuyen_sinh' => '2024-2025',
        'ghi_chu' => ''
    ],
    [
        'ma_tuyen_sinh' => 'IT110',
        'ten_nganh' => 'Công nghệ phần mềm',
        'chi_tieu' => 55,
        'to_hop_xet_tuyen' => 'A00, A01',
        'thoi_gian_tuyen_sinh' => '2024-2025',
        'ghi_chu' => ''
    ],
    [
        'ma_tuyen_sinh' => 'CS101',
        'ten_nganh' => 'Khoa học máy tính',
        'chi_tieu' => 50,
        'to_hop_xet_tuyen' => 'A00, A01',
        'thoi_gian_tuyen_sinh' => '2024-2025',
        'ghi_chu' => ''
    ],
    [
        'ma_tuyen_sinh' => 'IT102',
        'ten_nganh' => 'Công nghệ thông tin',
        'chi_tieu' => 60,
        'to_hop_xet_tuyen' => 'A00, A01',
        'thoi_gian_tuyen_sinh' => '2024-2025',
        'ghi_chu' => ''
    ],
    [
        'ma_tuyen_sinh' => 'SE103',
        'ten_nganh' => 'Kỹ thuật phần mềm',
        'chi_tieu' => 40,
        'to_hop_xet_tuyen' => 'A00, A01',
        'thoi_gian_tuyen_sinh' => '2024-2025',
        'ghi_chu' => ''
    ],
    [
        'ma_tuyen_sinh' => 'AI104',
        'ten_nganh' => 'Trí tuệ nhân tạo',
        'chi_tieu' => 30,
        'to_hop_xet_tuyen' => 'A00, A01',
        'thoi_gian_tuyen_sinh' => '2024-2025',
        'ghi_chu' => ''
    ],
    [
        'ma_tuyen_sinh' => 'DS105',
        'ten_nganh' => 'Khoa học dữ liệu',
        'chi_tieu' => 35,
        'to_hop_xet_tuyen' => 'A00, A01',
        'thoi_gian_tuyen_sinh' => '2024-2025',
        'ghi_chu' => ''
    ],
    [
        'ma_tuyen_sinh' => 'CE106',
        'ten_nganh' => 'Kỹ thuật máy tính',
        'chi_tieu' => 45,
        'to_hop_xet_tuyen' => 'A00, A01',
        'thoi_gian_tuyen_sinh' => '2024-2025',
        'ghi_chu' => ''
    ],
    [
        'ma_tuyen_sinh' => 'IS107',
        'ten_nganh' => 'Hệ thống thông tin',
        'chi_tieu' => 50,
        'to_hop_xet_tuyen' => 'A00, A01',
        'thoi_gian_tuyen_sinh' => '2024-2025',
        'ghi_chu' => ''
    ],
    [
        'ma_tuyen_sinh' => 'NT108',
        'ten_nganh' => 'Mạng máy tính',
        'chi_tieu' => 40,
        'to_hop_xet_tuyen' => 'A00, A01',
        'thoi_gian_tuyen_sinh' => '2024-2025',
        'ghi_chu' => ''
    ],
    [
        'ma_tuyen_sinh' => 'CS109',
        'ten_nganh' => 'An toàn thông tin',
        'chi_tieu' => 30,
        'to_hop_xet_tuyen' => 'A00, A01',
        'thoi_gian_tuyen_sinh' => '2024-2025',
        'ghi_chu' => ''
    ],
    [
        'ma_tuyen_sinh' => 'IT110',
        'ten_nganh' => 'Công nghệ phần mềm',
        'chi_tieu' => 55,
        'to_hop_xet_tuyen' => 'A00, A01',
        'thoi_gian_tuyen_sinh' => '2024-2025',
        'ghi_chu' => ''
    ]
];

if ($_SESSION['user']['role'] != 'Student') {
    foreach ($courses as &$course) {
        $course['so_luong_dang_ky'] = 0; 
    }
}

header('Content-Type: application/json');
echo json_encode($courses);
?>
