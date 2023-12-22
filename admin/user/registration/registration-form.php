<?php
// disable direct file access
if (!defined('ABSPATH')) {

    exit;

}

//1. Add a new form element...
add_action('register_form', 'punch_card_register_form');
function punch_card_register_form()
{

    $phone = (!empty($_POST['phone'])) ? sanitize_text_field($_POST['phone']) : '';
    $first_name = (!empty($_POST['first_name'])) ? sanitize_text_field($_POST['first_name']) : '';
    $last_name = (!empty($_POST['last_name'])) ? sanitize_text_field($_POST['last_name']) : '';

    ?>
    <p>
        <label for="first_name">
            <?php _e('First Name', PUNCHCARDDOMAIN) ?><br />
            <input type="text" name="first_name" id="first_name" class="input" value="<?php echo esc_attr($first_name); ?>"
                size="25" />
        </label>
    </p>
    <p>
        <label for="last_name">
            <?php _e('Last Name', PUNCHCARDDOMAIN) ?><br />
            <input type="text" name="last_name" id="last_name" class="input" value="<?php echo esc_attr($last_name); ?>"
                size="25" />
        </label>
    </p>
    <p>
        <label for="phone">
            <?php _e('Phone Number', PUNCHCARDDOMAIN) ?><br />
            <input type="text" name="phone" id="phone" class="input" value="<?php echo esc_attr($phone); ?>" size="25" />
        </label>
    </p>
    <?php
}

//2. Add validation. In this case, we make sure phone is required.
add_filter('registration_errors', 'punch_card_registration_errors', 10, 3);
function punch_card_registration_errors($errors, $sanitized_user_login, $user_email)
{

    // Check the phone number.
    if ('' === $_POST['phone']) {
        $errors->add('empty_phone', sprintf('<strong>%s</strong>: %s', __('ERROR', PUNCHCARDDOMAIN), __('You must include a phone number.', PUNCHCARDDOMAIN)));
    } elseif (!is_phone_number($_POST['phone'])) {
        $errors->add('invalid_phone_number', __('<strong>Error:</strong> The phone number is not correct.', PUNCHCARDDOMAIN));
        $_POST['phone'] = '';
    } elseif (phone_exists($_POST['phone'])) {
        $errors->add(
            'phone_exists',
            sprintf(
                /* translators: %s: Link to the login page. */
                __('<strong>Error:</strong> This phone is already registered.', PUNCHCARDDOMAIN),
                wp_login_url()
            )
        );
    }

    if (empty($_POST['first_name']) || !empty($_POST['first_name']) && trim($_POST['first_name']) == '') {
        $errors->add('first_name_error', sprintf('<strong>%s</strong>: %s', __('ERROR', PUNCHCARDDOMAIN), __('You must include a first name.', PUNCHCARDDOMAIN)));

    }

    if (empty($_POST['last_name']) || !empty($_POST['last_name']) && trim($_POST['last_name']) == '') {
        $errors->add('last_name_error', sprintf('<strong>%s</strong>: %s', __('ERROR', PUNCHCARDDOMAIN), __('You must include a last name.', PUNCHCARDDOMAIN)));

    }

    return $errors;
}

//3. Finally, save our extra registration user meta.
add_action('user_register', 'punch_card_user_register');
function punch_card_user_register($user_id)
{
    if (!empty($_POST['phone'])) {
        update_user_meta($user_id, 'phone', sanitize_text_field($_POST['phone']));
    }

    if (!empty($_POST['first_name'])) {
        update_user_meta($user_id, 'first_name', sanitize_text_field($_POST['first_name']));
    }

    if (!empty($_POST['last_name'])) {
        update_user_meta($user_id, 'last_name', sanitize_text_field($_POST['last_name']));
    }
}