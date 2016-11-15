var express=require('express');
// Indstance
var app=express();

var fs=require('fs');

app.use('/message', function (req,res)
{
console.log('ENdpoint'); 	

res.send('Message called');
});


app.use('/users',function(req,res){
	fs.readFile('./sample.json','utf-8',function(err,data){
	// Once Read file We need to parse the Json
		if(err)
		{
			console.log(err);
		}
		else
		{
			data=JSON.parse(data);
			console.log(data.name);
			res.send(data);
		}
	});



});

app.listen(3000);
