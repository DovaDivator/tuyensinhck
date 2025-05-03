import React from 'react';
import { Helmet } from 'react-helmet-async';
import RegisterForm from '../../components/feature/register/RegisterForm';
import GuestBackground from '../../components/ui/layout/GuestBackground';
import MainWarpper from '../../components/ui/layout/MainWarpper';
import Card from '../../components/ui/tag/Card';
import './RegisterPage.scss';

const RegisterPage = () => {
  return (
    <div>
      <Helmet>
        <title>Web tuyển sinh - Đăng ký tài khoản tuyển sinh</title>
      </Helmet>
      <GuestBackground delay={1000}>
        <MainWarpper>
          <Card className={"register-container"}>
            <figure className="register-image"></figure>
            <RegisterForm/>
          </Card>
        </MainWarpper>
      </GuestBackground>
    </div>
  );  
};

export default RegisterPage;