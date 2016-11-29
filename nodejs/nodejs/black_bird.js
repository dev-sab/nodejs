var fs= require('fs');

var data= require('./sample.json');

var promise = require('bluebird');

// fs.readFile('./sample.json','utf-8',function(err,data){
// // Once Read file We need to parse the Json
// 	if(err)
// 	{
// 		console.log(err);
// 	}
// 	else
// 	{

// 		try{
// 		data=JSON.parse(data);
// 		console.log(data.name);
// 		}catch(e){
// 			console.error('Invalid Json file');
// 		}
// 	}

// });

promise.promisifyAll(fs);


fs.readFileAsync('./sample1.json')
	.then(JSON.parse)
	.then(function(val){
		console.log(val);
	})
	.catch(SyntaxError,function()
	{
		console.error('Syntax error');
	})
	.catch(function(e)
	{
		console.log('Unable to read file');
	});
