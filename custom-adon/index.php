<?php

/**
 * Plugin Name: Custom Adon
 *
 */

class CustomAdon
{

    public function init()
    {
        add_action("woocommerce_after_order_notes", [$this, "custom_checkout_field",]);
        add_action("woocommerce_checkout_update_order_meta", [$this, "custom_checkout_field_update_order_meta",]);
        add_filter("woocommerce_email_order_meta_fields", [$this, "custom_woocommerce_email_order_meta_fields"], 10, 3);
        add_action("woocommerce_admin_order_data_after_billing_address", [$this, "my_custom_billing_fields_display_admin_order_meta"], 10, 1);
        add_action("woocommerce_order_details_after_customer_details", [$this, "action_woocommerce_order_details_after_customer_details"], 10, 1);
    }

    function custom_checkout_field($checkout)
    {
        $first = date('d.m');
        $final_dates = array('Så snabbt som möjligt');
        $numberOfWeeks = 14;
        $currDate = new DateTime();
        for ($i = 1; $i <= $numberOfWeeks; $i++) {
            $weekCount = $currDate->format("W");
            $firstdayofweek =  $currDate->modify('monday this week')->format('d.m');
            $lastdayofweek = $currDate->modify('sunday this week')->format('d.m');
            $final_dates[] = 'Vecka ' . $weekCount . " (" . $firstdayofweek . "-" . $lastdayofweek . ")";
            $currDate->add(new DateInterval('P7D'));
        }
        echo '<div id="custom_checkout_field"><h2>' . __("") . "</h2>";
        woocommerce_form_field(
            "Leveransdatum",
            [
                "type" => "select",
                "class" => ["my-field-class form-row-wide"],
                "label" => __("Leveransdatum"),
                "placeholder" => __("Leveransdatum"),
                "options" => array_combine($final_dates, $final_dates),
            ],
            $checkout->get_value("Leveransdatum")
        );
        echo "</div>";
    }
    function custom_checkout_field_update_order_meta($order_id)
    {
        if (!empty($_POST["Leveransdatum"])) {
            update_post_meta($order_id, "Leveransdatum", sanitize_text_field($_POST["Leveransdatum"]));
        }
    }
    function custom_woocommerce_email_order_meta_fields($fields, $sent_to_admin, $order)
    {
        $leveransdatum=get_post_meta($order->id, "Leveransdatum", true);
        echo $html_output='<table cellspacing="0" cellpadding="6" style="width: 100%; vertical-align: top; margin-bottom: 40px; padding: 12px; border: 1px solid #cdcdcd; border-radius: 3px;"><tbody><tr><td>Leveransdatum</td><td>'.$leveransdatum.'</td></tr></tbody></table>';
        //$fields["Leveransdatum"] = ["label" => __("Leveransdatum:"), "value" => get_post_meta($order->id, "Leveransdatum", true),];
        //return $fields;
    }

    function my_custom_billing_fields_display_admin_order_meta($order)
    {
        echo "<p><strong>" . __("Leveransdatum") . ":</strong><br> " . get_post_meta($order->id, "Leveransdatum", true) . "</p>";
    }
    function action_woocommerce_order_details_after_customer_details($order)
    {
        echo "Leveransdatum:" . get_post_meta($order->id, "Leveransdatum", true);
    }
}
(new CustomAdon())->init();
