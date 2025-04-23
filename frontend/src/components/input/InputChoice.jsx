import React from 'react';
import './InputChoice.scss';
import { onChangeChoice } from '../../function/triggers/onChangeChoice';
import { validateChoice } from '../../function/conditions/validateChoice';

const InputChoice = ({
  type = 'checkbox', // 'checkbox' or 'radio'
  name,
  id,
  label,
  choices = [],
  value,
  setFormData,
  errors = {},
  setErrors,
  valids = {},
  isSubmitting = false,
  columns = 1, // Number of columns for layout
  disabled = false,
}) => {
  const handleChange = (e) => {
    let newValue;
    if (type === 'checkbox') {
      newValue = e.target.checked
        ? [...(value || []), e.target.value]
        : (value || []).filter((val) => val !== e.target.value);
    } else {
      newValue = e.target.value; // Radio buttons store a single value
    }

    onChangeChoice(name, newValue, setFormData);

    if (!isSubmitting) {
      const errorObj = validateChoice(name, newValue, valids);
      setErrors((prev) => ({ ...prev, ...errorObj }));
    }
  };

  return (
    <div className="choice-wrapper">
      <span className="choice-label">{label}</span>
      <fieldset
        className="choice-group"
        style={{ gridTemplateColumns: `repeat(${columns}, 1fr)` }}
      >
        {choices.map((choice) => (
          <label key={choice.value} className="choice-item">
            <input
              type={type}
              name={name}
              id={`${id}-${choice.value}`}
              value={choice.value}
              checked={
                type === 'checkbox'
                  ? (value || []).includes(choice.value)
                  : value === choice.value
              }
              onChange={handleChange}
              className="choice-input"
              disabled={disabled}
            />
            <span className="choice-text">{choice.label}</span>
          </label>
        ))}
      </fieldset>
      {errors[name] && <span className="error-message">{errors[name]}</span>}
    </div>
  );
};

export default InputChoice;