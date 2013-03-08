<h3><?php echo LanguageUtils::translate("Form editor") ?></h3>
<div id="formEditorBody">
	<div id="formEditor">
	
	</div>
	<div id="formEditorToolbox">
		<ul>
			<?php $sampleInputsIterator = $sampleInputs->getIterator(); ?>			
			<?php while($sampleInputsIterator->valid()){?>
				<?php $input = $sampleInputsIterator->current(); ?>				
			<li>
				<?php $input->render() ?> 
			</li>
			<?php $sampleInputsIterator->next(); ?>
			<?php } ?>
		</ul>	
	</div>	
</div>	