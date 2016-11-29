var express= require('express');
var app=express();


app.get('/',function(req,res){
res.send('Ho Ho HO');
});


app.listen(3000,function(){
 	console.log('Server Running at 3000');
});