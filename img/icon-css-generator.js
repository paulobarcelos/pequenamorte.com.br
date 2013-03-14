
var fs = require('fs');

function read(size){
	var files = fs.readdirSync('./'+size);

	console.log('.icon-size-' + size + ' {');
	files.forEach(function(file){
		var array = file.split('.');
		var name = array[0];
		console.log('	.' + name + ' a,');
	});
	console.log('	.icon a { width:' + size + 'px; height:' + size + 'px; }');


	files.forEach(function(file){
		var array = file.split('.');
		var name = array[0];

		console.log('	.' + name + ' a { background-image: url("@{iconspath}/' + size + '/' + file + '"); } ');
	});

	console.log('}')
	
}

read(16)
read(24)
read(32)
read(48)
read(64)
