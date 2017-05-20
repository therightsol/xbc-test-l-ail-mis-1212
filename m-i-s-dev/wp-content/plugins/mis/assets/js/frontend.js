/**
 * Created by PACP2 on 4/29/2017.
 */


jQuery('document').ready(function ($){
    var ftests_id = jQuery('#ftests');
    ftests_id.select2();

    ftests_id.change(function (){
        $(this).find('option:selected').each(function() {
            //console.log($(this).attr('data-testprice'));
            var price = $(this).attr('data-testprice');
            $('#tprice').val(price);
        });

        $('.patient_register_step2_submit_btn').removeAttr('disabled');
    });

    $('input[name="patient_returning_new"]').click(function (){

        var regForm = $('#patient-registration-form');
        var regForm_genralInputs = $('#general-registration-inputs');
        var pid = $('#pid');



        if ($(this).val() === 'n') // new customer
        {
            regForm.slideDown(700);
            regForm_genralInputs.show();

            pid.attr('readonly', true).val($.now());
        }
        else if ($(this).val() === 'r') // returning customer
        {
            regForm.slideDown(700);
            regForm_genralInputs.hide();
            pid.attr('readonly', false).val('');
        }

    });

    $('#regform_submit').click(function (e){

        if ($('input[name="patient_returning_new"]:selected').val() === 'r'){
            e.preventDefault();

            var pid = $('#pid').val();

            var data = {
                'action': 'get_patient_record',
                'pid': pid
            };

            // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
            jQuery.post(ajax_object.ajax_url, data, function(response) {

                if (response === 'not-found'){
                    $('#regform_submit').parent().prepend('<div class="alert regform_no_record_found alert-warning"><strong>Sorry! No record found. </strong></div>');
                }else {
                    $('.regform_no_record_found').remove();

                    response = $.parseJSON(response);

                    //console.log(response);

                    // populating inputs
                    $('#name').val(response['data']['user_nicename']).attr('readonly', true);
                    $('#phone-number').val(response['phone_number']['0']).attr('readonly', true);



                    // displaying general input fields
                    $('#general-registration-inputs').show();
                }

            });

        }




    });
});


