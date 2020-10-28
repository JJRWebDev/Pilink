<?php 
function AddItemToList($itemname){
	$fichero = fopen("recipes.xml", "w");
	$actual = file_get_contents("recipes.xml");	
	$actual .= '
	<recipe name="'.$itemname.'" count="1" craft_area="workbench" tags="workbenchCrafting">
		<ingredient name="resourceNail" count="10"/>
		<ingredient name="resourceWood" count="30"/>
		<ingredient name="resourceBrokenGlass" count="5"/>
		<ingredient name="resourceMechanicalParts" count="1"/>
	</recipe>
	';
	file_put_contents("recipes.xml", $actual);
}
?>
<html>
	<body>
		<input type="text" name="Item"/>
	</body>
</html>