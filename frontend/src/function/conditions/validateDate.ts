import { validateTypeText } from "./validateTypeText";
import { DateValids } from "../../classes/DateValids";
import { FormDataProps } from "../../types/FormInterfaces";
import { parseFlexibleDate } from "../convert/parseFlexibleDate";

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
            : parseFlexibleDate(valids.cons?.max as string),
          miliDist,
          valids.dist?.isWithin ?? false
        );

        if (!result) return { [name]: 'Thời gian vượt quá ràng buộc cho phép!' };
      }

      if (valids.cons.min !== undefined) {
        const result = compareTime(
          valids.cons?.min instanceof Date
            ? valids.cons.min
            : parseFlexibleDate(valids.cons?.min as string),
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

const compareTime = (
  dateFrom: Date,
  dateTo: Date,
  duration: number,
  isWithin: boolean
): boolean => {
  const delta = dateTo.getTime() - dateFrom.getTime();
  const isOverDuration = delta > duration;

  if (isOverDuration) return !isWithin;
  if (delta >= 0) return isWithin;
  return false
}

function durationToMilliseconds(dist: Partial<{
  year: number;
  month: number;
  day: number;
  hour: number;
  min: number;
}>): number {
  const msPerMin = 60 * 1000;
  const msPerHour = 60 * msPerMin;
  const msPerDay = 24 * msPerHour;
  const msPerMonth = 30 * msPerDay;    // Ước lượng: 30 ngày
  const msPerYear = 365 * msPerDay;    // Ước lượng: 365 ngày

  return (dist.year ?? 0) * msPerYear +
    (dist.month ?? 0) * msPerMonth +
    (dist.day ?? 0) * msPerDay +
    (dist.hour ?? 0) * msPerHour +
    (dist.min ?? 0) * msPerMin;
}
