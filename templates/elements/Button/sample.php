<?php 
use classes\utils\LanguageUtils;
?>
<div class="sampleInputElement">
	<div class="title">
		<?php echo LanguageUtils::translate("Button") ?>
	</div>	
	<div class="descriptionBoxButton"></div>
	<div class="descriptionBox">
		<div class="inputDescription">
			<?php echo LanguageUtils::translate("Button description") ?>
		</div>
		<div class="inputElement">
			<button id="<?php echo $input->getId()?>" value="<?php echo $input->getValue()?>" title="<?php echo $input->getLabel() ?>"><?php echo $input->getLabel() ?></button>
		</div>
	</div>
</div>			