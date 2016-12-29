var api_key = localStorage.getItem("api_key");
if (!api_key){ document.location = '/auth'; } 
