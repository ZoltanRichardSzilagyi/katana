(function($){
	var FormEditor = function(){
		var self = this;
		var position = 1;
		// TODO translate texts
		var InputEditorElements = {
			name : {
				label: 'Mező neve',
				type: 'text',
				position:position++
			},
			label : {
				label: 'Mező címkéje',
				type: 'text',
				position:position++
			},
			placeholder : {
				label: 'Placeholder',
				type: 'text',
				position:position++
			},			
			readOnly : {
				label: 'Csak olvasható',
				type: 'checkbox',
				position:position++
			},
			maxLength : {
				label: 'Bevihető szöveg hossza',
				type: 'text',
				position:position++
			},			
		};
		
		var InputElements = function(){														
			this.add = function(name, properties){
				this[name] = properties;				
			}			
			this.remove = function(name){
				this[name] = null;
			}			
		};
		
		var Pages = function(){
			var pagesNum = 1;
			var currentPage = 1;
			
			this.add = function(){
				pagesNum++;
				currentPage = pagesNum;
			}
			this.remove = function(){
				pagesNum--;
			}
			
			this.getPagesNum = function(){
				return pagesNum;
			}
			
			this.setCurrentPage = function(pageId){
				currentPage = pageId;
			}
			
			this.getCurrentPage = function(){
				return currentPage;
			}
		}
		
		var pages = new Pages();
		
		inputElements = new InputElements();

		var inputDescriptionButtonSelector = "div.sampleInputElement div.descriptionBoxButton";
		
		var sampleInputListSelector = "#sampleInputsList";
		
		var formPageSelector = ".formPage";
		
		var activeFormPageSelector =".formPage.active"
		
		var newPageButtonSelector = "#addPage";
		
		var currentPageSelector = "#currentPage";
		
		var formInputElementsSelector = "#formInputElements";

		this.init = function() {
			setSampleInputsDescriptionButtonEvents();
			bindFormAddEvent();
			addNewPageButtonEvent();
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
		bindFormAddEvent = function(){
			$(sampleInputListSelector).sortable({
				connectWith : "ul",
				receive : function(event, ui){
					$(ui.item).remove();
				}
			});
			// TODO create sample window instead of embedded that in the button
			$(sampleInputListSelector).disableSelection();
			
			setFormpageToSortable($(formPageSelector));			
		}
		
		setFormpageToSortable = function(inputLists){
			$(inputLists).sortable({
				connectWith : "ul",
				receive : function(event, ui){
					$(ui.item).after('<li class="inputWrapper"></li>');
					var newInput = $(ui.item).next();
					var generatorInput = ui.item;
					generateInput(generatorInput, newInput);
					$(sampleInputListSelector).sortable("cancel");
				},
				over : function(event, ui){
					// TODO add highlighting
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
		}
				
		generateInput = function(inputElement, newInput){			
			var inputElementType = inputElement.attr("input-type");
			var inputName = generateInputName(inputElementType);
			var inputElementProperties = {
				name : inputName,
				className : inputElementType,
				template : inputElementType,
				label : inputElementType
			}
			sendInputElement(inputElementProperties, function(result){
				attachNewInput(newInput, result, result.properties);
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
				// TODO generate name
				return "name";	
			}			
		}
		
		attachNewInput = function(newInput, result, inputElementProperties){
			  	newInput.html(result.content);

			  	newInput.append('<div class="options"></div>');
			  	var optionsButton = newInput.find('div.options');

			  	var itemPosition = newInput.index();
			  	var inputName = inputElementProperties.name;
			  	
			  	inputElements.add(inputName, inputElementProperties);

				var inputWindowWrapperId = "#window_" + inputName;					
				var inputWindowWrapper = $('<div/>', {
					id : inputWindowWrapperId,
				});
				inputWindowWrapper.addClass("inputWindowEditor");
				generateInputWindowForm(inputName, inputWindowWrapper, result.properties);	
				
				bindInputEditorHandler(optionsButton, inputElementProperties.name, inputWindowWrapper);
		}
		
		bindInputEditorHandler = function(optionsButton, inputName, inputWindowWrapper){
			optionsButton.click(function(){

				$(inputWindowWrapper).dialog({
					draggable : true,
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
							changeInputProperties($(this));
						}
						
					}
				});
			});
		}
		
		generateInputWindowForm = function(inputName, wrapper, properties){
			var propertyForm = $('<form/>',{			
			})
			var attributePropertyInputs = new Array();
			for(propertyIndex in properties){
				var property = propertyIndex;
				var propertyAttributes = InputEditorElements[propertyIndex];
				if(propertyAttributes != undefined){
					propertyAttributes.value = properties[propertyIndex];
					var inputId = inputName + "_" + propertyIndex;
					generateInputWindowInput(attributePropertyInputs, inputId, propertyAttributes);										
				}	
				
			};
			$.each(attributePropertyInputs, function(index, propertyInput){
				propertyForm.append(propertyInput);
			});
			var oldNameInput = createHiddenInputField('old-name', inputName);
			propertyForm.append(oldNameInput);
			wrapper.append(propertyForm);			
		}
		
		createHiddenInputField = function(name, value){
			var input = $('<input/>');
			input.prop('name', name);
			input.prop('type', 'hidden');
			input.val(value);
			return input;
		}
		
		generateInputWindowInput = function(attributePropertyInputs, inputId, attributes){
			var type = attributes.type;
			var input;
			var label = $('<label/>', {
				text: attributes.label,
			});
			label.prop('for', inputId);
			switch(type){
				case 'text' :
					input = $('<input/>', {});
					input.prop('name', inputId);
					input.prop('id', inputId);
					input.prop("type", "text");
					input.prop('value', attributes.value);
					
				break;
				case 'checkbox' :
					input = $('<input/>', {});
					input.prop('name', inputId);
					input.prop('id', inputId);
					input.prop('type', 'checkbox');
					input.prop('value', 1);
					if(attributes.value == 1){
						input.prop('checked', true);	
					}
				break;				
			}
			wrapper = $('<div/>',{});
			wrapper.addClass('inputPropertyWrapper');
			wrapper.append(label);
			wrapper.append(input)
			attributePropertyInputs[attributes.position] = wrapper;
		}
		
		changeInputProperties = function(propertyWindow){
			var form = $(propertyWindow).find('form');
			var inputOldName = $(form).find('input[name=old-name]');			
			var oldName = inputOldName.val();			
			var inputs = $(form).find('input, select, textarea').not('input[name=old-name]');
			
			var inputProperties = $.extend(true, {}, inputElements[oldName]);			
			$.each(inputs, function(index, input){
				var inputName = $(input).prop('name');
				var inputNamePrefix = oldName + '_';
				var propertyName = inputName.replace(inputNamePrefix, '');
				var inputValue = $(input).val();
				switch($(input).prop("type")){
					case 'checkbox':
						if($(input).prop("checked")){
							inputProperties[propertyName] = 1;	
						}else{
							inputProperties[propertyName] = 0;
						}
					break;
					case 'select-one':
						// TODO
					break;
					default:
						inputProperties[propertyName] = inputValue;
					break;
				}
				
			});
			sendInputElement(inputProperties, function(result){
				propertyWindowSaveEvent(oldName, result, propertyWindow);
				
			});			

		}
		
		propertyWindowSaveEvent = function(inputOldName, result, propertyWindow){
			if(result.valid){
				var generatedInput = $('input[name='+inputOldName+']');
				var inputWrapper = generatedInput.closest('li.inputWrapper');				
				attachNewInput(inputWrapper, result, result.properties);
				inputElements[inputOldName] = null;
				var inputName = result.properties.name;				
				inputElements[inputName] = result.properties;
				propertyWindow.dialog('destroy');
				console.log(inputElements);
			}else{
				propertyWindowErrorEvent(result);
			}
		}
		
		propertyWindowErrorEvent = function(result){
			// TODO develop
			alert('input property error');	
		}
		
		unbindInputEditorHandler = function(){
			// TODO when input delete
			// TODO delete inputwindowwrapper
		}
		
		addNewPageButtonEvent = function(){
			$(newPageButtonSelector).click(function(){
				addNewPage();				
			});
		}
		
		addNewPage = function(){
			pages.add();
			$(currentPageSelector).html(pages.getPagesNum());
			
			var newFormPage = createNewFormPage();
			$(formInputElementsSelector).append(newFormPage);
			setFormpageToSortable(newFormPage);
			setFormPageToActive(newFormPage);
		}
		
		createNewFormPage = function(){
			var formWrapper = $('<ul/>');
			formWrapper.addClass('formPage droptrue');
			return formWrapper;
		}
		
		setFormPageToActive = function(formPage){
			var activePage = $(activeFormPageSelector);
		}
		
		
		
	};

	formEditor = new FormEditor();
	formEditor.init();
})(jQuery);
