var express = require('express');
// Global App variable
var app=express();
// Creates Routes to avoid junk codes
var routes= require('./routes');
// Ejs Exaple: Set the View temple engine with this
app.set('view engine','ejs');	
// Custom view dir
// app.set('views', __dirname + '/views');
// One variable that are globally available to all my pages
app.locals.pagetitle='Awesome Website';

// cal routes

app.get('/',routes.index);
app.get('/about',routes.about);


var server= 
app.listen(3000, function(){
	console.log('Running on 3000');
});


