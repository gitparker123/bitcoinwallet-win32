Cesium.Ion.defaultAccessToken = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiJkYzFhN2I2Yy1jZWRmLTQ1ZGMtYTY2Ni01YzI3YzMzYTc4N2YiLCJpZCI6NDgyMSwic2NvcGVzIjpbImFzciIsImdjIl0sImlhdCI6MTU0MTY5OTY5MX0.B-sZryd9xSPBYJYB3aO142zgqMYg9J8B-nt4uthdvc4';
var viewer = new Cesium.Viewer('map', {
    shouldAnimate : true
});

var options = {
    camera : viewer.scene.camera,
    canvas : viewer.scene.canvas
};

var broadcasterDataSource = new Cesium.KmlDataSource();
broadcasterDataSource.load('https://cesiumjs.org/Cesium/Apps/SampleData/kml/facilities/facilities.kml', options);
var satelliteDataSource   = new Cesium.CzmlDataSource();
satelliteDataSource.load('https://cesiumjs.org/Cesium/Apps/SampleData/simple.czml');

var loadLayer = function(layer,state) {
    var dataSrc;
    switch(layer){
        case "layer_broadcaster":
            dataSrc = broadcasterDataSource;
            viewer.camera.flyHome(0);
            break;
        case "layer_satellite":
            dataSrc = satelliteDataSource;
            break;
        case "layer_fiber":
            break;
        case "layer_cloud":
            break;

    }
    if (state) {
        // Show if not shown.
        if (!viewer.dataSources.contains(dataSrc)) {
            viewer.dataSources.add(dataSrc);
        }
    } else {
        // Hide if currently shown.
        if (viewer.dataSources.contains(dataSrc)) {
            viewer.dataSources.remove(dataSrc);
        }
    }
}

var loadAll = function() {
//    loadLayer("layer_broadcaster",1);
//    loadLayer("layer_fiber",1);
//    loadLayer("layer_satellite",1);
//    loadLayer("layer_cloud",1);
    viewer.camera.flyHome(0);
    viewer.dataSources.add(broadcasterDataSource);
    viewer.dataSources.add(satelliteDataSource);
}

var clearAll = function() {
    viewer.dataSources.removeAll(false);
}

var searchPanelFixed = function(){
	var h = jQuery(window).height();
	if(h < jQuery(".search-panel").height()) {
		jQuery(".search-toggle, .search-panel").addClass('absolute');
	} else {
		jQuery(".search-toggle, .search-panel").removeClass('absolute');
	}
}
var sendRequest = function(url,data) {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		url:url ,
		type:'GET',
		data:data,
		dataType: "json",
		success: callAfter
	});
	return true;
}

var callAfter = function(data){
	var ctrl 	 = data.ctrl;
    var result 	 = data.result;
    var isOrigin = data.isOrigin;
	switch( ctrl ) {
        case "city_list":
            if(result == "success"){
                if(isOrigin == "from"){
                    $("#from_city").selectmenu('enable');
                    $("#from_city").html(data.cityList);
                }else{
                    $("#to_city").selectmenu('enable');
                    $("#to_city").html(data.cityList);
                }
            }else{
                alert('Database Error!');
            }
			break;
        case "broadcaster_list":
            if(result == "success"){
                if(isOrigin == "from"){
                    $("#from_broadcaster").selectmenu('enable');
                    $("#from_broadcaster").html(data.broadcasterList);
                }else{
                    $("#to_broadcaster").selectmenu('enable');
                    $("#to_broadcaster").html(data.broadcasterList);
                }
            }else{
                alert('Database Error!');
            }
			break;

	}
}

jQuery('.search-toggle').click(function(e){
    if(jQuery(this).is('.close')){
        jQuery('.search-panel, .search-toggle').stop(true, true).animate({'right': '-300px'}, 300);
        setTimeout(function(){
            jQuery('.search-toggle').toggleClass('close');
        }, 500)
    } else {
        jQuery('.search-panel, .search-toggle').stop(true, true).animate({'right': 0}, 300);
        jQuery('.search-toggle').toggleClass('close');
    }
    e.stopPropagation();
});
jQuery(window).resize(function(){
	searchPanelFixed();
});

jQuery.noConflict();
$( function() {   
    loadAll();   

    $(".select").each(function(){
        $(this).selectmenu();
        var id = $(this).attr('id');
        if(id == "from_country" || id == "to_country"){
            $(this).selectmenu('enable');
        }else{
            $(this).selectmenu('disable');
        }
    });
    
    $("#from_country, #from_city, #to_country, #to_city").on("selectmenuchange",function(){ 
        var url = 'city';
        var origin = "from";
        var ctrl = "city_list";
        switch($(this).attr('id')){
            case 'from_country':
                break;
            case 'from_city':
                url = "broadcaster";
                ctrl = "broadcaster_list";
                break;
            case 'to_country':
                origin = "to";
                break;
            case 'to_city':
                url = "broadcaster";
                ctrl = "broadcaster_list";
                origin = "to";
                break;
        }
        var params = {
            ctrl:ctrl,
            origin:origin,
            country:$(this).val().toLowerCase(),
        };
        sendRequest(url, params);
    });

    $("#from_broadcaster, #to_broadcaster").on("selectmenuchange", function(){
        var enableFiberLayer = $("#layer_fiber:checked");
        var enableSatelliteLayer = $("#layer_satellite:checked");
        var enableCloudLayer = $("#layer_cloud:checked");
        loadLayer("layer_fiber",enableFiberLayer);
        loadLayer("layer_satellite",enableSatelliteLayer);
        loadLayer("layer_cloud",enableCloudLayer);
    });

    $("#layer_fiber, #layer_satellite, #layer_cloud").change(function(){
        var layer = $(this).attr('id');
        var state = $("#"+ layer+":checked").length;
        loadLayer(layer,state);
    });
});


