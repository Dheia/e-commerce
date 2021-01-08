import ShopaholicCartShippingType from '@lovata/shopaholic-cart/shopaholic-cart-shipping-type';
import ShopaholicOrder from '@lovata/shopaholic-cart/shopaholic-order';

const obShopaholicCartShippingType = new ShopaholicCartShippingType();
obShopaholicCartShippingType.setAjaxRequestCallback((obRequestData, obInput) => {
    // obRequestData.loading = '.preloader';
}).init();

// TODO запихивает всю инфу в урлу)) и без авторизации не формирует заказ,а в теории должен.
const obShopaholicOrder = new ShopaholicOrder();

const obBtn = document.querySelector('.checkout_submit')
if (obBtn) {
    obBtn.addEventListener('click', () => {
        obShopaholicOrder.setAjaxRequestCallback((obRequestData, obInput) => {
            return obRequestData;
        });
        obShopaholicOrder.create();
    })
}
