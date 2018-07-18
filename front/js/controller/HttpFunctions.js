function httpCall(method, url, data){
	return $.ajax({
		type: method,
		url: url,
		data: data
	});
}