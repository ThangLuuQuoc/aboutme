function coolMessage(type, message, callbackYes, callbackNo) 
{
	if(type != 'temporary')
	{
		$("#"+type).modal({
			close:false, 
			overlayId:'confirmModalOverlay',
			containerId:'confirmModalContainer', 
			onOpen: modalOpen,
			onClose: modalClose,
			onShow: function (dialog) {
				dialog.data.find('.message').append(message);
				// if the user clicks "yes"
				dialog.data.find('.yes').click(function () {
					// call the callback
					if ($.isFunction(callbackYes)) {
						callbackYes.apply();
					}
					// close the dialog
					$.modal.close();
				});
				// if the user clicks "no"
				dialog.data.find('.no').click(function () {
					// call the callback
					if ($.isFunction(callbackNo)) {
						callbackNo.apply();
					}
					// close the dialog
					$.modal.close();
				});
			}
		});
	}
	else
	{
		$("#temporary").modal({
			close:false, 
			overlayId:'confirmModalOverlay',
			containerId:'confirmModalContainer', 
			onShow: function (dialog) {
				dialog.data.find('.message').append(message);
				setTimeout("$.modal.close()", 1300);
			}
		
			
		});
	}
}
/**
 * When the open event is called, this function will be used to 'open'
 * the overlay, container and data portions of the modal dialog.
 *
 * onOpen callbacks need to handle 'opening' the overlay, container
 * and data.
 */
function modalOpen (dialog) {
	dialog.overlay.fadeIn('fast', function () {
		dialog.container.fadeIn('fast', function () {
			dialog.data.slideDown('fast');
		});
	});
}

/**
 * When the close event is called, this function will be used to 'close'
 * the overlay, container and data portions of the modal dialog.
 *
 * The SimpleModal close function will still perform some actions that
 * don't need to be handled here.
 *
 * onClose callbacks need to handle 'closing' the overlay, container
 * data and iframe.
 */
function modalClose (dialog) {
	dialog.data.fadeOut('fast', function () {
		dialog.container.hide('fast', function () {
			dialog.overlay.slideUp('fast', function () {
				$.modal.close();
			});
		});
	});
}

/**
 * After the dialog is show, this callback will bind some effects
 * to the data when the 'button' button is clicked.
 *
 * This callback is completely user based; SimpleModal does not have
 * a matching function.
 */
function modalShow (dialog) {
	dialog.data.find('input.animate').one('click', function () {
		dialog.data.slideUp('fast', function () {
			dialog.data.slideDown('fast');
		});
	});
}