import { validateText } from './validateText';
import { validateChoice } from './validateChoice';
import { InputValids } from '../classes/InputValids';
import { ChoiceValids } from '../classes/ChoiceValids';

export const validateInput = (name, value, valid, formData) => {
    if(valid instanceof InputValids){
        return validateText(name, value, valid, formData);
    }else if(valid instanceof ChoiceValids){
        return validateChoice(name, value, valid);
    }else{
        console.error(`validate class: ${valid} not exist`);
        return {[name]: ''};
    }
}