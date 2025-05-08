import React from 'react';
import './InputChoice.scss';
import { onChangeChoice } from '../../../function/triggers/onChangeChoice';
import { validateChoice } from '../../../function/conditions/validateChoice';

/**
 * Component input lựa chọn radio hoặc checkbox
 *
 * @param {Object} props - Các thuộc tính của component
 * @param {string} props.type - Loại input, có thể là 'checkbox' hoặc 'radio'
 * @param {string} props.name - Tên của nhóm lựa chọn (dùng cho form)
 * @param {string} props.id - ID duy nhất cho input
 * @param {string} props.label - Nhãn hiển thị cho nhóm lựa chọn
 * @param {Array[String]} props.choices - Danh sách các lựa chọn "chuỗi"
 * @param {any} props.value - Giá trị hiện tại của input
 * @param {Function} props.setFormData - Hàm cập nhật dữ liệu form
 * @param {Object} props.errors - Đối tượng chứa thông tin lỗi của form
 * @param {Function} props.setErrors - Hàm cập nhật trạng thái lỗi
 * @param {Object} props.valids - Điều kiện của input
 * @param {boolean} props.isSubmitting - Truyền trạng thái submit của form vào
 * @param {number} props.columns - Số cột cho bố cục chia phân bổ. Mặc định là 1
 * @param {boolean} props.disabled - Trạng thái vô hiệu hóa của input. Mặc định là false
 */
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