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


    // select 2 feat
    $('select.js-select2').select2();

});