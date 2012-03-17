<?php
/**
 * Placeholder helper.
 *
 * @author     Patrick van Marsbergen
 * @copyright  (c) 2012 Mimbee All Rights Reserved
 * @license    http://mimbee.nl/bsd.html
*/
class Placeholder
{

	/**
	 * The class defaults
	 **/
	protected $_text             = NULL;
	protected $_width            = 150;
	protected $_height           = NULL;
	protected $_background_color = 'ff9f24';
	protected $_text_color       = 'ffffff';

	/**
	 * Define the width of the placeholder
	 *
	 * @param int $pixels The width in pixels
	 * @return object Placeholder
	 **/
	public function width ($pixels)
	{
		if(is_numeric($pixels) && $pixels > 0)
			$this->_width = $pixels;

		return $this;
	}

	/**
	 * Define the height of the placeholder
	 *
	 * @param int $pixels The height in pixels
	 * @return object Placeholder
	 **/
	public function height ($pixels)
	{
		if(is_numeric($pixels) && $pixels > 0)
			$this->_height = $pixels;

		return $this;
	}

	/**
	 * Define the text of the placeholder
	 * If you define the message as NULL, you'll see the width and height of the placeholder.
	 * A string or empty string will overwrite the width and heigth
	 *
	 * @param string $message The message you see in the placeholder.
	 * @param string $color Define the color of the text in the placeholder in HEX
	 * @return object Placeholder
	 **/
	public function text ($message, $color = NULL)
	{
		if(!empty($message) && is_string($message))
			$this->_text = $message;

		if(!empty($color))
			$this->text_color($color);


		return $this;
	}

	/**
	 * Define the color of the text in the placeholder in HEX
	 *
	 * @param string $color The color of the text in HEX
	 * @return object Placeholder
	 **/
	public function text_color ($color)
	{
		if(!empty($color) && preg_match('/[a-f0-9]{6}/i', $color) > 0)
			$this->_text_color = $color;

		return $this;
	}

	/**
	 * Define the background color of the placeholder in HEX
	 *
	 * @param string $color The color of the placeholder background
	 * @return object Placeholder
	 **/
	public function background ($color)
	{
		if(!empty($color) && preg_match('/[a-f0-9]{6}/i', $color) > 0)
			$this->_background_color = $color;

		return $this;
	}

	/**
	 * Render and return the image in Base64 image only or include an optimized image html-tag
	 *
	 * @param bool $img_tag TRUE to include the html image-tag
	 * @return string The Base64 image or html image tag with the base64 image attached
	 **/
	public function render ($img_tag = FALSE)
	{
		if(empty($this->_height))
			$this->_height = $this->_width;

		if($this->_text === NULL)
			$this->_text = $this->_width . ' x ' . $this->_height;

		$text_hex = str_split($this->_text_color, 2);
		$bg_hex   = str_split($this->_background_color, 2);

		$image = imagecreatetruecolor($this->_width, $this->_height);
		$text_color = imagecolorallocate($image, '0x' . $text_hex[0], '0x' . $text_hex[1], '0x' . $text_hex[2]);
		$bg_color = imagecolorallocate($image, '0x' . $bg_hex[0], '0x' . $bg_hex[1], '0x' . $bg_hex[2]);
		imagefilledrectangle($image, 0, 0, $this->_width, $this->_height, $bg_color);

		$text_width = imagefontwidth(5) * strlen($this->_text); 
		$center = ceil($this->_width / 2); 
		$x = $center - (ceil($text_width/2)); 

		$center = ceil($this->_height / 2); 
		$y = $center - 6;

		imagestring($image, 5, $x, $y, $this->_text, $text_color);

		ob_start();
		imagepng($image);
		$contents = ob_get_contents();
		ob_end_clean();

		imagedestroy($image);

		$html = 'data:image/png;base64,'.base64_encode($contents);

		if($img_tag === TRUE)
			$html = '<img src="'.$html.'" width="'.$this->_width.'" height="'.$this->_height.'" alt="'.$this->_text.'" title="'.$this->_text.'" />';
		return $html;
	}

	/**
	 * Static function to render and return the image in Base64 image directly
	 *
	 * @param int $width The width in pixels
	 * @param int $height The height in pixels
	 * @param string $background_color The color of the placeholder background
	 * @param string $text_color The color of the text in HEX
	 * @param string $text The message you see in the placeholder.
	 * @return string The Base64 image
	 **/
	public static function image ($width = NULL, $height = NULL, $background_color = NULL, $text_color = NULL, $text = NULL)
	{
		$factory = new self();
		return $factory->width($width)
				->height($height)
				->background($background_color)
				->text($text, $text_color)
				->render();
	}

	/**
	 * Static function to render and return the html image tag with the Base64 image attached directly
	 *
	 * @param int $width The width in pixels
	 * @param int $height The height in pixels
	 * @param string $background_color The color of the placeholder background
	 * @param string $text_color The color of the text in HEX
	 * @param string $text The message you see in the placeholder.
	 * @return string The Base64 image in a html image tag
	 **/
	public static function imagetag ($width = NULL, $height = NULL, $background_color = NULL, $text_color = NULL, $text = NULL)
	{
		$factory = new self();
		return $factory->width($width)
				->height($height)
				->background($background_color)
				->text($text, $text_color)
				->render(TRUE);
	}

}