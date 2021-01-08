import ShopaholicCartUpdate from '@lovata/shopaholic-cart/shopaholic-cart-update';
import ShopaholicCartRemove from '@lovata/shopaholic-cart/shopaholic-cart-remove';
import ShopaholicCartAdd from '@lovata/shopaholic-cart/shopaholic-cart-add';
import ShopaholicCart from '@lovata/shopaholic-cart/shopaholic-cart';

//update cart after changed count item
const obShopaholicCartUpdate = new ShopaholicCartUpdate();
obShopaholicCartUpdate.setAjaxRequestCallback((obRequestData) => {
    obRequestData.update = {
        'cart/cart-total-price': `.${'_shopaholic-cart-total-price'}`,
    }
    return obRequestData;
}).init();

//add item to cart
const obShopaholicCartAdd = new ShopaholicCartAdd();
obShopaholicCartAdd.setAjaxRequestCallback((obRequestData, obButton) => {
    obRequestData.update = {
        'site/header-cart-info': `.${'header__cart-info-wrapper'}`,
    }
    obRequestData.complete = () => {
        obButton.classList.add('checked');
    }
    return obRequestData;
}).init();

//remove item in cart
const obShopaholicCartRemove = new ShopaholicCartRemove();
obShopaholicCartRemove.setAjaxRequestCallback((obRequestData) => {
    obRequestData.update = {
        this: removeItem(obRequestData),
        'cart/cart-total-price': `.${'_shopaholic-cart-total-price'}`,
        'site/header-cart-info': `.${'header__cart-info-wrapper'}`,
    }
    obRequestData.beforeUpdate = () => {
        checkCountCart()
    }

    // obRequestData.loading = '.preloader';
    return obRequestData;
}).init();

function removeItem(obRequestData) {
    let data_position_id = obRequestData.data.cart[0];
    var cartItem = document.getElementById(`obCartPosition-${data_position_id}`);
    cartItem.remove();
}

function checkCountCart() {
    var countItem = ShopaholicCart.instance().obCartData.quantity;
    if (countItem === 1) {
        window.location.reload();
    }

}
