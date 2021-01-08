$(".clear-view-list").click(function () {

    $.request('ProductData::onClearViewedProductList');

    $("#recently-list").remove();

});
