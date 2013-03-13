(function($) {

	var FormEditor = function() {
		var self = this;

		var inputDescriptionButtonSelector = "div.sampleInputElement div.descriptionBoxButton";

		this.init = function() {
			setSampleInputsDescriptionButtonEvents();
			setFormInputEvents();
		}
		setSampleInputsDescriptionButtonEvents = function() {
			var buttons = $(inputDescriptionButtonSelector);
			$(buttons).each(function() {
				$(this).click(function() {
					var sampleBox = $(this).next();
					if (sampleBox.css('display') == 'none') {
						sampleBox.fadeIn('slow');
					} else {
						sampleBox.fadeOut('fast');
					}

				});
			});
		};

		setFormInputEvents = function() {
			$(".sampleInputElement").draggable({
				revert : true
			});
			$("#formEditor").droppable({
				drop : function(event, ui) {
					// TODO create input by dropped type
				}
			});
		}
	};

	formEditor = new FormEditor();
	formEditor.init();
})(jQuery);
