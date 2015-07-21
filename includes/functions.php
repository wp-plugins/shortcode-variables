<?php

defined('ABSPATH') or die('Jog on!');

function sh_cd_get_all_shortcodes()
{
	global $wpdb;

	$sql = 'SELECT * FROM ' . $wpdb->prefix . SH_CD_TABLE . ' order by slug asc';

	$rows = $wpdb->get_results( $sql );

	if (!is_null($rows))
		return $rows;
	
	return false;
	
}

function sh_cd_get_shortcode($id)
{
    if (!is_admin())
        return false;

    global $wpdb;

    $sql = $wpdb->prepare('SELECT slug, data FROM ' . $wpdb->prefix . SH_CD_TABLE . ' where id = %d', $id);

    $row = $wpdb->get_row( $sql );

    if (!is_null($row))
        return $row;
    
    return false;
    
}
function sh_cd_get_shortcode_by_slug($slug)
{
    global $wpdb;

    $sql = $wpdb->prepare('SELECT data FROM ' . $wpdb->prefix . SH_CD_TABLE . ' where slug = %s', $slug);

    $row = $wpdb->get_var( $sql );

    if (!is_null($row))
        return stripslashes($row);
    
    return false;
    
}

function sh_cd_save_shortcode($slug, $data, $id = false)
{
    if (!is_admin())
        return false;

    if (false == $id && empty($slug))
        return false;

    global $wpdb;

    $slug = sh_cd_get_slug($slug);

    $result = false;

    if ($id)
    {
        //Update data (Slug can never be updated!)
        $result = $wpdb->update( 
            $wpdb->prefix . SH_CD_TABLE, 
            array( 
                'data' => $data 
            ), 
            array( 'id' => $id), 
            array( 
                '%s'   
            ), 
            array( '%d' ) 
        );
    }
    else
    {
        $result = $wpdb->insert( 
            $wpdb->prefix . SH_CD_TABLE,
            array( 
                'slug' => $slug, 
                'data' => $data 
            ), 
            array( 
                '%s',   
                '%s'   
            )
        );
    }
    
    if (false === $result) {
        return false;
    }
    else
    {
        return true;
    }
    
}

function sh_cd_delete_shortcode($id)
{
    if (!is_admin() || !is_numeric($id))
        return false;

    global $wpdb;

    if (false === $wpdb->delete( $wpdb->prefix . SH_CD_TABLE, array( 'id' => $id ) )) {
        return false; 
    } 
    else {
        return true;
    }
   
}

function sh_cd_get_slug($text)
{
    if(!empty($text))
    {
        $text = sanitize_title($text);

        $original_slug = $text;

        $try = 1;

        // If slug exists, then fetch a unique one!
        while (!sh_cd_is_slug_unique($text))
        {
            $text = $original_slug . '_' . $try;
           
            $try++; 
        }
    }

    return $text;
}

function sh_cd_is_slug_unique($slug)
{
     if (!is_admin() || empty($slug))
        return false;

    global $wpdb;

    $sql = $wpdb->prepare('SELECT count(slug) FROM ' . $wpdb->prefix . SH_CD_TABLE . ' where slug = %s', $slug);

    $row = $wpdb->get_var( $sql );

    if(0 == $row)
    {
        return true;
    }
    else
    {
        return false;
    }


}

function sh_cd_create_database_table()
{
	global $wpdb;

	$table_name = $wpdb->prefix . SH_CD_TABLE;
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
	  id mediumint(9) NOT NULL AUTO_INCREMENT,
	  slug varchar(100) NOT NULL,
	  data text,
	  UNIQUE KEY id (id)
	) $charset_collate;";

    $wpdb->query($sql);

}

function sh_cd_display_message($text, $error = false)
{
    if (!empty($text))
    {
        $class = (($error) ? 'error' : 'updated');

        echo '<div class="' . $class . '">
                <p>' . $text . '</p>
            </div>';
    }
}

function sh_cd_create_dialog_jquery_code($title, $message, $class_used_to_prompt_confirmation, $js_call = false)
{
	global $wp_scripts;
	$queryui = $wp_scripts->query('jquery-ui-core');
	$url = "//ajax.googleapis.com/ajax/libs/jqueryui/".$queryui->ver."/themes/smoothness/jquery-ui.css";
	wp_enqueue_script( 'jquery-ui-dialog' );
	wp_enqueue_style('jquery-ui-smoothness', $url, false, null);

    $id_hash = md5($title . $message . $class_used_to_prompt_confirmation);

    ?>
    <div id='<?php echo $id_hash; ?>' title='<?php echo $title; ?>'>
      <p><?php echo $message; ?></p>
    </div>
     <script>
          jQuery(function($) {
           
            var $info = $('#<?php echo $id_hash; ?>');
            
            $info.dialog({                   
                'dialogClass'   : 'wp-dialog',           
                'modal'         : true,
                'autoOpen'      : false
            });
           
            $('.<?php echo $class_used_to_prompt_confirmation; ?>').click(function(event) {
                
                event.preventDefault();

                target_url = $(this).attr('href');
             
                var $info = $('#<?php echo $id_hash; ?>');
               
                $info.dialog({                   
                    'dialogClass'   : 'wp-dialog',           
                    'modal'         : true,
                    'autoOpen'      : false, 
                    'closeOnEscape' : true,      
                    'buttons'       : {
                        'Yes': function() {

                            <?php if ($js_call != false): ?>
                                <?php echo $js_call; ?>

                                $(this).dialog('close');
                            <?php else: ?>
                                window.location.href = target_url;
                            <?php endif; ?>
                        },
                         'No': function() {
                            $(this).dialog('close');
                        }
                    }
                });

                 $info.dialog('open');
            });

        });    




      </script>

  <?php
}