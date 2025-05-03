export class InputValids {
    constructor({ minlength = 0, required = false, match = '', matchType = [] } = {}) {
      this.minlength = minlength;
      this.required = required;
      this.match = match;
      this.matchType = matchType;
    }
  }