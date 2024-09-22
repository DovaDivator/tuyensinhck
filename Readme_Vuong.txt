nút  đăng xuất vì lý do nào đó em phải double click nó ms  out  để mai em sửa nốt

Updated by Dova v1:
- Sửa bug từ file LoginCheck.php và LogOut.php
- (Comment dòng 8 file Index.php) hàm php in đè giao diện trang
- Kích hoạt logout từ nút
- Thay thế header logout lên cơn
- Xóa một số text thừa (có thể chưa hết)

Công việc:
- Cấu hình lại các dòng nav của sidebar dựa trên yêu cầu cuối kỳ
    ! Lưu ý: nhớ thêm mục "Chỉnh sửa thông tin" 
- Tạo hàm GET khi ấn vào các mục trên sidebar thì thay include trong div.main-content (index.php)
bằng các trang kia
- Phân bổ các file php hợp lý trong đó:
    + Các trang chung để vào thư mục php_control/path. Trong file php, nếu phân luồng thì tạo đường
    dẫn vào các mục (admin/student/teacher)body_path
    + Các trang riêng rẽ dẫn thẳng vào mục (admin/student/teacher)_path
(có thể ghi chú trong đó cần tạo những gì để em design)

(optional) Chỉnh sửa thông báo đăng nhập thành công hợp lý
Deadline: 20h 22/9/2024 :v

báo cáo 22/9 by Vương:
    - đã thêm phân luồng + thông báo đăng nhập chọn lọc quyền (anh muốn test vào đổi role trong login)
    - em ko biết nên sắp xếp front như nào nên em chỉ để trang trống
    - còn 3 trang chủ admin, student, teacher thì em tạo trống ra đó 
    - mục chỉnh sửa là tính năng của trang hồ sơ chi tiết ( side/CTHS.php ) và nó là trang chung nên e sẽ để trong mục side là trang chung
    - phiên xử lý đăng nhập yêu cầu ở mỗi trang ( anh có thể xài message để thông báo nhưng em chưa nghĩ ra logic lưu nên để sau )
