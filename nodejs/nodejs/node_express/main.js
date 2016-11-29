var http = require('http');// Http IS a module

var myServer= http.createServer(function(req,res){

res.writeHead(200,{"Content-Type": "text/html"});
res.write("<b>hello<b> hai");
res.end();
});

myServer.listen(3000);



