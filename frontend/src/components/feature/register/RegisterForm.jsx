import React, { useState, useContext } from 'react';
import { Link } from 'react-router-dom';
import { AppContext } from '../../../context/AppContext';
import InputField from '../../ui/input/InputField';
import InputChoice from '../../ui/input/InputChoice';
import Button from '../../ui/input/Button';
import PolicyTerm from '../policy/PolicyTerm';
import './RegisterForm.scss';
import LogoGuest from '../../ui/layout/LogoGuest';
import { loginSubmitUtils } from '../../../function/user-action/loginSubmitUtils';
import {alertLayoutReact} from '../../../function/alert/alertLayoutReact';

import {ChoiceGroup} from '../../../classes/ChoiceGroup';
import { InputOptions } from '../../../classes/InputOption';
import {InputValids} from '../../../classes/InputValids';
import {ChoiceValids} from '../../../classes/ChoiceValids';


const RegisterForm = () => {
  const { isLoading, setIsLoading } = useContext(AppContext);

  const [formData, setFormData] = useState({
    name: '',
    email: '',
    phone: '',
    password: '',
    passwordConfirm: '',
    checkPolicy: []
  });

  const [errors, setErrors] = useState({
    name: '',
    email: '',
    phone: '',
    password: '',
    passwordConfirm: '',
    checkPolicy: ''
  });

  const [isSubmiting, setIsSubmiting] = useState(false);

  const rawOptions = [
    {
      value: 'checkPolicy',
      label: (
        <>
          Tôi đồng ý với{' '}
          <a href="#" onClick={() => alertLayoutReact(PolicyTerm)}>
            Điều khoản sử dụng
          </a>{' '}
          của trang tuyển sinh
        </>
      )
    }
  ]; 
  const checkPolicy = new ChoiceGroup(rawOptions);

  // const optionsDefault = {trim: true, restrict: true};
  const options = {
    name: new InputOptions({}),
    email: new InputOptions({restrict: true}),
    phone: new InputOptions({restrict: true}),
    password: new InputOptions({restrict: true}),
    passwordConfirm: new InputOptions({restrict: true})
  }

  const valids = {
    name: new InputValids({required: true}),
    email: new InputValids({required: true, matchType: ['email']}),
    phone: new InputValids({required: true, matchType: ['phone']}),
    password: new InputValids({ minlength: 6, required: true, matchType: ['password']}),
    passwordConfirm: new InputValids({ minlength: 6, required: true, match: 'password', matchType: ['password']}),
    checkPolicy: new ChoiceValids({required: true})
  }

  const handleSubmit = async (e) => {
    e.preventDefault();
    setIsSubmiting(true);
    loginSubmitUtils(e, formData, valids , setIsLoading, setErrors)
    setIsSubmiting(false);
  }

  return (
    <section className="register-form-container">
      <h1>Đăng ký tài khoản tuyển sinh</h1>
      <form 
      onSubmit={handleSubmit}
        id="register-form"
        noValidate>
          <InputField
            type="text"
            name="name"
            id="name"
            placeholder="Họ và tên"
            value={formData.name}
            maxLength={255}
            formData={formData}
            setFormData = {setFormData}
            options = {options.name}
            errors = {errors}
            setErrors = {setErrors}
            valids = {valids.name}
            isSubmiting = {isSubmiting}
          />
          <InputField
            type="text"
            name="email"
            id="email"
            placeholder="Email"
            value={formData.email}
            maxLength={255}
            formData={formData}
            setFormData = {setFormData}
            options = {options.email}
            errors = {errors}
            setErrors = {setErrors}
            valids = {valids.email}
            isSubmiting = {isSubmiting}
          />
          <InputField
            type="text"
            name="phone"
            id="phone"
            placeholder="Số điện thoại"
            value={formData.phone}
            maxLength={12}
            formData={formData}
            setFormData = {setFormData}
            options = {options.phone}
            errors = {errors}
            setErrors = {setErrors}
            valids = {valids.phone}
            isSubmiting = {isSubmiting}
          />
          <InputField
            type="password"
            name="password"
            id="password"
            placeholder="Mật khẩu"
            value={formData.password}
            maxLength={20}
            formData={formData}
            setFormData = {setFormData}
            options = {options.password}
            errors = {errors}
            setErrors = {setErrors}
            valids = {valids.password}
            isSubmiting = {isSubmiting}
          />
          <InputField
            type="password"
            name="passwordConfirm"
            id="passwordConfirm"
            placeholder="Xác nhận mật khẩu"
            value={formData.passwordConfirm}
            maxLength={20}
            formData = {formData}
            setFormData = {setFormData}
            options = {options.passwordConfirm}
            errors = {errors}
            setErrors = {setErrors}
            valids = {valids.passwordConfirm}
            isSubmiting = {isSubmiting}
          />
          <InputChoice
            type="checkbox"
            name="checkPolicy"
            id="checkPolicy"
            label="Điều khoản sử dụng"
            choices={checkPolicy.choices}
            value={formData.checkPolicy}
            setFormData={setFormData}
            errors={errors}
            setErrors={setErrors}
            valids={valids.checkPolicy}
            columns={1}
          />
        <Button
          type="submit"
          text={isLoading ? 'Đang xử lý...' : 'Đăng ký!'}
          disabled={isLoading}
        />
      </form>
      <Link to="/login">Đã có tài khoản? Đăng nhập tại đây!</Link>
      <LogoGuest />
    </section>
  );
};

export default RegisterForm;