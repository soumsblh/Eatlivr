
	$('#myModal').on('shown.bs.modal', function () {
	  $('#myInput').focus()
	})

$(function(){
	Var MathDiscreteInformatique = [
		'Théories du calcul',
		'Modèles de calcul',
		'Machine de Turing',
		'Automates',
	];
	$("listeTheorieInformatique" ).autocomplete({
		source:MathDiscreteInformatique
	});
});

function myFunction() {
    var x = document.getElementById('myDIV');
    if (x.style.display === 'none') {
        x.style.display = 'block';
    } else {
        x.style.display = 'none';
    }
}
function initURLTextarea(){
	$("#outter input").autocomplete({
		wordCount:1,
		mode: "outter",
		on: {
			query: function(text,cb){
				var words = [];
				for( var i=0; i<urls.length; i++ ){
					if( urls[i].toLowerCase().indexOf(text.toLowerCase()) == 0 ) words.push(urls[i]);
				}
				cb(words);
			}
		}
	});
}
var countries = [];
function initContriesTextarea(){
	$.ajax("./communes.txt",{
		success: function(data, textStatus, jqXHR){
		countries = data.replace(/\r/g, "" ).split("\n");
		$("input#ville").autocomplete({
			wordCount:1,
			on: {
				query: function(text,cb){
					var words = [];
					for( var i=0; i<countries.length; i++ ){
						if( countries[i].toLowerCase().indexOf(text.toLowerCase()) == 0 ) words.push(countries2[i]);
						if( words.length > 5 ) break;
					}
					cb(words);
				}
			}
			});
		}
	});
}
$(document).ready(function(){
	initContriesTextarea();
	initURLTextarea();
});
