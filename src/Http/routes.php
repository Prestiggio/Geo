<?php
Route::group(["middleware" => ["bot", "botex"]], function(){
	Route::controller("ry/geo/bot", "BotController");
});
Route::get("ry/geo/{country}/villes", "PublicController@villes");
Route::controller("ry/geo", "PublicController");
?>