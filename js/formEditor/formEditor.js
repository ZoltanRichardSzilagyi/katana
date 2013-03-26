(function($) {

	var FormEditor = function() {				
		var self = this;
		
		var InputElements = function(){
			
			this.actualPage = 1;
										
			this.add = function(name, properties){
				this[name] = properties;				
			}
			
			this.remove = function(name){
				this[name] = null;
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
					var generatorInput = ui.item;
					generateInput(generatorInput, newInput);
					$(sampleInputListSelector).sortable("cancel");
				},
				// TODO fixme (remove via drag out)
				remove : function(event, ui){
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
			console.log(inputElement);			
			var inputElementType = inputElement.attr("input-type");
			var inputName = generateInputName(inputElementType);
			var inputElementProperties = {
				name : inputName,
				className : inputElementType,
				template : inputElementType,
				label : inputElementType
			}
			sendInputElement(inputElementProperties, function(result){
				attachNewInput(newInput, result, inputElementProperties);
			});
		}
		
		sendInputElement = function(inputElementProperties, successCallback){
			// FIXME hardcoded url			
			$.ajax({
			  type: 'POST',
			  url: '/wp-admin/admin-ajax.php?action=FormEditorController_generateInput',
			  dataType : 'json',
			  data : {
			  	inputElementProperties : inputElementProperties
			  },
			  success: successCallback
			});			
		}
		
		generateInputName = function(inputElementType){
			if(inputElements[inputElementType] == null){
				return inputElementType;
			}else{
				return "name";	
			}			
		}
		
		attachNewInput = function(newInput, result, inputElementProperties){				
			  	newInput.html(result.content);
			  	// TODO bind editor open event
			  	newInput.append('<div class="options"></div>');
			  	var optionsButton = newInput.find('div.options');
			  	// XXX not used
			  	//var properties = result.properties;
			  	var itemPosition = newInput.index();
			  	inputElements.add(inputElementProperties.name, inputElementProperties);
				bindInputEditorHandler(optionsButton, inputElementProperties.name);  	
		}
		
		bindInputEditorHandler = function(optionsButton, inputName){
			optionsButton.click(function(){
				$("#windowWrapper").dialog({
					draggable : true,
					//modal : true,
					resizable: true,
					minWidth: 300,
					minHeight: 300,
					// TODO multilinguale
					title: inputName + " editor",
					zIndex: 85000,
					show: true,
					hide: true,
					buttons : {
						"Cancel": function(ev, ui){
							$(this).dialog("destroy");
						},
						"Save": function(){
							saveInputProperties();
						}
						
					}
				});
				// TODO generate editor content
			});
		}
		
		saveInputProperties = function(){
			// TODO
		}
		
		unbindInputEditorHandler = function(){
			// TODO
		}
		
	};

	formEditor = new FormEditor();
	formEditor.init();
})(jQuery);
