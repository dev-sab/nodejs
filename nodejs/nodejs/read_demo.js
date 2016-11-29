var fs= require('fs');

var data= require('./sample.json');

console.log(data.name);

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
}

});
