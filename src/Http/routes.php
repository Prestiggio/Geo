<?php
Route::group(["middleware" => ["bot", "botex"]], function(){
	Route::post("ry/geo/bot/position", "BotController@postPosition");
});
Route::get("ry/geo/adminview", function(){
	return view("rygeo::admin");
});
Route::get("ry/geo/{country}/villes", "PublicController@villes");
Route::get("ry/geo/countries", "PublicController@getCountries");
Route::get("ry/geo/ngmodel", "PublicController@getNgmodel");
Route::get("ry/geo/ngsearch", "PublicController@getNgsearch");
?>