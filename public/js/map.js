Cesium.Ion.defaultAccessToken = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiJkYzFhN2I2Yy1jZWRmLTQ1ZGMtYTY2Ni01YzI3YzMzYTc4N2YiLCJpZCI6NDgyMSwic2NvcGVzIjpbImFzciIsImdjIl0sImlhdCI6MTU0MTY5OTY5MX0.B-sZryd9xSPBYJYB3aO142zgqMYg9J8B-nt4uthdvc4';
var viewer = new Cesium.Viewer('map', {
    shouldAnimate : true
});

var options = {
    camera : viewer.scene.camera,
    canvas : viewer.scene.canvas
};


var broadcasterDataSource = Cesium.KmlDataSource.load('https://cesiumjs.org/Cesium/Apps/SampleData/kml/facilities/facilities.kml', options);
var satelliteDataSource   = Cesium.CzmlDataSource.load('https://cesiumjs.org/Cesium/Apps/SampleData/simple.czml');


