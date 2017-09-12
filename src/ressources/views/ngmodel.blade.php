<ng-form name="frm_geo">
	<md-input-container>
		<label>@lang("rygeo::overall.address")</label>
		<input type="text" name="adresse_raw" ng-model="data.raw" required/>
		<div ng-messages="frm_geo.adresse_raw.$error">
	 		<div ng-message="required">@lang("rygeo::overall.address_required")</div>
	 	</div>
	</md-input-container>
	<md-input-container>
		<label>@lang("rygeo::overall.city")</label>
		<input type="text" name="adresse_ville_nom" ng-model="data.ville.nom" required/>
		<div ng-messages="frm_geo.adresse_ville_nom.$error">
	 		<div ng-message="required">@lang("rygeo::overall.city_required")</div>
	 	</div>
	</md-input-container>
	<md-input-container>
		<label>@lang("rygeo::overall.country")</label>
		<input type="text" name="adresse_ville_country_nom" ng-model="data.ville.country.nom" required/>
		<div ng-messages="frm_geo.adresse_ville_country_nom.$error">
	 		<div ng-message="required">@lang("rygeo::overall.country_required")</div>
	 	</div>
	</md-input-container>
</ng-form>
<rymap ng-model="data" style="min-height:600px;"></rymap>
