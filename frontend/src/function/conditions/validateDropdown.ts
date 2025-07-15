import { DropdownValids } from "../../classes/DrowdownValids";


export const validateDropdown = (
  name: string,
  value: any,
  valids: DropdownValids = new DropdownValids(),
): { [key: string]: string } => {
  if (valids.required) {
    const hasFile = Array.isArray(value) ? value.length > 0 :
      value instanceof File && value.size > 0;

    if (!hasFile) return { [name]: 'Trường này là bắt buộc.' };
  }
  return { [name]: '' };
};

