
var $pick = jQuery.noConflict();

$pick(document).ready(function() {
	$pick('#colorpickerField1').ColorPicker({
		onSubmit: function(hsb, hex, rgb, el) {
			$pick(el).val('#'+hex);
			$pick(el).ColorPickerHide();
		},
		onBeforeShow: function () {
			$pick(this).ColorPickerSetColor(this.value);

		},
		onChange: function (hsb, hex, rgb) {
			$pick('#colorpickerField1').css('backgroundColor', '#' + hex);
		}
	}).bind('keyup', function(){
		$pick(this).ColorPickerSetColor(this.value);
	});

	$pick('#colorpickerField2').ColorPicker({
		onSubmit: function(hsb, hex, rgb, el) {
				$pick(el).val('#'+hex);
				$pick(el).ColorPickerHide();
			},
		onBeforeShow: function () {
				$pick(this).ColorPickerSetColor(this.value);

			},
		onChange: function (hsb, hex, rgb) {
				$pick('#colorpickerField2').css('backgroundColor', '#' + hex);
			}
		}).bind('keyup', function(){
			$pick(this).ColorPickerSetColor(this.value);

		});

	$pick('#colorpickerField3').ColorPicker({
		onSubmit: function(hsb, hex, rgb, el) {
				$pick(el).val('#'+hex);
				$pick(el).ColorPickerHide();
			},
		onBeforeShow: function () {
				$pick(this).ColorPickerSetColor(this.value);

			},
		onChange: function (hsb, hex, rgb) {
				$pick('#colorpickerField3').css('backgroundColor', '#' + hex);
			}
		}).bind('keyup', function(){
			$pick(this).ColorPickerSetColor(this.value);

		});
	
	$pick('#colorpickerField4').ColorPicker({
		onSubmit: function(hsb, hex, rgb, el) {
				$pick(el).val('#'+hex);
				$pick(el).ColorPickerHide();
			},
		onBeforeShow: function () {
				$pick(this).ColorPickerSetColor(this.value);

			},
		onChange: function (hsb, hex, rgb) {
				$pick('#colorpickerField4').css('backgroundColor', '#' + hex);
			}
		}).bind('keyup', function(){
			$pick(this).ColorPickerSetColor(this.value);

		});
	
	})(jQuery);