import React from 'react';
import './Button.scss';

const Button = ({ 
    type = 'button', 
    className = '', 
    onClick, 
    disabled = false, 
    text, 
    icon, 
    imgSrc 
  }) => {
    return (
      <button
        type={type}
        className={`${className}`}
        onClick={onClick}
        disabled={disabled}
      >
        {icon && <i className={`fa ${icon} ${text ? 'mr-2' : ''}`}></i>}
        {imgSrc && <img src={imgSrc} alt="text" className="btn-icon" />}
        {text !== "" && <span>{text}</span>}
      </button>
    );
  };
  
  export default Button;