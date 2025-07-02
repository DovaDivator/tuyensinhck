import React, { useState, JSX, useEffect } from 'react';
import { Link } from 'react-router-dom';
import { useAppContext } from '../../../context/AppContext'; // Import AppContext
import InputField from '../../ui/input/InputField';
import Button from '../../ui/input/Button';
import './SwitchPasswordForm.scss';
import LogoGuest from '../../ui/components/LogoGuest';
import { checkValidSubmitUtils} from '../../../function/triggers/checkValidSubmitUtils';
import { InputOptions } from '../../../classes/InputOption';
import { InputValids } from '../../../classes/InputValids';
import { forgotPassword } from '../../../function/user-action/forgotPassword';
import { FormDataProps, ErrorLogProps, DataOptionsProps, DataValidsProps } from '../../../types/FormInterfaces';
import { useAuth } from "../../../context/AuthContext";
import { showToast } from '../../../function/alert/alertToast';
import { alertBasic } from '../../../function/alert/alertBasic';

const SwitchPasswordForm = ():JSX.Element => {
  const { isLoading, setIsLoading } = useAppContext();
//   const { user, login, setUserByRole} = useAuth();

  const [formData, setFormData] = useState<FormDataProps>({
    currentPassword: '',
    newPassword: '',
    comfirmPassword: ''
  });


  const [errors, setErrors] = useState<ErrorLogProps>({
    currentPassword: '',
    newPassword: '',
    comfirmPassword: ''
  });

  const [isSubmitting, setIsSubmitting] = useState<boolean>(false);

  const options: DataOptionsProps = {
    currentPassword: new InputOptions({ restrict: true }),
    newPassword: new InputOptions({ restrict: true }),
    comfirmPassword: new InputOptions({ restrict: true })
  };

  const valids: DataValidsProps = {
    currentPassword: new InputValids({ minlength: 6, required: true, matchType: ['password'] }),
    newPassword: new InputValids({ minlength: 6, required: true, matchType: ['password'] }),
    comfirmPassword: new InputValids({ minlength: 6, required: true, matchType: ['password'], match: "newPassword"})
  };

  const handleSubmit = async (e: React.FormEvent<HTMLFormElement>): Promise<void> => {
    e.preventDefault();
    setIsSubmitting(true);
    const validResult = await checkValidSubmitUtils( formData, valids, setErrors);
    if (!validResult) {
      showToast('error', '', 'Vui lòng kiểm tra lại thông tin!');
      setIsSubmitting(false);
      return;
    }
    // setIsLoading(true);
    // const success = await login(String(formData.username), String(formData.password));
    const success = true;
    // setIsLoading(false);
    if (success) {
        showToast('success','', 'Đăng nhập thành công!');
      } else {
        alertBasic({
          icon: 'error',
          title: 'Đăng nhập thất bại!',
          message: 'Tên đăng nhập hoặc mật khẩu không đúng!'
        });
      }
    setIsSubmitting(false);
  };

  return (
    <section className="switch-password-form-container">
      <h3>Thay đổi mật khẩu</h3>
      <form
        onSubmit={handleSubmit}
        id="switch-password-form"
        noValidate
      >
        <InputField
          type="password"
          name="currentPassword"
          id="currentPassword"
          placeholder="Mật khẩu cũ"
          value={formData.currentPassword}
          maxLength={20}
          formData={formData}
          setFormData={setFormData}
          options={options.currentPassword}
          errors={errors}
          setErrors={setErrors}
          valids={valids.currentPassword}
          isSubmiting={isSubmitting}
        />
        <InputField
          type="password"
          name="newPassword"
          id="newPassword"
          placeholder="Mật khẩu mới"
          value={formData.newPassword}
          maxLength={20}
          formData={formData}
          setFormData={setFormData}
          options={options.newPassword}
          errors={errors}
          setErrors={setErrors}
          valids={valids.newPassword}
          isSubmiting={isSubmitting}
        />
        <InputField
          type="password"
          name="comfirmPassword"
          id="comfirmPassword"
          placeholder="Xác nhận mật khẩu"
          value={formData.comfirmPassword}
          maxLength={20}
          formData={formData}
          setFormData={setFormData}
          options={options.comfirmPassword}
          errors={errors}
          setErrors={setErrors}
          valids={valids.comfirmPassword}
          isSubmiting={isSubmitting}
        />
        <Button
          type="submit"
          text={isLoading ? 'Đang xác nhận...' : 'Cập nhật'}
          disabled={isLoading}
        />
      </form>
    </section>
  );
};

export default SwitchPasswordForm;