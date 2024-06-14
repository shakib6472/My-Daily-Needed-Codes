<?php


// Function to display the custom metabox
function add_custom_user_metabox($user)
{
?>
    <h2>Custom User Metabox</h2>
    <div class="form-group row">
        <div class="col-md-4">


            <label for="due_amount" class="col-12 col-form-label">Total Due Amount</label>
            <div class="col-sm-10 input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">£</span>
                </div>
                <input type="number" name="due_amount" id="due_amount" value="<?php echo esc_attr(get_the_author_meta('due_amount', $user->ID)); ?>" class="form-control" />
            </div>
        </div>
    </div>
<?php
}


// Hook to add custom user metabox
add_action('show_user_profile', 'add_custom_user_metabox');
add_action('edit_user_profile', 'add_custom_user_metabox');


// Function to save the custom metabox data
function save_custom_user_metabox($user_id)
{
    // Check for required capabilities
    if (!current_user_can('edit_user', $user_id)) {
        return false;
    }

    // Save custom field
    update_user_meta($user_id, 'due_amount', sanitize_text_field($_POST['due_amount']));
}


// Hook to save custom user metabox data
add_action('personal_options_update', 'save_custom_user_metabox');
add_action('edit_user_profile_update', 'save_custom_user_metabox');



/*=========================================
* Initial deu value - 10000
==========================================*/

// Hook to set default value for custom field when a new user is created

// Function to set default due amount for new users
function set_default_due_amount($user_id)
{
    update_user_meta($user_id, 'due_amount', '1000');
}

add_action('user_register', 'set_default_due_amount');





/*=========================================
* Initial deu value - 10000
==========================================*/

// Hook to add custom content to WooCommerce My Account page
add_action('woocommerce_account_content', 'display_due_amount_on_my_account', 1);

// Function to display due amount on My Account page
function display_due_amount_on_my_account()
{
    // Get the current user's ID
    $user_id = get_current_user_id();

    // Get the due amount for the current user
    $due_amount = get_user_meta($user_id, 'due_amount', true);

    // Display the due amount if it exists
    if ($due_amount) {
        echo '<div class="woocommerce-MyAccount-content">';
        echo '<h3>Due Amount: £' . esc_html($due_amount) . '</h3>';
        echo '</div>';
    }
}

/*=========================================
            * Decut the order avlue - 10000
            ==========================================*/
// Hook into WooCommerce order completion
add_action('woocommerce_order_status_completed', 'update_due_amount_on_purchase');

// Function to update due amount when a purchase is completed
function update_due_amount_on_purchase($order_id)
{
    // Get the order object
    $order = wc_get_order($order_id);

    // Get the user ID from the order
    $user_id = $order->get_user_id();

    // If the order has a user ID
    if ($user_id) {
        // Get the total amount spent in the order
        $order_total = $order->get_total();

        // Get the current due amount for the user
        $current_due_amount = get_user_meta($user_id, 'due_amount', true);

        // Calculate the new due amount
        $new_due_amount = max(0, $current_due_amount - $order_total);

        // Update the due amount for the user
        update_user_meta($user_id, 'due_amount', $new_due_amount);
    }
}
