<?php
# MantisBT - A PHP based bugtracking system

# MantisBT is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 2 of the License, or
# (at your option) any later version.
#
# MantisBT is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with MantisBT.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Clone projects
 *
 * @package MantisBT
 * @copyright Copyright 2000 - 2002  Kenzaburo Ito - kenito@300baud.org
 * @copyright Copyright 2002  MantisBT Team - mantisbt-dev@lists.sourceforge.net
 * @link http://www.mantisbt.org
 *
 * @uses core.php
 * @uses access_api.php
 * @uses authentication_api.php
 * @uses config_api.php
 * @uses constant_inc.php
 * @uses form_api.php
 * @uses gpc_api.php
 * @uses print_api.php
 * @uses project_api.php
 */

require_once( 'core.php' );
require_api( 'access_api.php' );
require_api( 'authentication_api.php' );
require_api( 'category_api.php' );
require_api( 'config_api.php' );
require_api( 'constant_inc.php' );
require_api( 'form_api.php' );
require_api( 'gpc_api.php' );
require_api( 'print_api.php' );
require_api( 'project_api.php' );
require_api( 'version_api.php' );

form_security_validate( 'manage_proj_clone' );

auth_reauthenticate();

$f_project_id		= gpc_get_int( 'project_id' );
$t_project_name 	= gpc_get_string( 'new_name' );
$t_description	 	= gpc_get_string( 'description' );
$f_hier				= gpc_get_bool( 'hier' );
$f_sub				= gpc_get_bool( 'sub' );
$f_cat				= gpc_get_bool( 'cat' );
$f_versions			= gpc_get_bool( 'versions' );
$f_custom			= gpc_get_bool( 'custom' );
$f_users			= gpc_get_bool( 'users' );
$t_src_project_id	= $f_project_id;

// No name => Exit
if ( $t_project_name == ""){
	print_header_redirect( 'manage_proj_edit_page.php?project_id=' . $f_project_id );
}

# We should check both since we are in the project section and an
#  admin might raise the first threshold and not realize they need
#  to raise the second
access_ensure_project_level( config_get( 'manage_project_threshold' ), $t_dst_project_id );
access_ensure_project_level( config_get( 'project_user_threshold' ), $t_dst_project_id );



// create new project
$sql = "select * from {project} where id = $t_src_project_id" ;
$result = db_query($sql);
while ($row = db_fetch_array($result)) {
	$t_dst_project_id = project_create( strip_tags( $t_project_name ), $t_description, $row['status'], $row['view_state'], $row['file_path'], true, $row['inherit_global'] );
}

// is this a sub project, then make it a child project
if ( $f_hier  ){
	$sql = "select * from {project_hierarchy} where child_id = $t_src_project_id" ;
	$result = db_query($sql);
	while ($row = db_fetch_array($result)) {
		$t_parent	= $row['parent_id'];
		$t_inherit	= $row['inherit_parent'];
		$sql2 = "insert into {project_hierarchy} ( child_id, parent_id, inherit_parent ) values ( '$t_dst_project_id' , '$t_parent', ' $t_inherit' )";
		$result2 = db_query($sql2);
	}
}

// Copy sub projects
if ( $f_sub  ){
	$sql = "select * from {project_hierarchy} where parent_id = $t_src_project_id" ;
	$result = db_query($sql);
	while ($row = db_fetch_array($result)) {
		$t_child	= $row['child_id'];
		$t_inherit	= $row['inherit_parent'];
		$sql2 = "insert into {project_hierarchy} ( child_id, parent_id, inherit_parent ) values ( '$t_child', '$t_dst_project_id' , '$t_inherit' )";
		$result2 = db_query($sql2);
	}
}

// Copy categories
if ( $f_cat ){
	//  just get the active categories that belong to the source project
	$t_query = "SELECT * FROM {category} WHERE project_id = '$t_src_project_id' and status=0 ORDER BY name";
	$t_rows = db_query( $t_query );
//	echo '<pre>'; print_r($array); echo '</pre>';
//	die();
	foreach ( $t_rows as $t_row ) {
		$t_name = $t_row['name'];
		if( category_is_unique( $t_dst_project_id, $t_name ) ) {
			category_add( $t_dst_project_id, $t_name );
		}
	}
}

// Copy versions
if ( $f_versions ){
	$t_rows = version_get_all_rows( $t_src_project_id );
	foreach ( $t_rows as $t_row ) {
		$t_dst_version_id = version_get_id( $t_row['version'], $t_dst_project_id );
		if( $t_dst_version_id === false ) {
			# Version does not exist in target project
			version_add( $t_dst_project_id,	$t_row['version'], $t_row['released'], $t_row['description'], $t_row['date_order'] );
		} else {
			# Update existing version
			# Since we're ignoring obsolete versions, those marked as such in the
			# source project after an earlier copy operation will not be updated
			# in the target project.
			$t_version_data = new VersionData( $t_row );
			$t_version_data->id = $t_dst_version_id;
			$t_version_data->project_id = $t_dst_project_id;

			version_update( $t_version_data );
		}
	}
}

// Copy Custom Fields
if ( $f_custom ){
	project_copy_custom_fields( $t_dst_project_id, $t_src_project_id );
}

// Copy users
if ( $f_users ){
	project_copy_users( $t_dst_project_id, $t_src_project_id, access_get_project_level( $t_dst_project_id ) );
}

form_security_purge( 'manage_proj_clone' );

print_header_redirect( 'manage_proj_edit_page.php?project_id=' . $f_project_id );
