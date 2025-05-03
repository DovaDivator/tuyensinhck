import React from 'react';
import logo from '../../../assets/images/logo-01.png';
import './LogoGuest.scss';

const LogoGuest = () => {
  return (
    <img src={logo} alt="University Logo" className="logo-guest" />
  );
}

export default LogoGuest;