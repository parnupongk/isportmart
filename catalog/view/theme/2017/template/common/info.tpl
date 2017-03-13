

<div id="copyright_info">	
	<div id="up_button_author">
		&copy;
	</div>
	<div id="copyright_links">	
	</div>
</div>
<script>
	powered_oc = 'Powered By <a href="http://www.opencart.com">OpenCart</a>';
	if(document.getElementById('home_content')){
		author = 'Design: <a href="http://www.dswww.pl" title="Autor szablonu">Design Studio WWW</a> | ';
	}else{
		author = 'Partner: <a href="http://uzywane-opony-ciezarowe.eu/en/" title="Author Theme">Used truck tires</a> | ';
	}
	document.getElementById("copyright_links").innerHTML = author+powered_oc;
	
	$( "#up_button_author" ).click(function() {
		$( "#copyright_links" ).slideToggle( "slow", function() {});
	});
</script>