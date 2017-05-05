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
});


