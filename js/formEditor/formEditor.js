(function ($) {
	"use strict";
	
	// TODO descriptors not used yet
	var KatanaFormInputDescriptor = function(){
		
		var templates,		
		  label;
		
		this.setTemplates = function(templatesList){
			templates = templatesList;
		};
		
		this.setDefaultLabel = function(label){
			alert(label);
		};		
	},
	
	KatanaFormInputDescriptorHolder = function(){
		this.add = function(inputType, properties){
			this[inputType] = properties;				
		};
		
		this.get = function(inputType){
			return this[inputType];
		};			
		
	},
	
	
	Pages = function(){
		var pagesNum = 1,
		currentPage = 1;
		
		this.add = function(){
			pagesNum+=1;
		};
		
		this.remove = function(){
			pagesNum-=1;
		};
		
		this.getPagesNum = function(){
			return pagesNum;
		};
		
		this.setCurrentPage = function(pageId){
			currentPage = pageId;
		};
		
		this.getCurrentPage = function(){
			return currentPage;
		};
	},
	
	inputElementPosition = 1,
	
	InputEditorElements = {
		name : {
			label: 'Mező neve',
			type: 'text',
			position:inputElementPosition+=1
		},
		label : {
			label: 'Mező címkéje',
			type: 'text',
			position:inputElementPosition+=1
		},
		placeholder : {
			label: 'Placeholder',
			type: 'text',
			position:inputElementPosition+=1
		},			
		readOnly : {
			label: 'Csak olvasható',
			type: 'checkbox',
			position:inputElementPosition+=1
		},
		maxLength : {
			label: 'Bevihető szöveg hossza',
			type: 'text',
			position:inputElementPosition+=1
		},
		value : {
			label: 'Érték',
			type: 'text',
			position:inputElementPosition+=1
		}					
	},
	
	InputElements = function(){														
		this.add = function(name, properties){
			this[name] = properties;				
		};
		this.remove = function(){
		    this[name] = null;
		}			
		this.get = function(name){
			return this[name];
		};
	},
	
	Selectors = {
		formEditor : "#formEditor",
		
		inputDescriptionButtonSelector : "div.sampleInputElement div.descriptionBoxButton",
		
		sampleInputList : "#sampleInputsList",
		
		formPage : ".formPage",
		
		activeFormPage :".formPage.active",
		
		prevPage : "#prevPage",
		
		nextPage : "#nextPage",
		
		newPageButton : "#addPage",
		
		currentPage : "#currentPage",
		
		formInputElements : "#formInputElements",
		
		formPager : ".formPager"		
	},	
		

	FormEditor = function(){
		var self = this,

		// TODO translate texts
						
		pages = new Pages(),
		
		inputElements = new InputElements(),
		
		getSampleElements = function(successCallback){
            // FIXME hardcoded url          
            $.ajax({
              type: 'GET',
              url: '/wp-admin/admin-ajax.php?action=Katana_getSampleElements',
              dataType : 'json',
              success: successCallback
            });         		    		    
		},
		
		createSampleElement = function(sampleElement){
		    var sampleElementWrapper,
		    sampleElementOptions;
		    
		    if(sampleElement.elementOptions === null ||
		        sampleElement.elementOptions.type === undefined ||
		        sampleElement.elementOptions.type === null){
		        return;
		    }

		    sampleElementOptions = sampleElement.elementOptions;
		    // TODO
		    //elementTypes.add(sampleElementOptions.type, sampleElementOptions);
		    sampleElementWrapper = $('<li/>');
		    sampleElementWrapper.attr("input-type", sampleElementOptions.type)
		    sampleElementWrapper.attr("simple-name", sampleElementOptions.simpleName);
		    sampleElementWrapper.append(sampleElement.element);
		    return sampleElementWrapper;		    
		},

		renderSampleElements = function(sampleElements){
		    var index,
                sampleElement,
                sampleElementList,
                sampleElementWrapper;
		      
            sampleElementList = $(Selectors.sampleInputList);

            for(index in sampleElements){
                sampleElement = sampleElements[index];
                sampleElementWrapper = createSampleElement(sampleElement);
                sampleElementList.append(sampleElementWrapper);                
            };
		    
		},
				
		setSampleInputsDescriptionButtonEvents = function() {
			var buttons = $(Selectors.inputDescriptionButtonSelector);
			$(buttons).each(function() {
				$(this).click(function() {
					var sampleBox = $(this).next();
					if (sampleBox.css('display') === 'none') {
						sampleBox.fadeIn('slow');
					} else {
						sampleBox.fadeOut('fast');
					}

				});
			});
		},
		
        createFormEditorProgressBar = function(){
            var leftPanel = $(Selectors.formEditor).parent(),
            progressBarWrapper = $('<div/>'),
            position = leftPanel.position(),
            progressBar = $('<div/>');
            
            progressBarWrapper.prop("id", "progressBarWrapper");
            progressBarWrapper.css("position", "absolute");         
                        
            progressBarWrapper.width(leftPanel.width());
            progressBarWrapper.height(leftPanel.height());
            progressBarWrapper.css("top", position.top + "px");
            progressBarWrapper.css("left", position.left + "px");
            progressBarWrapper.addClass("progressBarWrapper");
                        
            progressBar.addClass('generatingInProgress');
            progressBarWrapper.append(progressBar);
            
            leftPanel.append(progressBarWrapper);
        },
        
        removeFormEditorProgressBar = function(){
            $("#progressBarWrapper").remove();
        },

        toggleFormEditorProgressBar = function(state){
            if(state){
                createFormEditorProgressBar();
            }else{
                removeFormEditorProgressBar();
            }
        },
        
        generateInputName = function(inputElementType){
            var retValue;            
            if(inputElements[inputElementType] === null){
                retValue = inputElementType;
            }else{
                // TODO generate name
                retValue = "name";  
            }
            return retValue;
        },
        
        sendInputElement = function(inputElementProperties, successCallback){
            // FIXME hardcoded url          
            $.ajax({
              type: 'POST',
              url: '/wp-admin/admin-ajax.php?action=Katana_generateInput',
              dataType : 'json',
              data : {
                inputElementProperties : inputElementProperties
              },
              success: successCallback
            });         
        },
        
        generateInputWindowInput = function(attributePropertyInputs, inputId, attributes){
            var type = attributes.type,
            input,
            label = $('<label/>', {
                text: attributes.label
            }),
            wrapper = $('<div/>',{});
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
                    if(attributes.value === 1){
                        input.prop('checked', true);    
                    }
                break;              
            }           
            wrapper.addClass('inputPropertyWrapper');
            wrapper.append(label);
            wrapper.append(input);
            attributePropertyInputs[attributes.position] = wrapper;
        },
        
        createHiddenInputField = function(name, value){
            var input = $('<input/>');
            input.prop('name', name);
            input.prop('type', 'hidden');
            input.val(value);
            return input;
        },
        
        generateInputWindowForm = function(inputName, wrapper, properties){
            var propertyForm = $('<form/>',{}),
                attributePropertyInputs = [],
                propertyIndex,
                property,
                propertyAttributes,
                inputId,
                oldNameInput;
            
            for(propertyIndex in properties){
                if(properties.hasOwnProperty(propertyIndex)){                
                    property = propertyIndex;
                    propertyAttributes = InputEditorElements[propertyIndex];
                    
                    if(propertyAttributes !== undefined){
                        propertyAttributes.value = properties[propertyIndex];
                        inputId = inputName + "_" + propertyIndex;
                        generateInputWindowInput(attributePropertyInputs, inputId, propertyAttributes);                                     
                    }   
                }
            }
            
            $.each(attributePropertyInputs, function(index, propertyInput){
                propertyForm.append(propertyInput);
            });
            
            oldNameInput = createHiddenInputField('old-name', inputName);
            propertyForm.append(oldNameInput);
            wrapper.append(propertyForm);           
        },
        
        attachNewInput = function(newInput, result, inputElementProperties){
            newInput.html(result.content);
            newInput.append('<div class="options"></div>');
            
            var optionsButton = newInput.find('div.options'),
            
            itemPosition = newInput.index(),
            inputName = inputElementProperties.name,
            
            inputWindowWrapperId = "#window_" + inputName,                  
            inputWindowWrapper = $('<div/>', {
                id : inputWindowWrapperId
            });            
                        
            inputElements.add(inputName, inputElementProperties);
            
            inputWindowWrapper.addClass("inputWindowEditor");
            generateInputWindowForm(inputName, inputWindowWrapper, result.properties);  
            bindInputEditorHandler(optionsButton, inputElementProperties.name, inputWindowWrapper);
        },
        
        
        propertyWindowSaveEvent = function(inputOldName, result, propertyWindow){
            if(result.valid){
                var generatedInput = $('input[name='+inputOldName+'], button[name='+inputOldName+']'),
                inputWrapper = generatedInput.closest('li.inputWrapper'),
                inputName = result.properties.name;             
                
                attachNewInput(inputWrapper, result, result.properties);
                inputElements[inputOldName] = null;
                
                                
                inputElements[inputName] = result.properties;
                propertyWindow.dialog('destroy');
            }else{
                propertyWindowErrorEvent(result, inputOldName);
            }
        },
                
        changeInputProperties = function(propertyWindow){
            
            var form = $(propertyWindow).find('form'),
            inputOldName = $(form).find('input[name=old-name]'),            
            oldName = inputOldName.val(),           
            inputs = $(form).find('input, select, textarea').not('input[name=old-name]'),           
            inputProperties = $.extend(true, {}, inputElements[oldName]);           
            
            $.each(inputs, function(index, input){
                
                var inputName = $(input).prop('name'),
                inputNamePrefix = oldName + '_',
                propertyName = inputName.replace(inputNamePrefix, ''),
                inputValue = $(input).val();
                
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
                toggleFormEditorProgressBar(false);             
            });         

        },
        
        
        bindInputEditorHandler = function(optionsButton, inputName, inputWindowWrapper){
            optionsButton.click(function(){               
               var editorDialog = $(inputWindowWrapper).dialog({
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
                            // only hide
                            $(this).dialog("destroy");
                        },
                        "Save": function(){                         
                            changeInputProperties($(this));
                        }                        
                    }
                });
                console.log(editorDialog.dialog.buttons);
            });
        },
        
        generateInput = function(inputElement, newInput){           
            var inputElementType = inputElement.attr("input-type"),
            inputElementSimpleName = inputElement.attr("simple-name"),
            inputName = generateInputName(inputElementType),
            // TODO template handling
            inputElementProperties = {
                name : inputElementSimpleName,
                className : inputElementType,
                template : 'default',
                label : inputElementSimpleName
            };
            toggleFormEditorProgressBar(true);
            sendInputElement(inputElementProperties, function(result){
                attachNewInput(newInput, result, result.properties);
                toggleFormEditorProgressBar(false);
            });
        },

		setFormpageToSortable = function(inputLists){
			$(inputLists).sortable({
				connectWith : "ul",
				receive : function(event, ui){
					$(Selectors.activeFormPage).removeClass('sortingInProgress');					
					$(ui.item).after('<li class="inputWrapper"></li>');					
					var newInput = $(ui.item).next(),
					generatorInput = ui.item;
					
					generateInput(generatorInput, newInput);
					$(Selectors.sampleInputList).sortable("cancel");
				},
				over : function(event, ui){					
					$(Selectors.activeFormPage).addClass('sortingInProgress');
				},
				deactivate : function(event, ui){
					$(Selectors.activeFormPage).removeClass('sortingInProgress');
				},
				// TODO fixme (remove via drag out)
				remove : function(event, ui){
					var type = $(ui.item).attr("input-type");
					if(type === undefined){
					    /*global confirm */
						if(confirm("Delete input item?")){
							$(ui.item).remove();	
						}
						
					}
				}				
			});			
		},
		
        bindFormAddEvent = function(){
			$(Selectors.sampleInputList).sortable({
				connectWith : "ul",
				receive : function(event, ui){
					$(ui.item).remove();
				}
			});
			// TODO create sample window instead of embed that into the button
			$(Selectors.sampleInputList).disableSelection();
			
			setFormpageToSortable($(Selectors.formPage));			
		},

		addErrorMessageToEditorField = function(inputName, field, errorMessage){
		    var inputFieldParent = $("#" + inputName + "_" + field).parent(),
                errorMessageWrapper = $('<div/>', {});            
            
            inputFieldParent.addClass("input-error");
            errorMessageWrapper.addClass("input-error-notice");
            errorMessageWrapper.html(errorMessage);    
            inputFieldParent.append(errorMessageWrapper); 
		},
		
		propertyWindowErrorEvent = function(result, inputName){
		    var errors = result.errors,
            field,
            errorMessage;   
		    
		    for(field in errors){
		        if(errors.hasOwnProperty(field)){
		          errorMessage = errors[field];
		          addErrorMessageToEditorField(inputName, field, errorMessage);
		         } 
		    }	
		},
		
		unbindInputEditorHandler = function(){
			// TODO when input delete
			// TODO delete inputwindowwrapper
		},
		
		setPagerButtonsClickEvent = function(){
			$(Selectors.formPager).click(
				function(event){
					
					var buttonId = event.target.id,
                        button = $(this),
                        currentPage,
                        targetPage;					 
					
					if(!button.hasClass('activePager')){
						return;
					}
					currentPage = pages.getCurrentPage();
					
					if(buttonId === 'prevPage'){						
						targetPage = currentPage-1;	
					}
					if(buttonId === 'nextPage'){
						targetPage = currentPage + 1;
					}
					scrollFormPages(currentPage, targetPage);

				}
			);			
		},
		
		addNewPageButtonEvent = function(){
			$(Selectors.newPageButton).click(function(){
				addNewPage();				
			});
		},
		
		addNewPage = function(){
            var newFormPage,
                newPageId,
                activePageId;
                                
			pages.add();					
			newFormPage = createNewFormPage(pages.getPagesNum());
			$(Selectors.formInputElements).append(newFormPage);
			setFormpageToSortable(newFormPage);
			increaseFormEditorSize(newFormPage.width());
			newPageId = pages.getPagesNum();
						
			activePageId = getActivePageId();						
			scrollFormPages(activePageId, newPageId);						
		},
				
		increaseFormEditorSize = function(size){
			var originalWidth = $(Selectors.formEditor).width(); 
			$(Selectors.formEditor).width(originalWidth + size);
		},
		
		getActivePageId = function(){
			var activePage = $(Selectors.activeFormPage);
			return activePage.attr("page-id");
		},
		
		createNewFormPage = function(pageId){
			var formPage = $('<ul/>');
			formPage.addClass('formPage droptrue');
			formPage.attr("page-id", pageId);	
			return formPage;
		},
								
		scrollFormPages = function(currentFormPageId, targetFormPageId){
			if(currentFormPageId > targetFormPageId){
				scrollFormPagesLeft(currentFormPageId, targetFormPageId);	
			}
			if(currentFormPageId < targetFormPageId){				
				scrollFormPagesRight(currentFormPageId, targetFormPageId);
			}			
			setFormPageToActive(targetFormPageId);			
			pages.setCurrentPage(targetFormPageId);
			displayFormId();
			changePagerButtonsActiveStatus();
		},

		scrollFormPagesLeft = function(from, to){
			var delta = (from - to) * 400,
			actualLeftPosition = getFormEditorLeftPosition(),
			distance = delta + actualLeftPosition;
			
			$(Selectors.formEditor).animate({
					left: distance + "px"
				},
				"slow"
			);
		},

		scrollFormPagesRight = function(from, to){
			var delta = (from - to) * 400,
			actualLeftPosition = getFormEditorLeftPosition(),
			distance = delta + actualLeftPosition;
			
			$(Selectors.formEditor).animate({
					left: distance + "px"
				},
				"slow"
			);
		},
						
		getFormEditorLeftPosition = function(){
			var position = $(Selectors.formEditor).position();
			return position.left;
		},
		
		getFormPage = function(pageId){
			return $(Selectors.formEditor + ' ' + Selectors.formInputElements + ' ul[page-id="'+pageId+'"]');
		},
		
		changePagerButtonsActiveStatus = function(){
			if(pages.getPagesNum < 2){
				$(Selectors.formPager).removeClass('activePager');
				return;
			}
			if(pages.getCurrentPage() > 1){
				$(Selectors.prevPage).addClass('activePager');				
			}else{
				$(Selectors.prevPage).removeClass('activePager');
			}
			if(pages.getCurrentPage() < pages.getPagesNum()){
				$(Selectors.nextPage).addClass('activePager');
			}else{
				$(Selectors.nextPage).removeClass('activePager');
			}
		},
		
		setFormPageToActive = function(formPageId){
			var activePage = $(Selectors.activeFormPage);
			activePage.removeClass("active");
			getFormPage(formPageId).addClass("active");
		},
		
		displayFormId = function(){
			$(Selectors.currentPage).html(pages.getCurrentPage());
		};

        this.init = function() {
            getSampleElements(function(result){
                renderSampleElements(result);
                setSampleInputsDescriptionButtonEvents();
                bindFormAddEvent();
                setPagerButtonsClickEvent();
                addNewPageButtonEvent();                
            });
        };		
		
	},
	formEditor = new FormEditor();
	formEditor.init();
}(jQuery));