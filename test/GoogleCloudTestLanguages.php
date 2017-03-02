<?php

class GoogleCloudTestLanguages extends PHPUnit_Framework_TestCase
{

	protected function getApiKey(){

		$credentials=__DIR__.'/credentials.json';
		if(!file_exists($credentials)){
			throw new Exception('Put your Google Cloud Server Access Token in: '.$credentials.' ie: {"access_token":"XXXXXXX"}');
		}
		return json_decode(file_get_contents($credentials))->key;
	}


	public function testEnglishToSpanish(){

		require dirname(__DIR__).'/vendor/autoload.php';

		$this->assertEquals('Hola Mundo',(new nickolanack\GoogleTranslate(

		            array(
		                'from'  => 'en',
		                'to' => 'es',
		                'key'=>$this->getApiKey()
		            )
		        ))->translate('Hello World'));


	}


	public function testEnglishToFrench(){

		require dirname(__DIR__).'/vendor/autoload.php';

		$this->assertEquals('Bonjour le monde',(new nickolanack\GoogleTranslate(
		            array(
		                'key'=>$this->getApiKey()
		            )
		        ))->translate('Hello World', 'fr', 'en'));


	}

	public function testSpanishToEnglish(){

		require dirname(__DIR__).'/vendor/autoload.php';

		$this->assertEquals('Hello World',(new nickolanack\GoogleTranslate(

		            array(
		                'from'  => 'es',
		                'to' => 'en',
		                'key'=>$this->getApiKey()
		            )
		        ))->translate('Hola Mundo'));


	}




}