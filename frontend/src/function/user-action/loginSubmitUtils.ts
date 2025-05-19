import { FormEvent } from 'react';
import { validateInput } from '../conditions/validateInput';

import { showToast } from '../alert/alertToast';
import { alertBasic } from '../alert/alertBasic';
import { FormDataProps, ErrorLogProps, DataValidsProps } from '../../types/FormInterfaces';


interface LoginSubmitProps {
  e: FormEvent<HTMLFormElement>;
  formData: FormDataProps;
  valids: DataValidsProps;
  setErrors: React.Dispatch<React.SetStateAction<ErrorLogProps>>;
  setIsLoading: React.Dispatch<React.SetStateAction<boolean>>;
}

export const loginSubmitUtils = ({e, formData, valids, setIsLoading, setErrors}: LoginSubmitProps): void => {
  // e.preventDefault();
  let allValid = true;
  const newErrors = {};

  Object.keys(valids || {}).forEach((field) => {
    const result = validateInput(field, formData[field], valids[field], formData);
    Object.assign(newErrors, result);
    if (Object.values(result)[0]) allValid = false;
  });

  setErrors(prev => ({
    ...prev,
    ...newErrors
  }));

  if (!allValid) {
    showToast(null, null, 'Vui lòng kiểm tra lại thông tin!');
    return;
  }

// Nếu hợp lệ, thực hiện đăng nhập
  setIsLoading(true);
  setTimeout(() => {
    console.log('Login data:', formData);
    alertBasic({
      icon: 'success',
      message: 'Đăng nhập thành công!'
    });
    setIsLoading(false);
  }, 1000);
};
