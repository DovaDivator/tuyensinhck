import Swal from 'sweetalert2';
import { validateText } from '../conditions/validateText';
import { InputValids } from '../../classes/InputValids';

export const alertForgotPassword = async () => {
  const name = 'emailForgot';
  const inputValids = new InputValids({ required: true, matchType: ['email'] });

  return await Swal.fire({
    title: 'Nhập email để khôi phục mật khẩu',
    input: 'email',
    inputPlaceholder: 'Nhập email của bạn',
    showCancelButton: true,
    confirmButtonText: 'Gửi',
    cancelButtonText: 'Hủy',
    customClass: {
      confirmButton: 'btn-confirm',
      cancelButton: 'btn-cancel'
    },
    inputValidator: (value) => {
      const feedback = validateText(name, value, inputValids);
      return feedback[name] !== '' ? feedback[name] : null;
    }
  });
};
