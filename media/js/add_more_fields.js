/*
	https://pt.stackoverflow.com/questions/108387/adicionar-mais-campos-em-form-dinamicamente-em-jquery
*/

jQuery('document').ready(function() {
	
	var max_fields = 10;
	var wrapper = jQuery(".input_fields_wrap");
	var add_button = jQuery(".add_field_button");

	var x = 1;
	jQuery(add_button).click(function(e) {
		
		e.preventDefault();
		var length = wrapper.find("input:text").length;

		if(x < max_fields) {
			
			x++;
			jQuery(wrapper).append("<div id='c_estoque' class='c_estoque_add'><div id='c_vendas'><div id='stock'><div style='clear:both;' class='report-head'>Estoque: <span class='cpanel-date-hint'></span></div><div class='group'><input type='text' name='stock[]' onKeyPress='return SomenteNumero(event);'  id='stock' class='format_input form-control' maxlength='6'  /></div></div><div id='size'><div style='clear:both;' class='report-head'>Tamanho: <span class='cpanel-date-hint'></span></div><div class='group'><input type='text' name='size[]' id='size' class='format_input form-control' maxlength='2'></div></div><div id='color'><div style='clear:both;' class='report-head'>Cor: <span class='cpanel-date-hint'></span></div><div class='group'><input type='text' name='color[]' id='color' class='format_input form-control' maxlength='100'></div></div></div></div>");
		}
	});
});