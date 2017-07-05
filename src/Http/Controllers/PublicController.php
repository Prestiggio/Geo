<?php 
namespace Ry\Geo\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ry\Geo\Models\Country;
use Ry\Geo\Models\Ville;
use Ry\Geo\Models\Adresse;

class PublicController extends Controller
{
	public function villes($country) {
		return $country->villes;
	}
	
	public function getCountries() {
		return Country::all();
	}
	
	public function getNgmodel() {
		return view("rygeo::ngmodel");
	}
	
	public function getNgsearch() {
		return view("rygeo::ngsearch");
	}
	
	public function generate($ar) {
		$adresse = Adresse::where("raw", "LIKE", $ar["adresse"]["raw"])->first();
		
		if(!$adresse) {
			$country = Country::where ( "nom", "LIKE", $ar ["adresse"] ["ville"] ["country"] ["nom"] )->first ();
			if (! $country) {
				$country = new Country ();
				$country->nom = $ar ["adresse"] ["ville"] ["country"] ["nom"];
				$country->save ();
			}
			
			$ville = $country->villes ()->where ( "nom", "LIKE", $ar ["adresse"] ["ville"] ["nom"] )->first ();
			if (! $ville) {
				$ville = $country->villes ()->create ( [
						"nom" => $ar ["adresse"] ["ville"] ["nom"],
						"cp" => isset($ar ["adresse"] ["ville"] ["cp"]) ? $ar ["adresse"] ["ville"] ["cp"] : ""
				] );
			}
			
			$adresse = new Adresse ();
			$adresse->ville_id = $ville->id;
		}
		
		$adresse->raw = $ar ["adresse"] ["raw"];
		$adresse->lat = isset($ar["adresse"]["lat"]) ? $ar["adresse"]["lat"] : "-18.913396429147";
		$adresse->lng = isset($ar["adresse"]["lng"]) ? $ar["adresse"]["lng"] : "47.521104812622";
		
		$adresse->save ();
		
		return $adresse;
	}
}
?>