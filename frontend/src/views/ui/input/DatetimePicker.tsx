// components/DateTimePicker.tsx
import React from 'react';
import Flatpickr from 'react-flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
import { formatTimestamp } from '../../../function/convert/formatTimestamp';
import { FormDataProps, ErrorLogProps, ValidateRule } from '../../../types/FormInterfaces';
import { DateValids } from '../../../classes/DateValids';
import './InputField.scss';

type PickerType = 'date' | 'time' | 'datetime';

interface DateTimePickerProps {
  type?: PickerType;
  name: string;
  id: string;
  value: Date | string | undefined;
  formData: FormDataProps;
  setFormData: React.Dispatch<React.SetStateAction<FormDataProps>>;
  placeholder?: string;
  className?: string;
    errors?: ErrorLogProps;
    setErrors?: React.Dispatch<React.SetStateAction<ErrorLogProps>>;
    valids?: ValidateRule;
}

const DatetimePicker = ({
  type = 'datetime',
  name,
  id,
  value,
  formData,
  setFormData,
  placeholder = 'Chọn thời gian',
  className = 'input',
  errors = {},
  setErrors = undefined,
  valids = new DateValids({}),
}: DateTimePickerProps) => {
  const options: any = {
    allowInput: true,
    time_24hr: true,
  };

  switch (type) {
    case 'date':
      options.dateFormat = 'd/m/Y';
      break;
    case 'time':
      options.enableTime = true;
      options.noCalendar = true;
      options.dateFormat = 'H:i';
      break;
    case 'datetime':
    default:
      options.enableTime = true;
      options.dateFormat = 'H:i d/m/Y';
      break;
  }

  const handleChange = (dates: Date[]) => {
  const selected = dates[0];
  if (!selected) return;

  let formatted = '';
  switch (type) {
    case 'date':
      formatted = formatTimestamp(selected, 'DD/MM/YYYY');
      break;
    case 'time':
      formatted = formatTimestamp(selected, 'HH:mm');
      break;
    case 'datetime':
    default:
      formatted = formatTimestamp(selected, 'HH:mm DD/MM/YYYY');
      break;
  }

   setFormData(prev => {
    const updated = { ...prev, [name]: formatted };

    // Gọi hàm validate sau khi cập nhật giá trị
    if (valids && typeof valids.validate === 'function') {
      // console.log({name, formatted, updated});
      const errorObj = valids?.validate(name, formatted, updated);
      console.log(valids);
      // console.log("errorObj", errorObj);
      if (setErrors) {
        setErrors(prevErrors => ({ ...prevErrors, ...errorObj }));
      }
      console.log("checked");
    }

    return updated;
  });
};




  return (
    <div className={`input-wrapper ${value ? 'has-value' : ''}`}>
      <label htmlFor={id} className="input-label">
        {placeholder}
      </label>
      <div className="input-field-wrapper">
        <Flatpickr
          name={name}
          id={id}
          options={options}
          value={value || ''}
          onChange={handleChange}
          className={className}
        />
      </div>
      {errors[name] && <span className="error-message">{errors[name]}</span>}
    </div>
  );
};

export default DatetimePicker;
