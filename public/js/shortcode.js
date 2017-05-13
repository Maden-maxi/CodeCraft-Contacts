jQuery(document).ready(function ($) {

    $.fn.serializeObject = function(){
        var obj = {};

        $.each( this.serializeArray(), function(i,o){
            var n = o.name,
                v = o.value;

            obj[n] = obj[n] === undefined ? v
                : $.isArray( obj[n] ) ? obj[n].concat( v )
                    : [ obj[n], v ];
        });

        return obj;
    };

    var $document = $(document);
    /**
     * Submitting form
     */
    $document.on('submit', '.cc_contacts_form', function (event){
        event.preventDefault();
        var $this = $(this);
        /*var fromData =  $(this).serializeObject();
        var contact = new wp.api.models.CcContacts({
            title: fromData.cc_name,
            content: fromData.cc_message,
            meta: {
                cc_email: fromData.cc_email
            }
        });
        var s = contact.save();
        console.log(s);*/

        console.log(event);
        $this.find('.dashicons-update').removeClass('hidden').addClass('spin');
        $.ajax({
            method: 'post',
            url: CC_CONTACTS.url,
            data: {
                action: 'cc_contacts_submit',
                nonce: CC_CONTACTS.nonce,
                form_data: $this.serializeArray()
            },
            success: function (data, testStatus, jqXHR) {
                data = JSON.parse(data);
                if(data.success === true){
                    $this.html(data.response_message);
                }
                $this.find('dashicons-update').addClass('hidden').removeClass('spin');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            }
        });

    });

});