# lib-php-google-translate
Helper library to translate text using google cloud translate and cache responses


Usage
```

require __DIR__.'/vendor/autoload.php';

echo (new nickolanack\GoogleTranslate(
        array(
            'from'  => 'en',
            'to' => 'es',
            'key'=>'AIz-XXXX-XXXX...'
        )
    ))->translate('Hello World');

//should print: 'Hola Mundo'




echo (new nickolanack\GoogleTranslate(
	    array(
	        'key'=>'AIz-XXXX-XXXX...'
	    )
	))->translate('Hello World', 'fr', 'en');

//should print: 'Bonjour le monde'


```