import React from 'react';
import { Helmet } from 'react-helmet-async';
import LoginForm from '../../components/feature/login/LoginForm';
import GuestBackground from '../../components/ui/layout/GuestBackground';
import MainWarpper from '../../components/ui/layout/MainWarpper';
import Card from '../../components/ui/tag/Card';
import './LoginPage.scss';

const LoginPage = () => {
  return (
    <div>
      <Helmet>
        <title>Web tuyển sinh - Đăng nhập</title>
      </Helmet>
      <GuestBackground delay={1000}>
        <MainWarpper>
          <Card className={"login-container"}>
            <figure className="login-image"></figure> 
            <LoginForm/>
          </Card>
        </MainWarpper>
      </GuestBackground>
    </div>
  );
};

export default LoginPage;