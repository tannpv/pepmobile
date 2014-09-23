/*
 * Util.js
 * Date : 15/09/2011
 * Bernard Saulme
 */

/* Intert du texte, a l'endroit du curseur dans uen zone de texte */
function insert_text(inputid, ajout) {
  var input = document.getElementById(inputid);
  input.focus();
  if (typeof(document.selection) != 'undefined') { /* IE */
    var range = document.selection.createRange();
    var insText = range.text;
    range.text = ajout + insText +'ff' ;
  }
  else if (typeof(input.selectionStart) != 'undefined') {
    var start = input.selectionStart;
    input.value = input.value.substr(0, start) + ajout + input.value.substr(start);
	input.selectionStart = start + ajout.length; 
	input.selectionEnd = start+ ajout.length; 
  } /* sinon on ne fait rien */
}
