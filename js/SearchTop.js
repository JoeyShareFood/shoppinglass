

J('document').ready(function(){
	
	var query = "";
	var team, city;
	
	/* Assim que o usuário soltar a tecla, o valor é capturado. Se diferente
	de vazio, é disparado uma requisição Ajax.
	*/
	J('#suggestion-search').keyup(function(){

		query = J(this).val();
		
		if(query != ""){
			J('.ListCity').css('display', 'none');
			J(this).SearchTeam(query);
		}
		else
		{
			J('.ListSearch').css('display', 'none');
		}
	});
	
	/* Requisição Ajax busca sugestões de ofertas de acordo com o buscado pelo cliente. */
	J.fn.SearchTeam = function(query){
		jQuery.ajax({
			url: URLWEB + "/ajax/SearchTop.php",
			type: 'post',
			data: "query=" + query + "&type=team",
			success: function(retorno){
				if(retorno){
					J('.ListSearch').css('display', 'block');
					J('.ListSearch').html(retorno);
				}  	  
			}
		});			
	}
});