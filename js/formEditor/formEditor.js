(function($) {

	var FormEditor = function() {				
		var self = this;
		
		var inputElements = {};

		var inputDescriptionButtonSelector = "div.sampleInputElement div.descriptionBoxButton";

		this.init = function() {
			setSampleInputsDescriptionButtonEvents();
			setFormInputDragAndDropEvents();
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

		setFormInputDragAndDropEvents = function() {
			$(".sampleInputElement").draggable({
				revert : true
			});
			// TODO "hover effect"
			$("#formEditor").droppable({
				drop : function(event, ui) {
					console.log(event);
					console.log(ui);
					var formEditor = $(this);
					formEditor.addClass('dropEvent');
					setTimeout(function(){
						formEditor.removeClass('dropEvent');
					}, 300);
					
					if(ui.draggable.length == 0){
						return;
					}
					var inputElement = $(ui.draggable[0]);
					var inputElementType = inputElement.attr("input-type");
					if(inputElementType == undefined){
						return;
					}
					generateInput(inputElementType);		
				}
			});
		}
		
		generateInput = function(inputElementType){
			$.ajax({
			  type: 'GET',
			  url: '/wp-admin/admin-ajax.php?action=FormEditorController_generateInput&inputElementType=' + inputElementType,
			  //dataType : 'json',
			  success: function(result){				
				console.log(result);
			  }
			});			
			
		}
	};

	formEditor = new FormEditor();
	formEditor.init();
})(jQuery);
