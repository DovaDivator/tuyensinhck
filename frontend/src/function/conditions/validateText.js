import { validateTypeText } from "./validateTypeText";
import { InputValids } from "../../classes/InputValids";

export const validateText = (name, value, valids = new InputValids({}), formData = {}) => {
    if (valids.required && value.trim() === '') {
      return {[name]: 'Trường này là bắt buộc.'};
    }
    if (valids.minlength && value.length < valids.minlength) {
      return {[name]: `Trường này phải có ít nhất ${valids.minlength} ký tự.`};
    }
    if (valids.match && formData[valids.match] !== value) {
      return {[name]: 'Thông tin không khớp.'};
    }

    if(valids.matchType.length > 0) {
      if (checkUnmatchedType(value, valids.matchType)) {
        return {[name]: 'Thông tin không hợp lệ.'};
      }
    }

    return {[name]: ''};
  };

  const checkUnmatchedType = (value, matchType) => {
    let unmatchedType = false;
    for (const type of matchType) {
      const func = validateTypeText[type];
      if (!func && typeof func !== 'function') {
        console.error(`function ${type} not exist`);
        continue;
      }else{
        if (!func(value)) {
          unmatchedType = true;
        }else{
          return false;
        }
      }
    }
    return unmatchedType;
  }