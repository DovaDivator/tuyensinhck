import React from 'react';
import { Helmet } from 'react-helmet-async';
import LoginForm from '../../components/feature/login/LoginForm';
import GuestBackground from '../../components/layout/GuestBackground';
import MainWarpper from '../../components/layout/MainWarpper';
import './LoginPage.scss';

const LoginPage = () => {
  return (
    <div>
      <Helmet>
        <title>Web tuyển sinh - Đăng nhập</title>
      </Helmet>
      <GuestBackground delay={1000}>
        <MainWarpper>
          <section className="login-container">
            <figure className="login-image"></figure>
            <LoginForm/>
          </section>
        </MainWarpper>
      </GuestBackground>
    </div>
  );
};

export default LoginPage;