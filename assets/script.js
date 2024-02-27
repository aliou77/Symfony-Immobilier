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
});