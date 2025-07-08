import { validateDate } from '../function/conditions/validateDate';
import { FormDataProps } from '../types/FormInterfaces';

interface DateValidsProps {
  required?: boolean;

  cons?: Partial<{
    max: string | Date;
    min: string | Date;
  }>;

  dist?: Partial<{
    year: number;
    month: number;
    day: number;
    hour: number;
    min: number;
  }>;
}

/**
   * Tạo một đối tượng `InputValids` mới với các quy tắc xác thực đã chỉ định.
   * 
   * @param {DateValidsProps} [param0] - Cấu hình cho xác thực đầu vào.
   * @param {boolean} [param0.required=false] - Có bắt buộc hay không. Mặc định là false.
   * @param {Object} [param0.cons] - Struct chứa ràng buộc thời gian. Struct cần 2 trường max và min, mặc định là {}.
   * @param {Object} [param0.dist] - Struct chứa khoảng cách thời gian giữa input và 2 trường max và min
   */
export class DateValids {
  required: boolean;
  cons?: Partial<{
    max: string | Date;
    min: string | Date;
  }>;

  dist?: Partial<{
    year: number;
    month: number;
    day: number;
    hour: number;
    min: number;
    isWithin: boolean;
  }>;

  constructor({ required = false, cons = {}, dist = {} }: DateValidsProps = {}) {
    this.required = required;
    this.cons = cons;
    this.dist = dist;
  }

  validate(name: string, value: any, formData?: FormDataProps): { [key: string]: string } {
    return validateDate(name, value, this, formData);
  }
}
