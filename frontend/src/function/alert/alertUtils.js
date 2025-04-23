import Swal from 'sweetalert2';

const defaultTitle = 'Thông báo';

export const showBasicAlert = (icon, title, message, footer = '', timer) => {
  Swal.fire({
    icon: icon || 'error',
    title: title || defaultTitle,
    text: message,
    footer: footer,
    timer: timer || 0,
    customClass: {
      confirmButton: 'btn-confirm'
    },
  });
};




