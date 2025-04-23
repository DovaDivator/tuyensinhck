import Swal from "sweetalert2";

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.onmouseenter = Swal.stopTimer;
      toast.onmouseleave = Swal.resumeTimer;
    },
    background: "#fff",
    color: "#000",
    showClass: {
      popup: "toast_show"
    },
    hideClass: {
      popup: "toast_hide"
    }
  });

export const showToast = (icon, title, message) => {
    Toast.fire({
        icon: icon || "error",
        title: title || "Thông báo",
        text: message,
        
      });
}