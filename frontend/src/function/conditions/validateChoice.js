import { ChoiceValids } from "../classes/ChoiceValids";

export const validateChoice = (name, value, valids = new ChoiceValids()) => {   
    if (valids.required && value?.length === 0) {
      return {[name]: 'Trường này là bắt buộc.'};
   }

    if (valids.min > 0 && value?.length < valids.min) {
      return {[name]: `Bạn phải chọn tối thiểu ${valids.min} tùy chọn`};
    }
  
    if (valids.max && value?.length > valids.max) {
      return {[name]: `Bạn chỉ được chọn tối đa ${valids.max} tùy chọn`};
    }
  
    return {[name]: ''};
  };