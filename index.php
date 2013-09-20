<?php
	require 'vendor/autoload.php';


	class WebServicesApp {
	    private $app;

	    public function __construct() {
	    	$this->app = new \Slim\Slim(array(
		    	'debug' => true
		  	));

	     $this->app->get('/',      array($this, 'showHome'));
		 $this->app->get('/artist/:name', array($this, 'searchArtist'));

		 $this->app->run();
	 	}

	 	public function showHome() {
	 		echo "Welcome to WebServicesApp";
	 	}

	 	public function searchArtist($name) {
	 		$wsURL = "http://ws.spotify.com/search/1/artist?q=";

	 		$wsURL .= urlencode("artist:$name");

	 		echo "Searching for this artist: $name";
	 		echo $wsURL;

	 		$response = Httpful\Request::get($wsURL)
	 			->expectsXml()
	 			->send();

	 		$this->app->render('artists.html', array('artists' => $response->body));
	 	}
	}
	new WebServicesApp();