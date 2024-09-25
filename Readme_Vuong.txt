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

Deadline: Trong tuần này (hoặc cho đến khi Thắng PM bắt đầu dí)
