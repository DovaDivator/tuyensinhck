export class ChoiceValids {
    constructor({required = false, min = 0, max = 0} = {}) {
        this.required = required;
        this.min = min;
        if(this.min < 0){
            console.error('min must be greater than or equal to 0');
            this.min = 0;
        }
        this.max = max;
    }
  }