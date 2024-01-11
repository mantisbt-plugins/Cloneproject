<?php
$hier		= plugin_config_get( 'clone_hierarchy'  );
$sub		= plugin_config_get( 'clone_subprojects'  );
$cat		= plugin_config_get( 'clone_categories'  );
$versions	= plugin_config_get( 'clone_versions'  );
$custom 	= plugin_config_get( 'clone_customfields'  );
$users 		= plugin_config_get( 'clone_users'  );
$f_project_id	= helper_get_current_project();;
?>
<div class="col-md-12 col-xs-12">
	<div class="space-10"></div>
	<div id="clone_project-div" class="form-container">
		<div class="widget-box widget-color-blue2">
			<div class="widget-header widget-header-small">
				<h4 class="widget-title lighter">Clone Current Project</h4>
			</div>

		<div class="center bigger-110">
				<div class="widget-toolbox padding-8 clearfix">
					<form id="manage-project-clone" method="post" action="manage_proj_clone.php" class="form-inline">
						<fieldset>
							<div>
							<?php echo form_security_field( 'manage_proj_clone' ) ?>
							<input type='hidden' name='project_id' value='<?php echo $f_project_id ?>'  />
							<?php  echo lang_get( 'project_name' )?>
							<input type="text" id="project-name" name="new_name" class="input-sm" size="60" maxlength="128" />
							<?php   echo  lang_get( 'description' )?>
							<textarea id="project-description" name="description" class="form-control" cols="70" rows="1"></textarea>
							</div>
							<div>
							<input type="checkbox" id="hier"		name="hier" <?php check_checked( (int)$hier, ON ); ?>>				<label for="sub">Copy Hierarchy</label>&nbsp;&nbsp;&nbsp;
							<input type="checkbox" id="sub" 		name="sub" <?php check_checked( (int)$sub, ON ); ?>>				<label for="sub">Copy Sub-Projects</label>&nbsp;&nbsp;&nbsp;
							<input type="checkbox" id="cat" 		name="cat" <?php check_checked( (int)$cat, ON ); ?>>				<label for="cat">Copy Categories</label>&nbsp;&nbsp;&nbsp;
							<input type="checkbox" id="versions"	name="versions" <?php check_checked( (int)$versions, ON ); ?>>		<label for="versions">Copy Versions</label>&nbsp;&nbsp;&nbsp;
							<input type="checkbox" id="custom" 		name="custom" <?php check_checked( (int)$custom, ON ); ?>>			<label for="custom">Copy Custom Fields</label>&nbsp;&nbsp;&nbsp;
							<input type="checkbox" id="users" 		name="users" <?php check_checked( (int)$users, ON ); ?>>			<label for="users">Copy Users</label>
							</div>
							<div><span class=form-inline>
								<input type="submit" name="copy_from" class="btn btn-sm btn-primary btn-white btn-round" value="<?php  echo  'Clone Project'  ?>"/>
							</span></div>
						</fieldset>
					</form>
				</div>
		</div>
			
	</div>
</div>
</div>
</div>
