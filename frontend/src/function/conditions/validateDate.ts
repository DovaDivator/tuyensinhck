import { validateTypeText } from "./validateTypeText";
import { DateValids } from "../../classes/DateValids";
import { FormDataProps } from "../../types/FormInterfaces";
import { parseFlexibleDate } from "../convert/parseFlexibleDate";
import { compareTime, durationToMilliseconds } from "./compareTime";

export const validateDate = (
  name: string,
  value: string,
  valids: DateValids = new DateValids({}),
  formData: FormDataProps = {}
): { [key: string]: string } => {
  if (valids.required && value.trim() === '') {
    return { [name]: 'Trường này là bắt buộc.' };
  }

  try {
    if (valids.cons) {
      const dateValue = parseFlexibleDate(value);
      const miliDist = durationToMilliseconds(valids.dist ?? {});

      if (valids.cons.max !== undefined) {
        const result = compareTime(
          dateValue,
          valids.cons?.max instanceof Date
            ? valids.cons.max
            : parseFlexibleDate(formData[valids.cons?.max] as string),
          miliDist,
          valids.dist?.isWithin ?? false
        );

        if (!result) return { [name]: 'Thời gian vượt quá ràng buộc cho phép!' };
      }

      if (valids.cons.min !== undefined) {
        const result = compareTime(
          valids.cons?.min instanceof Date
            ? valids.cons.min
            : parseFlexibleDate(formData[valids.cons?.min] as string),
          dateValue,
          miliDist,
          valids.dist?.isWithin ?? false
        );

        if (!result) return { [name]: 'Thời gian sớm hơn ràng buộc cho phép!' };
      }
    }


    return { [name]: '' };
  } catch (error: any) {
    console.error(error);
    return { [name]: "Có sự cố xảy ra!" };
  }
};


