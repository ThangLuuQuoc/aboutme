
    jQuery(function ($) {

        // The variable jcrop_api will hold a reference to the
        // Jcrop API once Jcrop is instantiated.
        var jcrop_api;

        // In this example, since Jcrop may be attached or detached
        // at the whim of the user, I've wrapped the call into a function
        initJcrop();

        // The function is pretty simple

        function initJcrop() {
            // Hide any interface elements that require Jcrop
            // (This is for the local user interface portion.)
            $('.requiresjcrop').hide();

            // Invoke Jcrop in typical fashion
            $('#target').Jcrop({
                onChange: showCoords,
                onSelect: showCoords,
                onRelease: clearCoords,
                aspectRatio: 0 // 0
            }, function () {
                jcrop_api = this;
            });

        };

        // Simple event handler, called from onChange and onSelect
        // event handlers, as per the Jcrop invocation above
        function showCoords(c) {
            $('#x1').val(c.x);
            $('#y1').val(c.y);
            $('#x2').val(c.x2);
            $('#y2').val(c.y2);
            $('#w').val(c.w);
            $('#h').val(c.h);
        };

        function clearCoords() {
            $('#coords input').val('');
        }

        // validacion de la imagen a cargar
         $("#imageJcrop").change(function() {
            var val = $(this).val();

            switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
                case 'jpg':
                    document.forms["formJcrop"].submit();
                    break;
                default:
                    $(this).val('');
                    // error message here
                    alert("Extensión NO permitida, debes cargar una imagen con formato: .jpg");
                    break;
            }
        }); 

    });

    function checkCoords() {  
        var msg = '';
        if ($('#w').val() == '') {
            msg += $('#msgSelectImageArea').val() + '\n';
        }

        if (msg == '') {
            document.forms["formJcrop"].submit();
            return true;                
        } else {
            showMessage('warning', msg);
            return false;
        }
    }

    function showMessage(messageType, messageValue) {
        $('div.message').html('<p class="' + messageType + '">' + messageValue + '</p>');
    }