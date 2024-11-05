function WarmingDialog(title, des){
    Swal.fire({
        title: title,
        text: des,
        icon: "warning",
        confirmButtonText: "OK"
    });
}

function ErrorDialog(title, des){
    Swal.fire({
        title: title,
        text: des,
        icon: "error",
        confirmButtonText: "OK"
    });
}

function SuccessDialog(title, des){
    Swal.fire({
        title: title,
        text: des,
        icon: "success",
        confirmButtonText: "OK"
    });
}

function ConfirmDialog(title, des, confirmText, cancelText) {
    return Swal.fire({
        title: title,
        text: des,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: confirmText,
        cancelButtonText: cancelText
    }).then((result) => {
        return result.isConfirmed; // Trả về true nếu người dùng nhấn "Xác nhận", ngược lại trả về false
    });
}