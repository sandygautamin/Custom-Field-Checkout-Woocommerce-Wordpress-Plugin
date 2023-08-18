function termsAndConditions(isEnabled=false){
    var termsAndCon='';
    if(isEnabled==true){
    termsAndCon=`<div class="woocommerce-terms-and-conditions-wrapper"><p class="form-row validate-required">
        <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
        <input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" id="terms">
            <span class="woocommerce-terms-and-conditions-checkbox-text">I have read and agree to the website <a href="terms-and-conditions/" class="woocommerce-terms-and-conditions-link" target="_blank">terms and conditions</a></span>&nbsp;<abbr class="required" title="required">*</abbr>
        </label>
        <input type="hidden" name="terms-field" value="1">
    </p></div>`
   
    } 
    return termsAndCon;
}
jQuery(document).on("change",'input[name="payment_method"]',function(){
    
    var paymentGatway=jQuery('input[name="payment_method"]:checked').val();
    
    if(paymentGatway!='ppcp-gateway'){
        var termHtml=termsAndConditions(false);
        jQuery(".woocommerce-cusotm-terms").html(termHtml);
    } else {
        jQuery(".woocommerce-cusotm-terms").html(termsAndConditions(true));
    }
});

jQuery(window).load(function(){
    jQuery('input[name="payment_method"]').trigger("change");
})
