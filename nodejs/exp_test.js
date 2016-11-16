var express=require('express');
// Instantiating express
var app= express();

app.use('/message', function(req,res){

console.log('Hello Macho');

res.send('Hello Machi');
});


app.listen(3000);


