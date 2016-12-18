/*
Truncate a string (first argument) if it is longer than the given maximum string length (second argument). Return the truncated string with a "..." ending.

Note that the three dots at the end add to the string length.
*/

function truncate(str, num) {

  return str.length <= num? str: str.slice(0,num-3) + "...";
}