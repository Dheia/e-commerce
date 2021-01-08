import ShopaholicSearch from "@lovata/shopaholic-search";

export default new class searchContent {
    constructor() {
        this.sSearchWrapper = 'search-result-wrapper';

        this.init();
    }

    init() {
        const obHelper = new ShopaholicSearch();
        obHelper
            .setSearchLimit(3)
            .setSearchDelay(600)
            .setAjaxRequestCallback((obRequestData) => {
                obRequestData.update = {
                    'site/header/search/search-ajax': `.${this.sSearchWrapper}`,
                };
                return obRequestData;
            }).init();
    }
}
