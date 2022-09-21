<?php
// Meta Box Class: MetaBoxMetaBox
// Get the field value: $metavalue = get_post_meta( $post_id, $field_id, true );
class MetaBoxMetaBox{

	private $screen = array(
		'post',
        'page',
        'dashboard',
                        
	);

	private $meta_fields = array(
                array(
                    'label' => 'text field',
                    'id' => 'textfield_meta',
                    'default' => 'Default value',
                    'type' => 'text',
                ),
    
                array(
                    'label' => 'text area',
                    'id' => 'textarea_meta',
                    'default' => 'Default value',
                    'type' => 'textarea',
                ),
    
                array(
                    'label' => 'WYSIWYG',
                    'id' => 'wysiwyg_meta',
                    'default' => 'Default value',
                    'type' => 'wysiwyg',
                ),
    
                array(
                    'label' => 'checkbox',
                    'id' => 'checkbox_meta',
                    'default' => ' Default value',
                    'type' => 'checkbox',
                ),
    
                array(
                    'label' => 'radio',
                    'id' => 'radio_meta',
                    'default' => 'Default value',
                    'type' => 'radio',
                    'options' => array(
                        'option 1',
                        'option 2',
                        'option 3'
                    )
                ),
    
                array(
                    'label' => 'Select',
                    'id' => 'select_meta',
                    'default' => 'Default value',
                    'type' => 'select',
                    'options' => array(
                        'option 1',
                        'option 2',
                        'option 3'
                    )
                ),
    
                array(
                    'label' => 'media',
                    'id' => 'media_meta',
                    'default' => 'Default value',
                    'type' => 'media',
                    'returnvalue' => 'url'
                ),
    
                array(
                    'label' => 'categories',
                    'id' => 'categories_meta',
                    'default' => 'Default value',
                    'type' => 'categories',
                ),
    
                array(
                    'label' => 'Users',
                    'id' => 'users_meta',
                    'default' => 'Default value',
                    'type' => 'users',
                ),
    
                array(
                    'label' => 'email',
                    'id' => 'email_meta',
                    'default' => 'Default value',
                    'type' => 'email',
                ),
    
                array(
                    'label' => 'url',
                    'id' => 'url_meta',
                    'default' => 'Default value',
                    'type' => 'url',
                ),
    
                array(
                    'label' => 'password',
                    'id' => 'password_meta',
                    'default' => 'Default value',
                    'type' => 'password',
                ),
    
                array(
                    'label' => 'number',
                    'id' => 'number_meta',
                    'default' => 'Default value',
                    'type' => 'number',
                ),
    
                array(
                    'label' => 'color',
                    'id' => 'color_meta',
                    'default' => 'Default value',
                    'type' => 'color',
                ),
    
                array(
                    'label' => 'tel',
                    'id' => 'tel_meta',
                    'default' => 'Default value',
                    'type' => 'tel',
                ),
    
                array(
                    'label' => 'date',
                    'id' => 'date_meta',
                    'default' => 'Default value',
                    'type' => 'date',
                )

	);

	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
                add_action( 'admin_footer', array( $this, 'media_fields' ) );
		add_action( 'save_post', array( $this, 'save_fields' ) );
	}

	public function add_meta_boxes() {
		foreach ( $this->screen as $single_screen ) {
			add_meta_box(
				'MetaBox',
				__( 'MetaBox', 'textdomain' ),
				array( $this, 'meta_box_callback' ),
				$single_screen,
				'normal',
				'default'
			);
		}
	}

	public function meta_box_callback( $post ) {
		wp_nonce_field( 'MetaBox_data', 'MetaBox_nonce' );
                echo 'Here you can put more information';
		$this->field_generator( $post );
	}
        public function media_fields() {
            ?><script>
                jQuery(document).ready(function($){
                    if ( typeof wp.media !== 'undefined' ) {
                        var _custom_media = true,
                        _orig_send_attachment = wp.media.editor.send.attachment;
                        $('.new-media').click(function(e) {
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

	public function field_generator( $post ) {
		$output = '';
		foreach ( $this->meta_fields as $meta_field ) {
			$label = '<label for="' . $meta_field['id'] . '">' . $meta_field['label'] . '</label>';
			$meta_value = get_post_meta( $post->ID, $meta_field['id'], true );
			if ( empty( $meta_value ) ) {
				if ( isset( $meta_field['default'] ) ) {
					$meta_value = $meta_field['default'];
				}
			}
			switch ( $meta_field['type'] ) {
                                case 'users':
                                    $usersargs = array(
                                        'selected' => $meta_value,
                                        'echo' => 0,
                                        'name' => $meta_field['id'],
                                        'id' => $meta_field['id'],
                                        'show_option_none' => 'Select a user',
                                    );
                                    $input = wp_dropdown_users($usersargs);
                                    break;

                                case 'categories':
                                    $categoriesargs = array(
                                        'selected' => $meta_value,
                                        'hide_empty' => 0,
                                        'echo' => 0,
                                        'name' => $meta_field['id'],
                                        'id' => $meta_field['id'],
                                        'show_option_none' => 'Select a category',
                                    );
                                    $input = wp_dropdown_categories($categoriesargs);
                                    break;

                                case 'media':
                                    $meta_url = '';
                                        if ($meta_value) {
                                            if ($meta_field['returnvalue'] == 'url') {
                                                $meta_url = $meta_value;
                                            } else {
                                                $meta_url = wp_get_attachment_url($meta_value);
                                            }
                                        }
                                    $input = sprintf(
                                        '<input style="display:none;" id="%s" name="%s" type="text" value="%s"  data-return="%s"><div id="preview%s" style="margin-right:10px;border:1px solid #e2e4e7;background-color:#fafafa;display:inline-block;width: 100px;height:100px;background-image:url(%s);background-size:cover;background-repeat:no-repeat;background-position:center;"></div><input style="width: 19%%;margin-right:5px;" class="button new-media" id="%s_button" name="%s_button" type="button" value="Select" /><input style="width: 19%%;" class="button remove-media" id="%s_buttonremove" name="%s_buttonremove" type="button" value="Clear" />',
                                        $meta_field['id'],
                                        $meta_field['id'],
                                        $meta_value,
                                        $meta_field['returnvalue'],
                                        $meta_field['id'],
                                        $meta_url,
                                        $meta_field['id'],
                                        $meta_field['id'],
                                        $meta_field['id'],
                                        $meta_field['id']
                                    );
                                    break;


                                case 'select':
                                    $input = sprintf(
                                        '<select id="%s" name="%s">',
                                        $meta_field['id'],
                                        $meta_field['id']
                                    );
                                    foreach ( $meta_field['options'] as $key => $value ) {
                                        $meta_field_value = !is_numeric( $key ) ? $key : $value;
                                        $input .= sprintf(
                                            '<option %s value="%s">%s</option>',
                                            $meta_value === $meta_field_value ? 'selected' : '',
                                            $meta_field_value,
                                            $value
                                        );
                                    }
                                    $input .= '</select>';
                                    break;

                        case 'radio':
                            $input = '<fieldset>';
                            $input .= '<legend class="screen-reader-text">' . $meta_field['label'] . '</legend>';
                            $i = 0;
                            foreach ( $meta_field['options'] as $key => $value ) {
                                $meta_field_value = !is_numeric( $key ) ? $key : $value;
                                $input .= sprintf(
                                    '<label><input %s id=" %s" name="%s" type="radio" value="%s"> %s</label>%s',
                                    $meta_value === $meta_field_value ? 'checked' : '',
                                    $meta_field['id'],
                                    $meta_field['id'],
                                    $meta_field_value,
                                    $value,
                                    $i < count( $meta_field['options'] ) - 1 ? '<br>' : ''
                                );
                                $i++;
                            }
                            $input .= '</fieldset>';
                            break;

                                case 'checkbox':
                                    $input = sprintf(
                                        '<input %s id=" %s" name="%s" type="checkbox" value="1">',
                                        $meta_value === '1' ? 'checked' : '',
                                        $meta_field['id'],
                                        $meta_field['id']
                                        );
                                    break;

                                case 'textarea':
                                    $input = sprintf(
                                        '<textarea style="" id="%s" name="%s" rows="5">%s</textarea>',
                                        $meta_field['id'],
                                        $meta_field['id'],
                                        $meta_value
                                    );
                                    break;
            
				default:
                                    $input = sprintf(
                                        '<input %s id="%s" name="%s" type="%s" value="%s">',
                                        $meta_field['type'] !== 'color' ? 'style="width: 100%"' : '',
                                        $meta_field['id'],
                                        $meta_field['id'],
                                        $meta_field['type'],
                                        $meta_value
                                    );
			}
			$output .= $this->format_rows( $label, $input );
		}
		echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
	}

	public function format_rows( $label, $input ) {
		return '<tr><th>'.$label.'</th><td>'.$input.'</td></tr>';
	}

	public function save_fields( $post_id ) {
		if ( ! isset( $_POST['MetaBox_nonce'] ) )
			return $post_id;
		$nonce = $_POST['MetaBox_nonce'];
		if ( !wp_verify_nonce( $nonce, 'MetaBox_data' ) )
			return $post_id;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;
		foreach ( $this->meta_fields as $meta_field ) {
			if ( isset( $_POST[ $meta_field['id'] ] ) ) {
				switch ( $meta_field['type'] ) {
					case 'email':
						$_POST[ $meta_field['id'] ] = sanitize_email( $_POST[ $meta_field['id'] ] );
						break;
					case 'text':
						$_POST[ $meta_field['id'] ] = sanitize_text_field( $_POST[ $meta_field['id'] ] );
						break;
				}
				update_post_meta( $post_id, $meta_field['id'], $_POST[ $meta_field['id'] ] );
			} else if ( $meta_field['type'] === 'checkbox' ) {
				update_post_meta( $post_id, $meta_field['id'], '0' );
			}
		}
	}
}

if (class_exists('MetaBoxMetabox')) {
	new MetaBoxMetabox;
};