// fs = require('fs');

// data= fs.readdirSync('/');
// console.log('data',data);

// console.log('finished');

// Asynchronous 


fs = require('fs');


function pn(err,data)
{
	console.log('data :' + data);
}


// Pn is Callback
fs.readdir('/',pn);

console.log('Placed a cal');
