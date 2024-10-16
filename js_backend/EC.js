// hàm này dùng khi sai thông tin như tk mk các thứ 
//function ko hoạt  động cái này phế rồi làm thủ công thôi 


function SaiTKMK(message){
    Swal.fire({
        title: "Đăng nhập thành công!",
        width: 600,
        padding: "3em",
        color: "#716add",
        background: "#fff url(https://sweetalert2.github.io/#downloadimages/trees.png)",
        html: `
        <p>${message}</p>
        <img src="../assets/animated/nyan-cat.gif" style="width: 150px; display: block; margin: 0 auto;" alt="GIF">
        `,
        backdrop: `
        rgba(0,0,123,0.4)
        `
    });
    console.log("ErrorCode.js loaded");
}  


// hàm này dùng khi cần hiển thị thông báo trước khi di chuyển đến vị trí nào đó 
function LocationError(title, location){
    Swal.fire({
        title: title,
        width: 600,
        padding: "3em",
        color: "#716add",
        background: "#fff url(https://sweetalert2.github.io/#downloadimages/trees.png)",
        html: `
        <img src="../assets/animated/nyan-cat.gif" style="width: 100px; display: block; margin: 20px auto 0;" alt="GIF">
        `,
        backdrop: `
                    rgba(0,0,123,0.4)
                `
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = location;
        }
    });
}