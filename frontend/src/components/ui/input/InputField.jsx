import React from 'react';
import usePasswordToggle from '../../../function/triggers/usePasswordToggle';
import PasswordToggleIcon from './PasswordToggleIcon';
import './InputField.scss';
import { onChangeInput } from '../../../function/triggers/onChangeInput';
import { validateText } from '../../../function/conditions/validateText';

const InputField = ({
  type = 'text',
  name,
  id,
  placeholder,
  value,
  maxLength,
  formData,
  setFormData,
  options = {},
  errors = {},
  setErrors,
  valids = {},
  isSubmiting = false,
  disabled = false,
}) => {
  const { showPassword, togglePassword } = usePasswordToggle();
  const inputType = type === 'password' && showPassword ? 'text' : type;

  return (
    <div className={`input-wrapper ${value ? 'has-value' : ''}`}>
      <span className="input-label">{placeholder}</span>
      <label className="input-field-wrapper" tabIndex="1">
        <input
          type={inputType}
          name={name}
          id={id}
          lang="en"
          placeholder=' '
          value={value}
          onChange={(e) => onChangeInput(e, setFormData, options)}
          onBlur={(e) => {
            trimInput(setFormData, formData, name);
            if (isSubmiting) return;
            const errorObj = validateText(e.target.name, e.target.value, valids, formData);
            setErrors(prev => ({ ...prev, ...errorObj }));
          }}
          maxLength={maxLength}
          className="input-field"
          disabled={disabled}
          autoComplete={type !== 'password' ? name : 'off'}
        />
        <PasswordToggleIcon
          showPassword={showPassword}
          togglePassword={togglePassword}
          type={type}
        />
      </label>
      {errors[name] && <span className="error-message">{errors[name]}</span>}
    </div>
  );
};

export default InputField;

const trimInput = (setFormData, formData, name) => {
  setFormData(prev => ({
    ...prev,
    [name]: (formData[name] || '').trim()
  }));
}