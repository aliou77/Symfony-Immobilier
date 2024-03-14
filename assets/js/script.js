import $ from 'jquery';

$(document).ready(function () {
    // modal feat
    const modalFeat = ()=>{
        $('#open-modal').click(function (e) { 
            
            $("#head-2").addClass('open');
        });
        $('#close-modal').click(function (e) { 
            $("#head-2").removeClass('open');
        });
    }
    modalFeat();

    // 
    $(".properties-section .property-item").each((i, item)=>{
        $(item).hover(function () {
                // over
                $(item).find("div.read-more").css('opacity', '1')
            }, function () {
                // out
                $(item).find("div.read-more").css('opacity', '0')
            }
        );
    })

    //  js for filters layout
    $("#open-filters").click(()=>{
        $(".form-search-content .content").removeClass('hidden');
    })
    $("#close-filters").click(()=>{
        $(".form-search-content .content").addClass('hidden');
    })


    // select 2 feat
    $('select.js-select2').select2();

    // openstreetmap feat configuration
    try {
        var lat = $('#lat').data('latitude') ? $('#lat').data('latitude') : 51.505, 
            long = $('#long').data('longitude') ? $('#long').data('longitude') : -0.09;
        
        var map = L.map('map').setView([lat, long], 13);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            minZoom: 1,
            maxZoom: 20,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
    
        // add polygone (pointer sur la carte)
        var marker = L.marker([lat, long]).addTo(map);
    
        // popups
        // marker.bindPopup("<h1>London</h1>").openPopup(); 
    } catch (error) {
        console.log("Leaflet Library is not downloaded !");
    }

});