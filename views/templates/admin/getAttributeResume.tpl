{foreach name=external from=$rows key=id item=atributo}
	<span class='group_massivo'>
		{$atributo.group}
	</span>
	<span class='massivo_signal'>
		:
	</span>
	<span class="name_massivo">
		{$atributo.name|replace:"-":" "}
	</span>;
	<br />
{/foreach}
   
