import ShopaholicProductList from "@lovata/shopaholic-product-list/shopaholic-product-list";
import ShopaholicPagination from "@lovata/shopaholic-product-list/shopaholic-pagination";
import ShopaholicFilterPanel from "@lovata/shopaholic-filter-panel/shopaholic-filter-panel";
import ShopaholicSorting from "@lovata/shopaholic-product-list/shopaholic-sorting";
import ShopaholicFilterPrice from "@lovata/shopaholic-filter-panel/shopaholic-filter-price";

// import LazyLoad from '../../'


export default new class catalogContent {
    constructor() {
        this.topPosition = 580;
        this.sCatalogWrapper = 'catalog_wrapper';
        this.sFilterWrapper = 'catalog_filters';
        this.sBrandFilterWrapper = '_shopaholic-brand-filter-wrapper';
        this.sCategoryFilterWrapper = '_shopaholic-category-filter-wrapper';
        // this.preLoaderSelector = '.catalog_preloader';

        this.init();
    }

    init() {
        const obListHelper = new ShopaholicProductList();
        obListHelper.setAjaxRequestCallback((obRequestData) => {
            obRequestData.update = {
                'catalog/catalog-content-ajax': `.${this.sCatalogWrapper}`,
                'catalog/catalog-filter': `.${this.sFilterWrapper}`,
                // 'catalog/filter': `.${this.sBrandFilterWrepper}`,
            };
            // obRequestData.loading = this.preLoaderSelector;
            obRequestData.complete = () => {
                // this.updateAjaxComplete();
                initRangeSlider(document.getElementById('range'),document.getElementById('leftRange'),document.getElementById('rightRange')); // Инит рейнж слайдера
            }

            return obRequestData;
        });
        const obFilterPrice = new ShopaholicFilterPrice(obListHelper);
        // obFilterPrice.setInputMinPriceName('min-price').init();
        // obFilterPrice.setInputMaxPriceName('max-price').init();

        obFilterPrice.setInputSelector('.setRangePrice').setEventType('click').init();

        // obFilterPrice.setEventType('mouseup').init();
        const obSortingHelper = new ShopaholicSorting(obListHelper);
        obSortingHelper.init();

        const obPaginationHelper = new ShopaholicPagination(obListHelper);
        obPaginationHelper.init();

        const obFilterPanel = new ShopaholicFilterPanel(obListHelper);
        obFilterPanel.init();

        const obBrandFilterPanel = new ShopaholicFilterPanel(obListHelper);
        obBrandFilterPanel.setWrapperSelector(`.${this.sBrandFilterWrapper}`)
            .setFieldName('brand')
            .init();

        const obCategoryFilterPanel = new ShopaholicFilterPanel(obListHelper);
        obCategoryFilterPanel.setWrapperSelector(`.${this.sCategoryFilterWrapper}`)
            .setFieldName('category')
            .init();

    }

    // updateAjaxComplete() {
    //     LazyLoad.update();
    //     $('body, html').animate({scrollTop: this.topPosition}, 350);
    // }
}



