var lastFocus;

alertify.logPosition("bottom right");

haxSay = function(sayText, sayType="success"){
    lastFocused = $(':focus');
    if (sayType == "error"){ alertify.error(sayText); }
    else { alertify.success(sayText); }
    setTimeout(function(){ $(lastFocused).focus(); }, 10);
}

haxGet = function(getText, getDefault, getFunc){
    alertify.defaultValue(getDefault).prompt(getText, getFunc);
}

function escapeHTML(s) { 
    return s.replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;');
}
