(function($) {

	var FormEditor = function() {				
		var self = this;
		
		var inputElements = {};

		var inputDescriptionButtonSelector = "div.sampleInputElement div.descriptionBoxButton";
		
		var sampleInputListSelector = "#sampleInputsList";
		
		var generatedInputListSelector = "#generatedInputList";

		this.init = function() {
			setSampleInputsDescriptionButtonEvents();
			setFormAddEvent();
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
		
		setFormAddEvent = function(){
			$(sampleInputListSelector).sortable({
				connectWith : "ul"				
			});
			$(generatedInputListSelector).sortable({
				connectWith : "ul",
				receive : function(event, ui){
					$(ui.item).after('<li></li>');
					var newInput = $(ui.item).next(); 
					console.log(newInput);
					generateInput(ui.item, newInput);
					$(sampleInputListSelector).sortable("cancel");
				},
				
			});			
			$(sampleInputListSelector).disableSelection();
			$(generatedInputListSelector).disableSelection();
			
		}
				
		generateInput = function(inputElement, newInput){			
			var inputElementType = inputElement.attr("input-type");			
			$.ajax({
			  type: 'GET',
			  url: '/wp-admin/admin-ajax.php?action=FormEditorController_generateInput&inputElementType=' + inputElementType,
			  //dataType : 'json',
			  success: function(result){
			  	console.log(newInput);
			  	newInput.html(result);				
			  }
			});			
			
		}
	};

	formEditor = new FormEditor();
	formEditor.init();
})(jQuery);
