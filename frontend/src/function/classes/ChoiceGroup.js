export class ChoiceGroup {
    constructor(options = []) {
      this.choices = [];
      this.valuesSet = new Set();
  
      options.forEach(({ value, label }) => {
        const sanitizedValue = /^[a-zA-Z0-9_-]+$/.test(value) ? value : '';
  
        // Bỏ qua nếu value rỗng hoặc đã tồn tại
        if (sanitizedValue === '' || this.valuesSet.has(sanitizedValue)) {
          console.warn(`Duplicate or invalid value skipped: ${value}`);
          return;
        }
  
        this.valuesSet.add(sanitizedValue);
        this.choices.push({ value: sanitizedValue, label });
      });
    }
  
    getOptions() {
      return this.choices;
    }
  
    hasValue(val) {
      return this.valuesSet.has(val);
    }
  }
  