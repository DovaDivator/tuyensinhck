Updated by Dova v2:
- Quyền htaccess allow AJAX requests 
    Lệnh: xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    <> Nếu anh chưa biết thì AJAX là một phần của js cho phép thực hiện form mà không tải lại trang
- Mật khẩu bây giờ chỉ chấp nhận chữ ASCII (hiện tại vẫn chưa có cách chặn người dùng nhập UTF-8 hiệu quả)
- Sửa lại cấu trúc $_SESSION trong login:
    + $_SESSION['user'] bao gồm các khóa [username, id, role]
    + Thay vì kiểm tra is_logged_in bây giờ sẽ kiểm tra sự tồn tại của user (đang thử nghiệm, có thể sẽ có các bước kiểm tra nâng cao hơn)

Cập nhập dự kiến liên quan:
- AJAX lên đăng nhập, chuyển trang khi đăng nhập thành công.
- Cấp quyền lại hệ thống theo $_SESSION['user'] thay vì kiểm tra $_SESSION[is_logged_in]
- Hiển thị người dùng theo thông tin $_SESSION[user]

Công việc:
- Làm trang form chỉnh sửa thông tin/mật khẩu khoa học (không cần làm css)
Tips: có thể thử AJAX

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
(optional) Chỉnh sửa thông báo đăng nhập thành công hợp lý
Deadline: 20h 22/9/2024 :v

báo cáo 22/9 by Vương:
    - đã thêm phân luồng + thông báo đăng nhập chọn lọc quyền (anh muốn test vào đổi role trong login)
    - em ko biết nên sắp xếp front như nào nên em chỉ để trang trống
    - còn 3 trang chủ admin, student, teacher thì em tạo trống ra đó 
    - mục chỉnh sửa là tính năng của trang hồ sơ chi tiết ( side/CTHS.php ) và nó là trang chung nên e sẽ để trong mục side là trang chung
    - phiên xử lý đăng nhập yêu cầu ở mỗi trang ( anh có thể xài message để thông báo nhưng em chưa nghĩ ra logic lưu nên để sau )
=======
Deadline: N/A (cho đến khi Thắng PM bắt đầu dí)
>>>>>>> e9f4a1c (update công việc)
=======
Deadline: Trong tuần này (hoặc cho đến khi Thắng PM bắt đầu dí)
>>>>>>> f41f217 (update vá gấp)
<<<<<<< HEAD
x
=======
=======
Deadline: Trong tuần này (hoặc cho đến khi Thắng PM bắt đầu dí)
>>>>>>> 2a47d47965ae2a53c5cbe13f6b38375dc275a797
>>>>>>> d0061716b92d00aec80c33a07f4e3966dd68244e
