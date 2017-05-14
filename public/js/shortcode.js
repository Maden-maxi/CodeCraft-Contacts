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
     * @since 1.0.0
     * Submitting form
     */
    $document.on('submit', '.cc_contacts_form', function (event){
        // prevent submitting form and reload page
        event.preventDefault();

        var $this = $(this);
        // show load indicator
        $this.find('.dashicons-update').removeClass('hidden').addClass('spin');

        var form_data = $this.serializeArray();
        var save_data = {};
        save_data.title = form_data[0].value;

        // build object to save contact
        for ( var i = 0, fieldLength = form_data.length; i < fieldLength ; i++  ) {
            save_data[form_data[i].name] = form_data[i].value;
            console.log( form_data[i].name, form_data[i].value );
        }

        var post = new wp.api.models.CcContacts( save_data );

        post.save( save_data, {
            /**
             * Display message about success submit form
             *
             * @param model
             * @param response
             * @param options
             */
            success: function (model, response, options) {
                console.log(model, response, options);
                $this.find('dashicons-update').addClass('hidden').removeClass('spin');
                $this.html('<h2>Form submitted success</h2>');
            }
        });

    });

});