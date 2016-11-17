// app.get('/',function(request,response){
exports.index=
function(request,response){
//response.send('<h1>Home</h1> Hello Express');
//response.render('default');
	response.render('default',{
	title:'HOME',
	classname:'home',
	users:['Sabarish','asutosh','Raj']

	});
}

// app.get('/about',function(request,response){
exports.about=
function(request,response){
	response.render('default',{
	title:'About Us',
	classname:'about'
	});
}

// app.get('/me',function(request,response){
// 	response.send('<h1>ME Called</h1>');
// });

// app.get('/who/:name?/:title?',function(request,response){
// var name=request.params.name;
// var title=request.params.title;
// response.send('Name '+name + '  Title :  '+title);
// });

// // * means ecery thing else other than route provided
// app.get('*',function(request,response){
// response.send('Go to Hell, Bad Request');
// });
