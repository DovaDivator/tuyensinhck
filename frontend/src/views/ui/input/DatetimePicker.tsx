// components/DateTimePicker.tsx
import React from 'react';
import Flatpickr from 'react-flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
import { formatTimestamp } from '../../../function/convert/formatTimestamp';
import { FormDataProps } from '../../../types/FormInterfaces';

type PickerType = 'date' | 'time' | 'datetime';

interface DateTimePickerProps {
  type?: PickerType;
  name: string;
  id: string;
  value: Date | string | undefined;
  setFormData: React.Dispatch<React.SetStateAction<FormDataProps>>;
  placeholder?: string;
  className?: string;
}

const DatetimePicker = ({
  type = 'datetime',
  name,
  id,
  value,
  setFormData,
  placeholder = 'Chọn...',
  className = 'input',
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
  console.log(selected);

  let formatted = '';
  switch (type) {
    case 'date':
      formatted = formatTimestamp(selected, 'dd/MM/yyyy');
      break;
    case 'time':
      formatted = formatTimestamp(selected, 'HH:mm');
      break;
    case 'datetime':
    default:
      formatted = formatTimestamp(selected, 'HH:mm dd/MM/yyyy');
      break;
  }

  setFormData(prev => ({
        ...prev,
        [name]: formatted
      }));
};


  return (
    <Flatpickr
      name={name}
      id={id}
      options={options}
      value={value || ''}
      onChange={handleChange}
      placeholder={placeholder}
      className={className}
    />
  );
};

export default DatetimePicker;
