<?php
/*
Plugin Name: gravity admin email notice
Plugin Script: gravity-adminemailnotice.php
Plugin URI: http://www.redpik.net
Description: Display notice if notification is set to "{admin_email}" on a Gravity Form
Version: 0.1
License: GPL
Author: Benjamin PONGY
Author URI: http://www.redpik.net

=== RELEASE NOTES ===
2014-07-18 - v0.1 - first version
*/

/*
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
Online: http://www.gnu.org/licenses/gpl.txt
*/



function gravity_admin_mail_check() {
	$screen = get_current_screen();
	
	
	if( $screen->parent_base == 'gf_edit_forms' ) {
		
		$check_notif = array();
		
		$formulaires = RGFormsModel::get_forms(null, "title");
		foreach( $formulaires as $formulaire ) {
			if( intval($formulaire->is_active) ) {
				$form = RGFormsModel::get_form_meta($formulaire->id);
				
				foreach ($form['notifications'] as $notif) {
					if( $notif['to']=='{admin_email}' )
						$check_notif[] = $formulaire->title;
				}
			}
		}
		
		if( count($check_notif) ) {
			echo '<div class="error">';
			echo '<p>Attention! </p><ul>';
			foreach ($check_notif as $notif) {
				echo '<li> - Le formulaire "<strong>'.$notif.'</strong>" a pour destinataire de notification "<strong>'.get_bloginfo("admin_email").'</strong>"</li>';
			}
			echo '</ul></div>';
		}
	}
}
add_action( 'admin_notices', 'gravity_admin_mail_check' );
