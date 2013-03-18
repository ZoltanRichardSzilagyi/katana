(function($) {

	var FormEditor = function() {				
		var self = this;
		
		var InputElements = function(){
			
			this.add = function(name, properties){
				this.name = properties;
			}
			
		};
		
		inputElements = new InputElements();

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
		// TODO ugly name, find a better one		
		setFormAddEvent = function(){
			$(sampleInputListSelector).sortable({
				connectWith : "ul",
				receive : function(event, ui){
					$(ui.item).remove();
				}
			});
			$(generatedInputListSelector).sortable({
				connectWith : "ul",
				receive : function(event, ui){
					$(ui.item).after('<li></li>');
					var newInput = $(ui.item).next(); 					
					generateInput(ui.item, newInput);
					$(sampleInputListSelector).sortable("cancel");
				},
				beforeStop : function(event, ui){
					type = $(ui.item).attr("input-type");
					if(type == undefined){
						if(confirm("Delete input item?")){
							$(ui.item).remove();	
						}
						
					}
				}
				
			});
			$(sampleInputListSelector).disableSelection();
			
		}
				
		generateInput = function(inputElement, newInput){			
			var inputElementType = inputElement.attr("input-type");
			// FIXME hardcoded url			
			$.ajax({
			  type: 'POST',
			  url: '/wp-admin/admin-ajax.php?action=FormEditorController_generateInput&inputElementType=' + inputElementType,
			  dataType : 'json',
			  data : {
			  	inputElementProperties : {
			  		className : inputElementType,
			  		name : 'newInput',
			  		template : inputElementType
			  	}
			  },
			  success: function(result){
				attachNewInput(newInput, result);
			  }
			});
		}
		
		attachNewInput = function(newInput, result){
			  	newInput.html(result.content);
			  	var properties = result.properties;
			  	var name = properties.name;
			  	inputElements.add(name, properties);
 				console.log(inputElements);
		}
	};

	formEditor = new FormEditor();
	formEditor.init();
})(jQuery);
