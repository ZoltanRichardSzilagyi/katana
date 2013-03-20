(function($) {

	var FormEditor = function() {				
		var self = this;
		
		var InputElements = function(){
			
				var inputs =  new Array();
							
			this.add = function(position, properties){
				inputs.push(properties);
				var lastElementIndex = inputElements.length--;
				//this.name = properties;				
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
				// nem megfelelő, mozgatáskor is meghívódik
				/*
				beforeStop : function(event, ui){
					type = $(ui.item).attr("input-type");
					if(type == undefined){
						if(confirm("Delete input item?")){
							$(ui.item).remove();	
						}
						
					}
				},*/
				update : function(event, ui){
					if(ui.sender != null){
						console.log('new item');
					}
					console.log(event);
					console.log(ui);
					console.log(ui.item.index());
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
			  		template : inputElementType
			  	}
			  },
			  success: function(result){
				attachNewInput(newInput, result);				
			  }
			});
		}
		
		generateInputName = function(inputElementType){
			return "name" + Math.random * 1000;
		}
		
		attachNewInput = function(newInput, result){
			  	newInput.html(result.content);
			  	var properties = result.properties;
			  	properties.name = generateInput();
			  	var itemPosition = newInput.index();
			  	inputElements.add(itemPosition, properties);
			  	
		}
	};

	formEditor = new FormEditor();
	formEditor.init();
})(jQuery);
