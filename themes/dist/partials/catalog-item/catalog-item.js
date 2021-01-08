import ShopaholicAddWishList from "@lovata/shopaholic-wish-list/shopaholic-add-wish-list";
import ShopaholicRemoveWishList from "@lovata/shopaholic-wish-list/shopaholic-remove-wish-list";

const addListenerAddWishList = new ShopaholicAddWishList();
addListenerAddWishList.setAjaxRequestCallback((obRequestData, obButton) => {
    obRequestData.update = {
        'site/header-cart-info': `.${'header__cart-info-wrapper'}`,
    };
    obRequestData.complete = () => {
        changeClassWishBtn(obButton)
    };
    return obRequestData;
}).init();



const addListenerRemoveWishList = new ShopaholicRemoveWishList();
addListenerRemoveWishList.setAjaxRequestCallback((obRequestData,obButton) => {
    obRequestData.update = {
        'site/header-cart-info': `.${'header__cart-info-wrapper'}`,
        // 'dashboard-item/cabinetItem': `.${'__personal-cabinet'}`,
    };
    obRequestData.complete = () => {
        changeClassWishBtn(obButton);
        removeItem(obRequestData);
        document.location = document.location.origin + document.location.pathname;
    };
    return obRequestData;
}).init();


function removeItem(obRequestData) {
    if (obRequestData.data.cart === 'undefined') {
        let data_position_id = obRequestData.data.cart[0];
        var cartItem = document.getElementById(`obCartPosition-${data_position_id}`);
        cartItem.remove();
    }
}

function changeClassWishBtn(obButton) {
    let obBtn = obButton[0];
    if (obBtn.classList.contains('_shopaholic-add-wish-list-button')) {
        if (obBtn.innerHTML === ('Избранное')) {
            obBtn.innerHTML = "Убрать";
        }
        obBtn.classList.remove('_shopaholic-add-wish-list-button');
        obBtn.classList.add('_shopaholic-remove-wish-list-button');

    } else {
        if (obBtn.innerHTML === ('Убрать')) {
            obBtn.innerHTML = "Избранное";
        }
        obBtn.classList.remove('_shopaholic-remove-wish-list-button');
        obBtn.classList.add('_shopaholic-add-wish-list-button');
    }
}
