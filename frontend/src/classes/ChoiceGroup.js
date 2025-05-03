/**
 * Lớp quản lý các lựa chọn checkbox đảm bảo value không trùng lặp.
 */
export class ChoiceGroup {
  /**
   * @param {{ value: string, label: string | JSX.Element }[]} options 
   * Mảng các lựa chọn gồm `value` và `label`.
   * - `value` Tên giá trị, chỉ chứa a-z, A-Z, 0-9, `_`, `-`
   * - `label` Tên hiển thị của giá trị. Có thể ở dạng string hoặc thẻ html
   */
  constructor(options = []) {
    this.choices = [];
    this.valuesSet = new Set();

    options.forEach(({ value, label }) => {
      const sanitizedValue = /^[a-zA-Z0-9_-]+$/.test(value) ? value : '';

      if (sanitizedValue === '' || this.valuesSet.has(sanitizedValue)) {
        console.warn(`Duplicate or invalid value skipped: ${value}`);
        return;
      }

      this.valuesSet.add(sanitizedValue);
      this.choices.push({ value: sanitizedValue, label });
    });
  }

  /**
   * Lấy danh sách các lựa chọn hợp lệ.
   * @returns {{ value: string, label: string | JSX.Element }[]}
   */
  getOptions() {
    return this.choices;
  }

  /**
   * Kiểm tra xem `value` có tồn tại trong nhóm không.
   * @param {string} val
   * @returns {boolean}
   */
  hasValue(val) {
    return this.valuesSet.has(val);
  }
}
