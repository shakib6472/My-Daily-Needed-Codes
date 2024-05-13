jQuery(document).ready(function ($) {


    function qtybuttonclick(selectedValue) {
        
        $(".wcf-qty-row.wcf-qty-row-1228 input.wcf-qty-selection").val(selectedValue - 1);
        $(".wcf-qty-row.wcf-qty-row-1228 .wcf-qty-selection-btn.wcf-qty-increment.wcf-qty-change-icon").click();
    
    }


    $('p#billing_second_child_name_field').hide();
    $('p#billing_third_child_name_field').hide();
    $('p#billing_fourth_child_name_field').hide();
    $('p#billing_fifth_child_name_field').hide();
    $('p#billing_sixth_child_name_field').hide();
    $('p#billing_seventh_child_name_field').hide();
    $('p#billing_eighth_child_name_field').hide();
    $('p#billing_child_name_field').hide();

    $('select#billing_how_many_child_you_have_').change(function () {

        var selectedValue = $(this).val(); // Get the selected value
        console.log(selectedValue);

        // Check if the selected value is '1'
        if (selectedValue === '1') {
            $('p#billing_first_child_name__field').show();
            $('p#billing_second_child_name_field').hide();
            $('p#billing_third_child_name_field').hide();
            $('p#billing_fourth_child_name_field').hide();
            $('p#billing_fifth_child_name_field').hide();
            $('p#billing_sixth_child_name_field').hide();
            $('p#billing_seventh_child_name_field').hide();
            $('p#billing_eighth_child_name_field').hide();
            $('p#billing_child_name_field').hide();
                qtybuttonclick(selectedValue);


        }
        if (selectedValue === '2') {
            $('p#billing_first_child_name__field').show();
            $('p#billing_second_child_name_field').show();
            $('p#billing_third_child_name_field').hide();
            $('p#billing_fourth_child_name_field').hide();
            $('p#billing_fifth_child_name_field').hide();
            $('p#billing_sixth_child_name_field').hide();
            $('p#billing_seventh_child_name_field').hide();
            $('p#billing_eighth_child_name_field').hide();
            $('p#billing_child_name_field').hide();
            qtybuttonclick(selectedValue);
           
        }
        if (selectedValue === '3') {
            $('p#billing_first_child_name__field').show();
            $('p#billing_second_child_name_field').show();
            $('p#billing_third_child_name_field').show();
            $('p#billing_fourth_child_name_field').hide();
            $('p#billing_fifth_child_name_field').hide();
            $('p#billing_sixth_child_name_field').hide();
            $('p#billing_seventh_child_name_field').hide();
            $('p#billing_eighth_child_name_field').hide();
            $('p#billing_child_name_field').hide();
            qtybuttonclick(selectedValue);
        }
        if (selectedValue === '4') {
            $('p#billing_first_child_name__field').show();
            $('p#billing_second_child_name_field').show();
            $('p#billing_third_child_name_field').show();
            $('p#billing_fourth_child_name_field').show();
            $('p#billing_fifth_child_name_field').hide();
            $('p#billing_sixth_child_name_field').hide();
            $('p#billing_seventh_child_name_field').hide();
            $('p#billing_eighth_child_name_field').hide();
            $('p#billing_child_name_field').hide();
            qtybuttonclick(selectedValue);
        }
        if (selectedValue === '5') {
            $('p#billing_first_child_name__field').show();
            $('p#billing_second_child_name_field').show();
            $('p#billing_third_child_name_field').show();
            $('p#billing_fourth_child_name_field').show();
            $('p#billing_fifth_child_name_field').show();
            $('p#billing_sixth_child_name_field').hide();
            $('p#billing_seventh_child_name_field').hide();
            $('p#billing_eighth_child_name_field').hide();
            $('p#billing_child_name_field').hide();
            qtybuttonclick(selectedValue);
        }
        if (selectedValue === '6') {
            $('p#billing_first_child_name__field').show();
            $('p#billing_second_child_name_field').show();
            $('p#billing_third_child_name_field').show();
            $('p#billing_fourth_child_name_field').show();
            $('p#billing_fifth_child_name_field').show();
            $('p#billing_sixth_child_name_field').show();
            $('p#billing_seventh_child_name_field').hide();
            $('p#billing_eighth_child_name_field').hide();
            $('p#billing_child_name_field').hide();
            qtybuttonclick(selectedValue);
        }
        if (selectedValue === '7') {
            $('p#billing_first_child_name__field').show();
            $('p#billing_second_child_name_field').show();
            $('p#billing_third_child_name_field').show();
            $('p#billing_fourth_child_name_field').show();
            $('p#billing_fifth_child_name_field').show();
            $('p#billing_sixth_child_name_field').show();
            $('p#billing_seventh_child_name_field').show();
            $('p#billing_eighth_child_name_field').hide();
            $('p#billing_child_name_field').hide();
            qtybuttonclick(selectedValue);
        }
        if (selectedValue === '8') {
            $('p#billing_first_child_name__field').show();
            $('p#billing_second_child_name_field').show();
            $('p#billing_third_child_name_field').show();
            $('p#billing_fourth_child_name_field').show();
            $('p#billing_fifth_child_name_field').show();
            $('p#billing_sixth_child_name_field').show();
            $('p#billing_seventh_child_name_field').show();
            $('p#billing_eighth_child_name_field').show();
            $('p#billing_child_name_field').hide();
            qtybuttonclick(selectedValue);
        }
        if (selectedValue === '9') {
            $('p#billing_first_child_name__field').show();
            $('p#billing_second_child_name_field').show();
            $('p#billing_third_child_name_field').show();
            $('p#billing_fourth_child_name_field').show();
            $('p#billing_fifth_child_name_field').show();
            $('p#billing_sixth_child_name_field').show();
            $('p#billing_seventh_child_name_field').show();
            $('p#billing_eighth_child_name_field').show();
            $('p#billing_child_name_field').show();
            qtybuttonclick(selectedValue);
        }

    });

});