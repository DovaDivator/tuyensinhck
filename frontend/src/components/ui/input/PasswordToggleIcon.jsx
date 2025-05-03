import React from 'react';
import './PasswordToggleIcon.scss';

const VisibleIcon = () => <i className="fa-regular fa-eye" />;
const HiddenIcon = () => <i className="fa-regular fa-eye-slash" />;

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