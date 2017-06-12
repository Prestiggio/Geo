(function(window, angular, $, appApp, undefined){
	
	angular.module("rygeo", ["ngApp"])
	.service('rygoogle', ["$q", "$window", "$appSetup", function($q, $window, $app){
		var initDeferred = $q.defer();

		$window.initMap = function(){
			initDeferred.resolve();
		};

		$.getScript("//maps.googleapis.com/maps/api/js?key="+$app.data.conf.google.key+"&callback=initMap");
		
		return initDeferred.promise;
	}]).directive("rymap", ["rygoogle", function(rygoogle){
		
		return {
			restrict : 'E',
			require : 'ngModel',
			link : function(scope, elem, attr, ngModel){
				rygoogle.then(function(){
					var uluru = {lat: -18.9105106, lng: 47.5177239};
			        var map = new google.maps.Map(elem[0], {
			          zoom: 15,
			          center: uluru,
			          mapTypeId: google.maps.MapTypeId.SATELLITE
			        });
			        var marker = new google.maps.Marker({
			          position: uluru,
			          map: map,
			          draggable : true
			        });
			        map.addListener('click', function(e){
			        	marker.setPosition(e.latLng);
				    });
			        marker.addListener('position_changed', function(){
			        	var v = ngModel.$modelValue;
			        	var latlng = marker.getPosition();
			        	ngModel.$modelValue.lat = latlng.lat();
			        	ngModel.$modelValue.lng = latlng.lng();
			        	var geocoder = new google.maps.Geocoder();
					    geocoder.geocode({
							location : latlng
				        }, function(results, status){
					        if(status==google.maps.GeocoderStatus.OK) {
					        	ngModel.$modelValue.geocodes = results;
						    }
				        	ngModel.$setViewValue(ngModel.$modelValue);
					    });
				    });
			        scope.$watch(attr.ngModel, function(){
				        if(ngModel.$modelValue.lat && ngModel.$modelValue.lng) {
				        	uluru = {lat: parseFloat(ngModel.$modelValue.lat), lng: parseFloat(ngModel.$modelValue.lng)};
							marker.setPosition(uluru);
							map.setCenter(uluru);
					    }						
					});
				});
			}
		}
		
	}]);
	
})(window, window.angular, window.jQuery, window.appApp);

window.rygeo = {version:{full: "1.0.0"}};