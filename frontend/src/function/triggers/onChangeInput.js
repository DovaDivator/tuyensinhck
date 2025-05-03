import { InputOptions } from "../../classes/InputOption";

export const onChangeInput = (e, setFormData, options = new InputOptions({})) => {
  const { name, value } = e.target;
  const valueAfter = onChangeByOption(value, options);
  setFormData(prev => ({ ...prev, [name]: valueAfter }));
};

const onChangeByOption = (value, options = new InputOptions({})) => {
  let valueAfter = value;
  const {Case = '', restrict = false} = options;

  if (Case !== '') {
    valueAfter = onChangeByCase(valueAfter, Case);
  }
  if (restrict) {
    valueAfter = valueAfter.replace(/[^\x00-\x7F]/g, '')
  }
  return valueAfter;
};

const onChangeByCase = (value, Case) => {
  switch (Case) {
    case 'upper':
      return value.toUpperCase();
    case 'lower':
      return value.toLowerCase();
    default:
      return value;
  }
}