// 1
function palindrome(str) {
    str = str.replace(/[^a-zA-Z0-9]/g, '').toLowerCase();
    
    return str === str.split('').reverse().join('');
  }
  
  palindrome("eye");

//   2

function convertToRoman(num) {
    const romanNumerals = [
      { numeral: "M", value: 1000 },
      { numeral: "CM", value: 900 },
      { numeral: "D", value: 500 },
      { numeral: "CD", value: 400 },
      { numeral: "C", value: 100 },
      { numeral: "XC", value: 90 },
      { numeral: "L", value: 50 },
      { numeral: "XL", value: 40 },
      { numeral: "X", value: 10 },
      { numeral: "IX", value: 9 },
      { numeral: "V", value: 5 },
      { numeral: "IV", value: 4 },
      { numeral: "I", value: 1 },
    ];
  
    let result = "";
  
    for (let i = 0; i < romanNumerals.length; i++) {
      while (num >= romanNumerals[i].value) {
        result += romanNumerals[i].numeral;
        num -= romanNumerals[i].value;
      }
    }
  
    return result;
  }
  
  convertToRoman(36);

//   3

function rot13(str) {
    const letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    let result = "";
  
    for (let i = 0; i < str.length; i++) {
      const char = str[i];
      const index = letters.indexOf(char);
  
      if (index === -1) {  
        result += char;
      } else {
        const shiftedIndex = (index + 13) % letters.length;
        result += letters[shiftedIndex];
      }
    }
  
    return result;
  }
  
  rot13("SERR PBQR PNZC");

//   4

function telephoneCheck(str) {

    const regex = /^(1\s?)?(\(\d{3}\)|\d{3})[-\s]?(\d{3})[-\s]?(\d{4})$/;
  
    return regex.test(str);
  }
  
  telephoneCheck("555-555-5555");

//   5

function checkCashRegister(price, cash, cid) {
    const currencyValues = {
      "PENNY": 0.01,
      "NICKEL": 0.05,
      "DIME": 0.1,
      "QUARTER": 0.25,
      "ONE": 1,
      "FIVE": 5,
      "TEN": 10,
      "TWENTY": 20,
      "ONE HUNDRED": 100
    };
  
    let changeDue = cash - price;
    let changeArr = [];
  
    let cidTotal = 0;
    for (let i = 0; i < cid.length; i++) {
      cidTotal += cid[i][1];
    }
  
    if (cidTotal < changeDue) {
      return {status: "INSUFFICIENT_FUNDS", change: []};
    } else if (cidTotal === changeDue) {
      return {status: "CLOSED", change: cid};
    }
  
    cid.reverse();
    for (let i = 0; i < cid.length; i++) {
      let currencyName = cid[i][0];
      let currencyAmount = cid[i][1];
      let currencyValue = currencyValues[currencyName];
      let currencyTotal = currencyAmount;
  
      if (changeDue >= currencyValue) {
        let currencyAmountToReturn = Math.floor(changeDue / currencyValue) * currencyValue;
        if (currencyAmountToReturn > currencyAmount) {
          currencyAmountToReturn = currencyAmount;
        }
        changeDue -= currencyAmountToReturn;
        changeDue = Math.round(changeDue * 100) / 100;
        currencyTotal = currencyAmountToReturn;
        changeArr.push([currencyName, currencyTotal]);
      }
    }
  
    if (changeDue > 0) {
      return {status: "INSUFFICIENT_FUNDS", change: []};
    }
  
    return {status: "OPEN", change: changeArr};
  }
  
  checkCashRegister(19.5, 20, [["PENNY", 1.01], ["NICKEL", 2.05], ["DIME", 3.1], ["QUARTER", 4.25], ["ONE", 90], ["FIVE", 55], ["TEN", 20], ["TWENTY", 60], ["ONE HUNDRED", 100]]);