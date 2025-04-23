import React from 'react';
import { Helmet } from 'react-helmet-async';
import RegisterForm from '../../components/feature/register/RegisterForm';
import GuestBackground from '../../components/layout/GuestBackground';
import MainWarpper from '../../components/layout/MainWarpper';
import './RegisterPage.scss';

const RegisterPage = () => {
  return (
    <div>
      <Helmet>
        <title>Web tuyển sinh - Đăng ký tài khoản tuyển sinh</title>
      </Helmet>
      <GuestBackground delay={1000}>
        <MainWarpper>
          <section className="register-container">
            <figure className="register-image"></figure>
            <RegisterForm/>
          </section>
        </MainWarpper>
      </GuestBackground>
    </div>
  );  
};

export default RegisterPage;