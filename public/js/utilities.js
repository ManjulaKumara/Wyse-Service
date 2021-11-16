$('.item').autocomplete({
    source:function(request,response){
        let _url=APP_URL+'/ajax/search-items-n-services';
        $.ajax({
            url:_url,
            type: 'get',
            dataType:'json',
            data:{
                search:request.term
            },
            success:function(data){
                response(data);
            }
        });
    },
    minlength:1,
    select:function(event,ui){
        $('.item').val(ui.item.name);
        itemData(ui.item.id,ui.item.type);
        return false;
    }
});

function itemData(id,type){
    if( id !=null &&  id !='')
    {
        let _url = APP_URL+'/ajax/item/view/'+id;
        $.ajax({
            url: _url,
            type: "GET",
            success: function(response) {
                if(response) {
                    $('.supplier_id').val(response.id);
                    $('.supplier_code').val(response.supplier_code);
                    $('.supplier_name').val(response.supplier_name);
                    $('.supplier_contact_person').val(response.contact_person);
                    $('.contact_number_1').val(response.contact_number_1);
                    $('.contact_number_2').val(response.contact_number_2);
                    $('.supplier_email').val(response.email);
                    $('.supplier_fax').val(response.fax);
                    $('.supplier_address_line_1').val(response.address_line_1);
                    $('.supplier_address_line_2').val(response.address_line_2);
                    $('.supplier_city').val(response.city);
                    $('.open_balance').val(response.open_balance);
                    $('.is_active').val(response.is_active);

                }
            }
        });
    }
}


