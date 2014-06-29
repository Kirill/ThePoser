<?php
$headerHeightOptions = array('Default', 'Small', 'Tiny');
$skinOptions = array('poser Default', 'Flat','MantisMan');
$currentHeader = plugin_config_get('headerHeight');
$currentSkin = plugin_config_get('skin');
html_page_top();
ThePoserPlugin::showImagickWarning();
?>
<div class="poserConfig">
<form action="<?php echo plugin_page( 'config_update' ) ?>" method="post" enctype="multipart/form-data">
<?php echo form_security_field( 'plugin_Example_config_update' ) ?>

	<label>Header style</label>
	<select name="headerHeight">
		<?php foreach($headerHeightOptions as $key=>$value) {
			?>
		<option value="<?php echo $key; ?>"
			<?php if($key == $currentHeader) {
				?> selected="yes"<?php
			} ?>
			><?php echo $value; ?></option>
			<?php
		}?>
	</select>
	<br/>
	
	<label>Skin</label>
	<select name="skin">
		<?php foreach($skinOptions as $key=>$value) {
			?>
		<option value="<?php echo $key; ?>"
			<?php if($key == $currentSkin) {
				?> selected="yes"<?php
			} ?>
			><?php echo $value; ?></option>
			<?php
		}?>
	</select>
	<br/>
	
	<label>Your company name</label>
	<input type="text" name="companyName" value="<?php echo plugin_config_get('companyName'); ?>"/><br/>
	
	<label>Your company website<label>
	<input type="text" name="companyUrl" value="<?php echo plugin_config_get('companyUrl');?>"/><br/>
	
	<label>Custom logo</label>
	<?php
	$imgdata = plugin_config_get('companyLogo');
	if(!empty($imgdata)) {
		?><br/><img src="<?php echo $imgdata;?>" alt="<?php echo plugin_config_get('companyName'); ?>"/><br/><?php
	}
	?>
	<input type="file" name="customLogo"/><br/>
	
	<label>Custom logo for tiny view (16px*16px)</label>
	<?php
	$imgdata = plugin_config_get('companyTinyLogo');
	if(!empty($imgdata)) {
		?><br/><img src="<?php echo $imgdata;?>" alt="<?php echo plugin_config_get('companyName'); ?>"/><br/><?php
	}
	?>
	<input type="file" name="customTinyLogo"/><br/>
	
	<label><input type="checkbox" name="reset_logo"/> Remove Logo</label><br/>
	<label><input type="checkbox" name="reset_tiny_logo"/> Remove Tiny Logo</label><br/>
<label><input type="checkbox" name="reset"/> Reset</label>
<br/>
<input type="submit"/>

</form>
</div>
<?php

html_page_bottom();

