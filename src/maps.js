/* Script to handle the rendering of maps for use with the "Planned Trips" and "Places Visited" features. */

import "core-js/shim";
import * as am4core from "@amcharts/amcharts4/core";
import * as am4maps from "@amcharts/amcharts4/maps";
import am4geodata_worldLow from "@amcharts/amcharts4-geodata/worldLow";
import am4themes_animated from "@amcharts/amcharts4/themes/animated";

(() => {
    'use strict';
    
    const maps = {
        initialize: () => {
            console.log(map_data);
            if (typeof map_data !== 'undefined') {
                maps.renderChart(am4core, am4maps, am4geodata_worldLow);
            }
        },
        getChartData: () => {          
            map_data.zoom = parseInt(map_data.zoom);
            map_data.center.lat = parseFloat(map_data.center.lat);
            map_data.center.lng = parseFloat(map_data.center.lng);
            map_data.chart_data = [];
            const locationCount = map_data.data.length;
            for (let i = 0; i < locationCount; i++) {
                let locationData = map_data.data[i];
                if (locationData.hasOwnProperty('place-location')) {
                    map_data.chart_data.push([{
                        location: locationData['place-location'],
                        lat: parseFloat(locationData['place-location-lat']),
                        lng: parseFloat(locationData['place-location-lng']),
                        rating: parseInt(locationData['place-rating']),
                    }]);
                }
                else if (locationData.hasOwnProperty('trip-origin')) {
                    map_data.chart_data.push([{
                        type: 'origin',
                        location: locationData['trip-origin'],
                        lat: parseFloat(locationData['trip-origin-lat']),
                        lng: parseFloat(locationData['trip-origin-lng'])
                    }, {
                        type: 'destination',
                        location: locationData['trip-destination'],
                        lat: parseFloat(locationData['trip-destination-lat']),
                        lng: parseFloat(locationData['trip-destination-lng'])
                    }]);             
                }
            }
        },
        renderChart: (am4core, am4maps, am4geodata_worldLow) => {
            maps.getChartData();
            am4core.useTheme(am4themes_animated);
            let chart = am4core.create(map_data.id, am4maps.MapChart);
            chart.geodata = am4geodata_worldLow;
            chart.projection = new am4maps.projections.Miller();
            chart.homeZoomLevel = map_data.zoom;
            chart.homeGeoPoint = {
                latitude: map_data.center.lat,
                longitude: map_data.center.lng
            };
            let polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
            polygonSeries.useGeodata = true;
            polygonSeries.mapPolygons.template.fill = am4core.color(map_data.country_color);
            polygonSeries.mapPolygons.template.stroke = am4core.color(map_data.background_color);
            polygonSeries.mapPolygons.template.nonScalingStroke = true;
            polygonSeries.exclude = ["AQ"];
            maps.renderCities(chart);      
        },
        renderCities: (chart) => {
            let cities = chart.series.push(new am4maps.MapImageSeries());
            cities.mapImages.template.nonScaling = true;
            let cityTemplate = cities.mapImages.template.createChild(am4core.Circle);
            cities.mapImages.template.nonScaling = true;
            cityTemplate.radius = 4;
            cityTemplate.fill = am4core.color('rgba(255, 163, 26, 0.8)');
            cityTemplate.strokeWidth = 0;
            //cityTemplate.stroke = am4core.color('rgba(255, 163, 26, 0.9)');
            let lines = maps.prepareTripPaths(chart, map_data.id, cityTemplate);
            map_data.chart_data.forEach((post) => {
                let locations = [];
                post.forEach((location) => {
                    let country = location.location.split(", ").pop();
                    let city = cities.mapImages.create();
                    city.latitude = location.lat;
                    city.longitude = location.lng;
                    let tooltipLocation = location.location.split(", ").join("<br>");
                    let tooltipRating = (map_data.id == "chart-places-visited") ? maps.renderLocationRatings(location.rating) : "";
                    city.tooltipHTML = `<div class="chart-tooltip"><img src="${map_data.theme_url}/img/flags/${country}.png" alt="Flag"><div>${tooltipLocation}</div>${tooltipRating}</div>`;
                    locations.push(city);
                });
                if (locations.length === 2) {
                    (post[0].type === "origin") ? maps.renderTripPaths(lines, locations[0], locations[1]) : maps.renderTripPaths(lines, locations[1], locations[0]);
                }
            });
            if (map_data.plane_animation == "enabled" && lines) {
                let numLines = lines.lineSeries.mapLines.length;
                for (let l = 0; l < numLines; l++) {    
                    maps.renderPlane(lines, l, false);
                }
            }
        },
        prepareTripPaths: (chart, id, cityTemplate) => {
            if (id === 'chart-planned-trips') {
                let lineSeries = chart.series.push(new am4maps.MapArcSeries());
                lineSeries.mapLines.template.line.strokeWidth = 2;
                lineSeries.mapLines.template.line.strokeOpacity = 0.7;
                lineSeries.mapLines.template.line.stroke = am4core.color("#01b8de");
                lineSeries.mapLines.template.line.nonScalingStroke = true;
                lineSeries.mapLines.template.line.strokeDasharray = "4";
                lineSeries.zIndex = 10;
                let shadowLineSeries = chart.series.push(new am4maps.MapLineSeries());
                shadowLineSeries.mapLines.template.line.strokeOpacity = 0;
                shadowLineSeries.mapLines.template.line.nonScalingStroke = true;
                shadowLineSeries.mapLines.template.shortestDistance = false;
                shadowLineSeries.zIndex = 5;
                return {
                    lineSeries: lineSeries,
                    shadowSeries: shadowLineSeries
                };
            }
            return false;
        },
        renderTripPaths: (lines, from, to) => {
            if (lines) {
                let line = lines.lineSeries.mapLines.create();
                line.imagesToConnect = [from, to];
                line.line.controlPointDistance = -0.3;
                let shadowLine = lines.shadowSeries.mapLines.create();
                shadowLine.imagesToConnect = [from, to];
            }
        },
        preparePlane: (lineSeries, index, color) => {
            let plane = lineSeries.mapLines.getIndex(index).lineObjects.create();
            plane.position = 0;
            plane.width = 48;
            plane.height = 48;
            let planeImage = plane.createChild(am4core.Sprite);
            planeImage.scale = 0.1;
            planeImage.horizontalCenter = "middle";
            planeImage.verticalCenter = "middle";
            planeImage.path = "m2,106h28l24,30h72l-44,-133h35l80,132h98c21,0 21,34 0,34l-98,0 -80,134h-35l43,-133h-71l-24,30h-28l15,-47";
            planeImage.fill = am4core.color(color);
            planeImage.strokeOpacity = 0;       
            return {
                plane: plane,
                planeImage: planeImage
            };
        },
        renderPlane: (lines, index, existingPlane) => {      
            let lineSeries = lines.lineSeries;
            let shadowLineSeries = lines.shadowSeries;
            let plane, planeImage, shadowPlane, shadowPlaneImage;
            if (existingPlane) {
                plane = existingPlane.plane;
                planeImage = existingPlane.planeImage;
                shadowPlane = existingPlane.shadowPlane;
                shadowPlaneImage = existingPlane.shadowPlaneImage;                  
            }
            else {
                let planeData = maps.preparePlane(lineSeries, index, "#EEE");
                let shadowPlaneData = maps.preparePlane(shadowLineSeries, index, "rgba(0,0,0,0.8)");
                plane = planeData.plane;
                planeImage = planeData.planeImage;
                shadowPlane = shadowPlaneData.plane;
                shadowPlaneImage = shadowPlaneData.planeImage;            
                plane.adapter.add("scale", (scale, target) => 0.5 * (1 - (Math.abs(0.5 - target.position))));
                shadowPlane.adapter.add("scale", (scale, target) => {
                    target.opacity = (0.6 - (Math.abs(0.5 - target.position)));
                    return 0.5 - 0.3 * (1 - (Math.abs(0.5 - target.position)));
                });
            }
            plane.mapLine = lineSeries.mapLines.getIndex(index);
            plane.parent = lineSeries;
            shadowPlane.mapLine = shadowLineSeries.mapLines.getIndex(index);
            shadowPlane.parent = shadowLineSeries;
            let animation = plane.animate({
                from: 0,
                to: 1,
                property: "position"
            }, 6000, am4core.ease.sinInOut);
            shadowPlane.animate({
                from: 0,
                to: 1,
                property: "position"
            }, 6000, am4core.ease.sinInOut);
            animation.events.on("animationended", () => {
                maps.renderPlane(lines, index, {
                    plane: plane,
                    planeImage: planeImage,
                    shadowPlane: shadowPlane,
                    shadowPlaneImage: shadowPlaneImage
                });
            });
        },
        renderLocationRatings: (rating) => {
            let stars = [];
            for (let i = 1; i <= rating; i++) {
                (i % 2 == 0) ? stars.splice(-1, 1, '<i class="fas fa-star"></i>') : stars.push('<i class="fas fa-star-half"></i>');
            }
            let output = `<div>${stars.join("")}</div>`;
            return output;
        }
    }

    maps.initialize();
    
})();