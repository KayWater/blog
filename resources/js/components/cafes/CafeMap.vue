<template>
    <div id='cafe-map'>
    </div>
</template>

<script>
import { parse } from 'path';
import { ROAST_CONFIG } from '../../config.js';

export default {
    props: {
        'latitude': {
            type: Number,
            default: function() {
                return 120.21;
            }
        },
        'longitude': {
            type: Number,
            default: function() {
                return 30.29;
            }
        },

        'zoom': {
            type: Number,
            default: function() {
                return 4;
            }
        }
    },

    data() {
        return {
            markers: [],
            infoWindows: [],
        }
    },
    computed: {
        cafes() {
            this.$store.getters.getCafes;
        }
    },
    methods: {
        buildMarkers() {
            // 清空点标记数组
            this.markers = [];
            
            var image = ROAST_CONFIG.APP_URL + "/storage/img/coffee-marker.png";
            var icon = new AMap.Icon({
                image: image,
                imageSize: new AMap.Size(19, 33)
            })

            //遍历所有咖啡店并创建点标记
            for (var i=0, len=this.cafes.length; i<len; i++) {
                
                var marker = new AMap.Marker({
                    position: AMap.LngLat(parseFloat(this.cafes[i].latitude), 
                        parseFloat(this.cafes[i].longitude)),
                    title: this.cafes[i].name,
                    icon: icon
                });

                // infoWindow
                var infoWindow = new AMap.InfoWindow({
                    content: this.cafes[i].name
                });
                this.infoWindows.push(infoWindow);

                marker.on('click', function() {
                    infoWindow.open(this.getMap(), this.getPosition());
                })

                this.markers.push(marker);
            }
            this.map.add(this.markers);
        },

        clearMarkers() {
            for(var i=0, len=this.markers.length; i<len; i++) {
                this.markers[i].setMap(null);
            }
        },

    },
    watch: {
        cafes() {
            this.clearMarkers();
            this.buildMarkers();
        }
    },
    mounted() {
        this.map = new AMap.Map('cafe-map', {
            center: [this.latitude, this.longitude],
            zoom: this.zoom
        });
        this.clearMarkers();
        this.buildMarkers();
    }
}
</script>

<style scoped>
    div#cafe-map {
        width: 100%;
        height: 400px;
    }
</style>