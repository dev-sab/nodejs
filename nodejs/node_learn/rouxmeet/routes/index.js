var express = require('express');
var router = express.Router();
var appdata=require('../data.json');

//console.log(appdata);

/* GET home page. */
router.get('/', function(req, res, next) {
	// rende index.ejs
  //res.render('index', { title: 'Express' });
  var myartwork=[];
  var myartists=[];
  myartists=appdata.speakers;
  appdata.speakers.forEach(function(item){
  	myartwork=myartwork.concat(item.artwork);
  });
  console.log('myartwork');
  console.log(myartwork);
  res.render('index', { 
  	title: 'Home' ,
  	artwork:myartwork,
    artists:myartists,
    page:'home'
  });
});


/* GET Speakers page. */
router.get('/speakers', function(req, res, next) {
  var myartwork=[];
  var myartists=[];
  myartists=appdata.speakers;
  appdata.speakers.forEach(function(item){
    myartwork=myartwork.concat(item.artwork);
  });
  res.render('speakers', { 
    title: 'Speakers' ,
    artwork:myartwork,
    artists:myartists,
    page:'artistList'
  });
});


/* GET Speakers page. */
router.get('/speakers/:speakerId', function(req, res, next) {
  var myartwork=[];
  var myartists=[];

  //speakerId is a local variable
  appdata.speakers.forEach(function(item){
    if(item.shortname==req.params.speakerId){
      myartists.push(item);
      myartwork=myartwork.concat(item.artwork);  
    }
  });

  res.render('speakers', { 
    title: 'Speakers' ,
    artwork:myartwork,
    artists:myartists,
    page:'artistDetail'
  });
});

module.exports = router;
