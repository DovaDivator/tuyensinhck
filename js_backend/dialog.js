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