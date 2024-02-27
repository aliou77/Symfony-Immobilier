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
                $(item).find("div.read-more").slideDown()
            }, function () {
                // out
                $(item).find("div.read-more").slideUp()
            }
        );
    })


});