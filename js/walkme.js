 (function() {
 	var walkme = document.createElement('script'); 
 	walkme.type = 'text/javascript'; 
 	walkme.async = true; 
 	walkme.src = walkme_code;
 	console.log(walkme); 
	var s = document.getElementsByTagName('script')[0]; 
	s.parentNode.insertBefore(walkme, s);
 })();