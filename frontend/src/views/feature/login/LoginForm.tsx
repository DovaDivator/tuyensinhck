import React, { useState, JSX } from 'react';
import { Link } from 'react-router-dom';
import { useAppContext } from '../../../context/AppContext'; // Import AppContext
import InputField from '../../ui/input/InputField';
import Button from '../../ui/input/Button';
import './LoginForm.scss';
import LogoGuest from '../../ui/components/LogoGuest';
import { loginSubmitUtils } from '../../../function/user-action/loginSubmitUtils';
import { InputOptions } from '../../../classes/InputOption';
import { InputValids } from '../../../classes/InputValids';
import { forgotPassword } from '../../../function/user-action/forgotPassword';
import { FormDataProps, ErrorLogProps, DataOptionsProps, DataValidsProps } from '../../../types/FormInterfaces';

const LoginForm = ():JSX.Element => {
  const { isLoading, setIsLoading } = useAppContext();

  const [formData, setFormData] = useState<FormDataProps>({
    username: '',
    password: ''
  });


  const [errors, setErrors] = useState<ErrorLogProps>({
    username: '',
    password: ''
  });

  const [isSubmiting, setIsSubmiting] = useState<boolean>(false);

  const options: DataOptionsProps = {
    username: new InputOptions({ restrict: true }),
    password: new InputOptions({ restrict: true })
  };

  const valids: DataValidsProps = {
    username: new InputValids({ required: true, matchType: ['email', 'phone'] }),
    password: new InputValids({ minlength: 6, required: true, matchType: ['password'] })
  };

  const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
    e.preventDefault();
    setIsSubmiting(true);
    await loginSubmitUtils({ e, formData, valids, setIsLoading, setErrors });
    setIsSubmiting(false);
  };

  return (
    <section className="login-form-container">
      <LogoGuest />
      <h1>Đăng nhập</h1>
      <form
        onSubmit={handleSubmit}
        id="login-form"
        noValidate
      >
        <InputField
          type="text"
          name="username"
          id="username"
          placeholder="Email hoặc SĐT"
          value={formData.username}
          maxLength={255}
          formData={formData}
          setFormData={setFormData}
          options={options.username}
          errors={errors}
          setErrors={setErrors}
          valids={valids.username}
          isSubmiting={isSubmiting}
        />
        <InputField
          type="password"
          name="password"
          id="password"
          placeholder="Mật khẩu"
          value={formData.password}
          maxLength={20}
          formData={formData}
          setFormData={setFormData}
          options={options.password}
          errors={errors}
          setErrors={setErrors}
          valids={valids.password}
          isSubmiting={isSubmiting}
        />
        <Button
          type="submit"
          text={isLoading ? 'Đang xác nhận...' : 'Đăng nhập'}
          disabled={isLoading}
        />
      </form>
      <Link to="/dang-ky" className="register-link">Đăng ký tài khoản sinh viên ở đây!</Link>
      <a href="" className="forgot-link" onClick={(e) => forgotPassword(e)}>Quên mật khẩu?</a>
    </section>
  );
};

export default LoginForm;