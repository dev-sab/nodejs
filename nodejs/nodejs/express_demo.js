var express=require('express');
// Indstance
var app=express();

// Uses express directory name
app.use(express.static(__dirname + '/public'));

console.log('Running in port : 3000');
console.log(app);

app.listen(3000);
