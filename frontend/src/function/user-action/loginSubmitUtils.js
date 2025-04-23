import { validateInput } from '../conditions/validateInput';

import { showToast } from '../alert/alertToast';
import { showBasicAlert } from '../alert/alertUtils';

export const loginSubmitUtils = (e, formData, valids, setIsLoading, setErrors) => {
  // e.preventDefault();
  let allValid = true;
  const newErrors = {};

  Object.keys(valids).forEach((field) => {
    const result = validateInput(field, formData[field], valids[field], formData);
    Object.assign(newErrors, result);
    if (Object.values(result)[0]) allValid = false;
  });

  setErrors(newErrors);

  if (!allValid) {
    showToast(null, null, 'Vui lòng kiểm tra lại thông tin!');
    return;
  }

  // Nếu hợp lệ, thực hiện đăng nhập
  setIsLoading(true);
  setTimeout(() => {
    console.log('Login data:', formData);
    showBasicAlert('success', null, 'Đăng nhập thành công!');
    setIsLoading(false);
  }, 1000);
};
