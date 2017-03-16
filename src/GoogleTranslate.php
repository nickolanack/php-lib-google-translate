<?php

namespace nickolanack;

class GoogleTranslate{


	protected $apiKey;
	protected $sourceLang='en';
	protected $destLang;
	protected $apiUrl='https://translation.googleapis.com/language/translate/v2';

	public function __construct($config){
		$this->apiKey=$config['key'];

		if(!key_exists('key', $config)){
			throw new \Exception('Requires API key from google developer console');
		}

		if(key_exists('from', $config)){
			$this->sourceLang=$config['from'];
		}
		if(key_exists('to', $config)){
			$this->destLang=$config['to'];
		}

	}

	public function translate($text, $to=null, $from=null){


		if(empty($to)){
			$to=$this->destLang;
		}

		if(empty($to)){
			throw new \Exception('Pass output language code as 2nd argument, or initialize with default `to` parameter in constructor config');
		}

		if(empty($from)){
			$from=$this->sourceLang;
		}

		if(empty($from)){
			throw new \Exception('Pass input language code as 3rd argument, or initialize with default `to` parameter in constructor config');
		}

		$text=trim($text);
		
		
		$folder=__DIR__.'/assets/'.$from.'_'.$to;
		if(!file_exists($folder)){
			mkdir($folder);
		}

		$file=$folder.'/'.md5($text).'.mp3';

		if(file_exists($file)){
			return file_get_contents($file);
		}


		$translation=$this->requestTranslation($text, $to, $from);

		file_put_contents($file, $translation);

		return $translation;
	}

	protected function requestTranslation($text, $to, $from){

		$data_string = json_encode(array(
		  'q'=>$text,
		  'source'=>$from,
		  'target'=>$to,
		  'format'=>'text'
		));                  
                                                   
		                                                                                                                     
		$ch = curl_init($this->apiUrl.'?key='.$this->apiKey);                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(     
		//	'Authorization: Bearer ' . $this->accessToken,                                                                     
		    'Content-Type: application/json',                                                                                
		    'Content-Length: ' . strlen($data_string))                                                                       
		);                             
		                                                                             
		                                                                                                                     
		$result = curl_exec($ch);
		//echo $result."\n";
		//
		if(empty($result)){
			throw new \Exception('No Response');
		}
		$response=json_decode($result);

		if(empty($response)){
			throw new \Exception('Unexpected Response: '.$result);
		}

		if(key_exists('error', $response)){
			throw new \Exception('Google Api Error: '.$response->error->message);
		}


		if(!key_exists('data', $response)){
			throw new \Exception('Expected `data` in json response: '.$result);
		}

		return $response->data->translations[0]->translatedText;


	}

}
