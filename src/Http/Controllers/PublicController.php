<?php 
namespace Ry\Geo\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ry\Geo\Models\Country;
use Ry\Geo\Models\Ville;

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
}
?>