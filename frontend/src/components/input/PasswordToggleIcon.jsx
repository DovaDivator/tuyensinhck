import React from 'react';
import './PasswordToggleIcon.scss';
import 'font-awesome/css/font-awesome.min.css';

const VisibleIcon = () => <i className="fa fa-eye" />;
const HiddenIcon = () => <i className="fa fa-eye-slash" />;

const PasswordToggleIcon = ({ showPassword, togglePassword, type }) => {
  return (
    type === 'password' && (
      <span
        className="toggle-password"
        onClick={togglePassword}
      >
        {showPassword ? <VisibleIcon /> : <HiddenIcon />}
      </span>
    )
  );
};

export default PasswordToggleIcon;