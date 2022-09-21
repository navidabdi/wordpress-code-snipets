<?php

// Settings Page: OptionPage
// Retrieving values: get_option( 'your_field_id' )
class OptionPage_Settings_Page {

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'wph_create_settings' ) );
		add_action( 'admin_init', array( $this, 'wph_setup_sections' ) );
		add_action( 'admin_init', array( $this, 'wph_setup_fields' ) );
                add_action( 'admin_footer', array( $this, 'media_fields' ) );
		add_action( 'admin_enqueue_scripts', 'wp_enqueue_media' );
	}

	public function wph_create_settings() {
		$page_title = 'Option Page';
		$menu_title = 'Option Page';
		$capability = 'manage_options';
		$slug = 'OptionPage';
		$callback = array($this, 'wph_settings_content');
                $icon = 'dashicons-admin-appearance';
		$position = 2;
		add_menu_page($page_title, $menu_title, $capability, $slug, $callback, $icon, $position);
		
	}
    
	public function wph_settings_content() { ?>
		<div class="wrap">
			<h1>Option Page</h1>
			<?php settings_errors(); ?>
			<form method="POST" action="options.php">
				<?php
					settings_fields( 'OptionPage' );
					do_settings_sections( 'OptionPage' );
					submit_button();
				?>
			</form>
		</div> <?php
	}

	public function wph_setup_sections() {
		add_settings_section( 'OptionPage_section', 'this is a simple option page', array(), 'OptionPage' );
	}

	public function wph_setup_fields() {
		$fields = array(
                    array(
                        'section' => 'OptionPage_section',
                        'label' => 'textfield',
                        'placeholder' => 'Placeholder',
                        'id' => 'textfield_option',
                        'desc' => 'Description',
                        'type' => 'text',
                    ),
        
                    array(
                        'section' => 'OptionPage_section',
                        'label' => 'textarea',
                        'placeholder' => 'Placeholder',
                        'id' => 'textarea_option',
                        'desc' => 'Description',
                        'type' => 'textarea',
                    ),
        
                    array(
                        'section' => 'OptionPage_section',
                        'label' => 'WYSIWYG',
                        'placeholder' => 'Placeholder',
                        'id' => 'WYSIWYG_option',
                        'desc' => 'Description',
                        'type' => 'wysiwyg',
                    ),
        
                    array(
                        'section' => 'OptionPage_section',
                        'label' => 'Checkbox',
                        'placeholder' => 'Placeholder',
                        'id' => 'checkbox_option',
                        'desc' => 'Description',
                        'type' => 'checkbox',
                    ),
        
                    array(
                        'section' => 'OptionPage_section',
                        'label' => 'radio',
                        'placeholder' => 'Placeholder',
                        'id' => 'radio_option',
                        'desc' => 'Description',
                        'type' => 'radio',
                        'options' => array(
                            'option 1',
                            'option 2',
                            'option 3'
                        )
                    ),
        
                    array(
                        'section' => 'OptionPage_section',
                        'label' => 'select',
                        'placeholder' => 'Placeholder',
                        'id' => 'select_option',
                        'desc' => 'Description',
                        'type' => 'select',
                        'options' => array(
                            'option 1',
                            'option 2',
                            'option 3'
                        )
                    ),
        
                    array(
                        'section' => 'OptionPage_section',
                        'label' => 'Media',
                        'placeholder' => 'Placeholder',
                        'id' => 'media_option',
                        'desc' => 'Description',
                        'type' => 'media',
                        'returnvalue' => 'url'
                    ),
        
                    array(
                        'section' => 'OptionPage_section',
                        'label' => 'multi select',
                        'placeholder' => 'Placeholder',
                        'id' => 'multi_select_option',
                        'desc' => 'Description',
                        'type' => 'multiselect',
                        'options' => array(
                            'option 1',
                            'option 2',
                            'option 3'
                        )
                    ),
        
                    array(
                        'section' => 'OptionPage_section',
                        'label' => 'users',
                        'placeholder' => 'Placeholder',
                        'id' => 'users_option',
                        'desc' => 'Description',
                        'type' => 'users',
                    ),
        
                    array(
                        'section' => 'OptionPage_section',
                        'label' => 'email',
                        'placeholder' => 'Placeholder',
                        'id' => 'email_option',
                        'desc' => 'Description',
                        'type' => 'email',
                    ),
        
                    array(
                        'section' => 'OptionPage_section',
                        'label' => 'url',
                        'placeholder' => 'Placeholder',
                        'id' => 'url_option',
                        'desc' => 'Description',
                        'type' => 'url',
                    ),
        
                    array(
                        'section' => 'OptionPage_section',
                        'label' => 'password',
                        'placeholder' => 'Placeholder',
                        'id' => 'password_option',
                        'desc' => 'Description',
                        'type' => 'password',
                    ),
        
                    array(
                        'section' => 'OptionPage_section',
                        'label' => 'number',
                        'placeholder' => 'Placeholder',
                        'id' => 'number_option',
                        'desc' => 'Description',
                        'type' => 'number',
                    ),
        
                    array(
                        'section' => 'OptionPage_section',
                        'label' => 'color',
                        'placeholder' => 'Placeholder',
                        'id' => 'color_option',
                        'desc' => 'Description',
                        'type' => 'color',
                    ),
        
                    array(
                        'section' => 'OptionPage_section',
                        'label' => 'tel',
                        'placeholder' => 'Placeholder',
                        'id' => 'tel_option',
                        'desc' => 'Description',
                        'type' => 'tel',
                    ),
        
                    array(
                        'section' => 'OptionPage_section',
                        'label' => 'date',
                        'placeholder' => 'Placeholder',
                        'id' => 'date_option',
                        'desc' => 'Description',
                        'type' => 'date',
                    )
		);
		foreach( $fields as $field ){
			add_settings_field( $field['id'], $field['label'], array( $this, 'wph_field_callback' ), 'OptionPage', $field['section'], $field );
			register_setting( 'OptionPage', $field['id'] );
		}
	}
	public function wph_field_callback( $field ) {
		$value = get_option( $field['id'] );
		$placeholder = '';
		if ( isset($field['placeholder']) ) {
			$placeholder = $field['placeholder'];
		}
		switch ( $field['type'] ) {
            
                        case 'media':
                            $field_url = '';
                            if ($value) {
                                if ($field['returnvalue'] == 'url') {
                                    $field_url = $value;
                                } else {
                                    $field_url = wp_get_attachment_url($value);
                                }
                            }
                            printf(
                                '<input style="display:none;" id="%s" name="%s" type="text" value="%s"  data-return="%s"><div id="preview%s" style="margin-right:10px;border:1px solid #e2e4e7;background-color:#fafafa;display:inline-block;width: 100px;height:100px;background-image:url(%s);background-size:cover;background-repeat:no-repeat;background-position:center;"></div><input style="width: 19%%;margin-right:5px;" class="button menutitle-media" id="%s_button" name="%s_button" type="button" value="Select" /><input style="width: 19%%;" class="button remove-media" id="%s_buttonremove" name="%s_buttonremove" type="button" value="Clear" />',
                                $field['id'],
                                $field['id'],
                                $value,
                                $field['returnvalue'],
                                $field['id'],
                                $field_url,
                                $field['id'],
                                $field['id'],
                                $field['id'],
                                $field['id']
                            );
                            break;

            
                        case 'select':
                            case 'multiselect':
                                if( ! empty ( $field['options'] ) && is_array( $field['options'] ) ) {
                                    $attr = '';
                                    $options = '';
                                    foreach( $field['options'] as $key => $label ) {
                                        $options.= sprintf('<option value="%s" %s>%s</option>',
                                            $key,
                                            selected($value, $key, false),
                                            $label
                                        );
                                    }
                                    if( $field['type'] === 'multiselect' ){
                                        $attr = ' multiple="multiple" ';
                                    }
                                    printf( '<select name="%1$s" id="%1$s" %2$s>%3$s</select>',
                                        $field['id'],
                                        $attr,
                                        $options
                                    );
                                }
                                break;

                        case 'radio':
                            if( ! empty ( $field['options'] ) && is_array( $field['options'] ) ) {
                                $options_markup = '';
                                $iterator = 0;
                                foreach( $field['options'] as $key => $label ) {
                                    $iterator++;
                                    $options_markup.= sprintf('<label for="%1$s_%6$s"><input id="%1$s_%6$s" name="%1$s" type="%2$s" value="%3$s" %4$s /> %5$s</label><br/>',
                                    $field['id'],
                                    $field['type'],
                                    $key,
                                    checked($value, $key, false),
                                    $label,
                                    $iterator
                                    );
                                    }
                                    printf( '<fieldset>%s</fieldset>',
                                    $options_markup
                                    );
                            }
                            break;

                        case 'checkbox':
                            printf('<input %s id="%s" name="%s" type="checkbox" value="1">',
                                $value === '1' ? 'checked' : '',
                                $field['id'],
                                $field['id']
                        );
                            break;

                        case 'wysiwyg':
                            wp_editor($value, $field['id']);
                            break;

                        case 'textarea':
                            printf( '<textarea name="%1$s" id="%1$s" placeholder="%2$s" rows="5" cols="50">%3$s</textarea>',
                                $field['id'],
                                $placeholder,
                                $value
                                );
                                break;
            
			default:
				printf( '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />',
					$field['id'],
					$field['type'],
					$placeholder,
					$value
				);
		}
		if( isset($field['desc']) ) {
			if( $desc = $field['desc'] ) {
				printf( '<p class="description">%s </p>', $desc );
			}
		}
	}
    
    public function media_fields() {
		?><script>
			jQuery(document).ready(function($){
				if ( typeof wp.media !== 'undefined' ) {
					var _custom_media = true,
					_orig_send_attachment = wp.media.editor.send.attachment;
					$('.menutitle-media').click(function(e) {
						var send_attachment_bkp = wp.media.editor.send.attachment;
						var button = $(this);
						var id = button.attr('id').replace('_button', '');
						_custom_media = true;
							wp.media.editor.send.attachment = function(props, attachment){
							if ( _custom_media ) {
								if ($('input#' + id).data('return') == 'url') {
									$('input#' + id).val(attachment.url);
								} else {
									$('input#' + id).val(attachment.id);
								}
								$('div#preview'+id).css('background-image', 'url('+attachment.url+')');
							} else {
								return _orig_send_attachment.apply( this, [props, attachment] );
							};
						}
						wp.media.editor.open(button);
						return false;
					});
					$('.add_media').on('click', function(){
						_custom_media = false;
					});
					$('.remove-media').on('click', function(){
						var parent = $(this).parents('td');
						parent.find('input[type="text"]').val('');
						parent.find('div').css('background-image', 'url()');
					});
				}
			});
		</script><?php
	}
    
}
new OptionPage_Settings_Page();
                