import React, { useState, useContext } from 'react';
import { Link } from 'react-router-dom';
import { AppContext } from '../../../context/AppContext'; // Import AppContext
import InputField from '../../input/InputField';
import Button from '../../input/Button';
import './LoginForm.scss';
import LogoGuest from '../../ui/LogoGuest';
import { loginSubmitUtils } from '../../../function/user-action/loginSubmitUtils';
import { InputOptions } from '../../../function/classes/InputOption';
import { InputValids } from '../../../function/classes/InputValids';
import { forgotPassword } from '../../../function/user-action/forgotPassword';

const LoginForm = () => {
  const { isLoading, setIsLoading } = useContext(AppContext); // Sử dụng useContext để lấy isLoading, setIsLoading

  const [formData, setFormData] = useState({
    username: '',
    password: ''
  });

  const [errors, setErrors] = useState({
    username: '',
    password: ''
  });

  const [isSubmiting, setIsSubmiting] = useState(false);

  const options = {
    username: new InputOptions({ restrict: true }),
    password: new InputOptions({ restrict: true })
  };

  const valids = {
    username: new InputValids({ required: true, matchType: ['email', 'phone'] }),
    password: new InputValids({ minlength: 6, required: true, matchType: ['password'] })
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setIsSubmiting(true);
    await loginSubmitUtils(e, formData, valids, setIsLoading, setErrors); // Sử dụng setIsLoading từ context
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
      <Link to="/register" className="register-link">Đăng ký tài khoản sinh viên ở đây!</Link>
      <a href="" className="forgot-link" onClick={(e) => forgotPassword(e)}>Quên mật khẩu?</a>
    </section>
  );
};

export default LoginForm;