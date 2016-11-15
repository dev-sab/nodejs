
var fs=require('fs');


var tom='{"name" : "tom"}';



fs.writeFile('tom.json',tom);

var tm={name: 'timmy'};

fs.writeFile('timmy.json',JSON.stringify(tm));
