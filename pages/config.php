<?php
auth_reauthenticate();
access_ensure_global_level( config_get( 'manage_plugin_threshold' ) );
layout_page_header( 'Clone Project' );
layout_page_begin(  );
print_manage_menu();
?>
<div class="col-md-12 col-xs-12">
<div class="space-10"></div>
<div class="form-container" > 
<br/>
<div class="widget-box widget-color-blue2">
<div class="widget-header widget-header-small">
	<h4 class="widget-title lighter"><i class="ace-icon fa fa-text-width"></i>Clone Project Configuration:</h4>
</div>
<div class="widget-body">
<div class="widget-main no-padding">
<div class="table-responsive"> 
<table class="table table-bordered table-condensed table-striped"> 
<br>
<form action="<?php echo plugin_page( 'config_edit' ) ?>" method="post">
<tr >
<td class="category" colspan="3">
</td>
</tr>


<tr>
<td class="category" width="30%"><div align="center">
Copy Hierarchy
</td>
<td class="center" width="70%"><div align="center">
<label><input type="radio" name='clone_hierarchy' value="1" <?php echo( ON == plugin_config_get( 'clone_hierarchy'  ) ) ? 'checked="checked" ' : ''?>/>Enabled</label>
<label><input type="radio" name='clone_hierarchy' value="0" <?php echo( OFF == plugin_config_get( 'clone_hierarchy' ) )? 'checked="checked" ' : ''?>/>Disabled</label>
</td>
</tr> 

<tr>
<td class="category" width="30%"><div align="center">
Copy Sub Projects
</td>
<td class="center" width="70%"><div align="center">
<label><input type="radio" name='clone_subprojects' value="1" <?php echo( ON == plugin_config_get( 'clone_subprojects'  ) ) ? 'checked="checked" ' : ''?>/>Enabled</label>
<label><input type="radio" name='clone_subprojects' value="0" <?php echo( OFF == plugin_config_get( 'clone_subprojects' ) )? 'checked="checked" ' : ''?>/>Disabled</label>
</td>
</tr> 

<tr>
<td class="category" width="30%"><div align="center">
Copy Categories
</td>
<td class="center" width="70%"><div align="center">
<label><input type="radio" name='clone_categories' value="1" <?php echo( ON == plugin_config_get( 'clone_categories'  ) ) ? 'checked="checked" ' : ''?>/>Enabled</label>
<label><input type="radio" name='clone_categories' value="0" <?php echo( OFF == plugin_config_get( 'clone_categories' ) )? 'checked="checked" ' : ''?>/>Disabled</label>
</td>
</tr> 

<tr>
<td class="category" width="30%"><div align="center">
Copy Versions
</td>
<td class="center" width="70%"><div align="center">
<label><input type="radio" name='clone_versions' value="1" <?php echo( ON == plugin_config_get( 'clone_versions'  ) ) ? 'checked="checked" ' : ''?>/>Enabled</label>
<label><input type="radio" name='clone_versions' value="0" <?php echo( OFF == plugin_config_get( 'clone_versions' ) )? 'checked="checked" ' : ''?>/>Disabled</label>
</td>
</tr> 

<tr>
<td class="category" width="30%"><div align="center">
Copy Custom Fields
</td>
<td class="center" width="70%"><div align="center">
<label><input type="radio" name='clone_customfields' value="1" <?php echo( ON == plugin_config_get( 'clone_customfields'  ) ) ? 'checked="checked" ' : ''?>/>Enabled</label>
<label><input type="radio" name='clone_customfields' value="0" <?php echo( OFF == plugin_config_get( 'clone_customfields' ) )? 'checked="checked" ' : ''?>/>Disabled</label>
</td>
</tr> 

<tr>
<td class="category" width="30%"><div align="center">
Copy Users
</td>
<td class="center" width="70%"><div align="center">
<label><input type="radio" name='clone_users' value="1" <?php echo( ON == plugin_config_get( 'clone_users'  ) ) ? 'checked="checked" ' : ''?>/>Enabled</label>
<label><input type="radio" name='clone_users' value="0" <?php echo( OFF == plugin_config_get( 'clone_users' ) )? 'checked="checked" ' : ''?>/>Disabled</label>
</td>
</tr> 

<tr>
<td class="center" colspan="3">
<input type="submit" class="button" value="<?php echo plugin_lang_get('update') ?>"  />
</td>
</tr>

</table>
<form>
</div></div></div></div></div></div>
<?php
layout_page_end();