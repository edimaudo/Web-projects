/*
Design a cash register drawer function that accepts purchase price as the first argument, payment as the second argument, and cash-in-drawer (cid) as the third argument.

cid is a 2d array listing available currency.

Return the string "Insufficient Funds" if cash-in-drawer is less than the change due. Return the string "Closed" if cash-in-drawer is equal to the change due.
*/

function drawer(price, cash, cid) {
  var change = [];
  var types = ['PENNY', 'NICKEL', 'DIME', 'QUARTER', 'ONE', 'FIVE', 'TEN', 'TWENTY', 'ONE HUNDRED'];
  var values = {
    PENNY: 1,
    NICKEL: 5,
    DIME: 10,
    QUARTER: 25,
    ONE: 100,
    FIVE: 500,
    TEN: 1000,
    TWENTY: 2000,
    'ONE HUNDRED': 10000
  };
  var cashback = Math.round((cash - price) * 100);
  var typeIdx = types.length - 1;
  var changeVal = 0;
  var cashLeft = 0;
  while (typeIdx !== -1 && changeVal !== cashback) {
    var changeLeft = cashback - changeVal;
    var value = values[types[typeIdx]];
    var availChange = Math.round(cid[typeIdx][1] * 100);
    if (value > changeLeft || availChange === 0) {
      typeIdx--;
      cashLeft += availChange;
    } else {
      var locChange = Math.min(availChange, changeLeft - changeLeft % value);
      console.log(locChange);
      changeVal += locChange;
      cid[typeIdx][1] -= locChange / 100;
      change.push([types[typeIdx], locChange / 100]);
    }
  }
  if (changeVal !== cashback) {
    return 'Insufficient Funds';
  }
  if (cashLeft === 0) {
    return 'Closed';
  }
  return change;
}