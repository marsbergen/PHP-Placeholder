# PHP Placeholder

Generates image placeholders with PHP and their GD library for creating websites and mockups without using real images but with a perfect fit size 

## Getting started

Use the Placeholder class as Helper in your project or use it as a seperated file/class. 
It's also possible to it only with the create_placeholder.php command-line tool to generate placeholder as a Base64 image 

## How to use

This will return the image with image tag 
```
$placeholder = new Placeholder();
echo $placeholder->width(150)
		->height(100)
		->background('FF0000')
		->text('Custom text', 'FFFFFF')
		->render(TRUE);
```
The code below is the short static version
```echo Placeholder::imagetag(150, 100, 'FF0000', 'FFFFFF', 'Custom text');```

If you don't want the image tag, but only the Base64 image. Remove the TRUE in the render() function or replace it with FALSE. 
And in the static function use image() in stead of imagetag()

## Command line example

Use the command-line tool like this for the default values (150x150): 

```php create_placeholder.php``` 

You can customize your result with the following parameters: 

```php create_placeholder.php 150 100 FF0000 FFFFFF "Custom text"``` 

Then your placeholder has: 
Width: 150 
Height: 100 
Background color: Red (#FF0000)
Text color: White (#FFFFFF)
And the text: Custom text

## Copyright

See [LICENSE](http://mimbee.nl/bsd.html) for further details.