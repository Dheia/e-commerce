window.$ = window.jQuery = require('jquery');

$(() => { // Shorthand for $( document ).ready()
    "use strict";

    // require('./js/libs.min');
    // require('./js/common');
    require ('jquery');
    require('./partials/catalog-item/catalog-item');
    require('./partials/catalog/catalog');
    require('./partials/cart/update-cart');
    require('./partials/viewed-products/recently');
    require('./partials/site/header/search/search');
    require('./partials/checkout/checkout');

});
