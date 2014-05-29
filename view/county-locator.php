<p id="county-locator-body">
	Allow us to find your location or <a href="#">select your county manually</a>
</p>
<script type="text/template" id="county-info">
	<p>
		<a href="#" id="contact-button" class="radius button dropdown split" data-dropdown="contact-drop" data-options="is_hover:true">Contact <%= county %> County</a><br />
		<ul id="contact-drop" class="f-dropdown" data-dropdown-content>
			<li><a href="mailto:<%= email %>">Email a specialist</a></li>
			<li><a href="<%= url %>">Learn more on the website</a></li>
		</ul>
	</p>
	<p>
		<a href="tel:<%= phone %>"><%= phone %></a>
	</p>
</script>