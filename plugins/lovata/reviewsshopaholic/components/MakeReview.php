<?php namespace Lovata\ReviewsShopaholic\Components;

use Lang;
use Input;

use Kharanenka\Helper\Result;
use Lovata\Toolbox\Classes\Component\ComponentSubmitForm;
use Lovata\Toolbox\Traits\Helpers\TraitValidationHelper;

use Lovata\Shopaholic\Models\Product;
use Lovata\ReviewsShopaholic\Models\Review;

/**
 * Class MakeReview
 * @package Lovata\ReviewsShopaholic\Components
 * @author Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class MakeReview extends ComponentSubmitForm
{
    use TraitValidationHelper;
    
    /** @var Review */
    protected $obReview;
    
    /** @var Product */
    protected $obProduct;
    
    /**
     * @return array
     */
    public function componentDetails()
    {
        return [
            'name'        => 'lovata.reviewsshopaholic::lang.component.make_review_name',
            'description' => 'lovata.reviewsshopaholic::lang.component.make_review_description',
        ];
    }

    /**
     * @return array
     */
    public function defineProperties()
    {
        $arResult = $this->getModeProperty();
        return $arResult;
    }

    /**
     * Get redirect page property list
     * @return array
     */
    protected function getRedirectPageProperties()
    {
        if(!Result::status()) {
            return [];
        }

        $arResult = [
            'id'         => $this->obReview->id,
            'product_id' => $this->obProduct->id,
            'slug'       => $this->obProduct->slug,
        ];

        return $arResult;
    }

    /**
     * Create new review
     * @return \Illuminate\Http\RedirectResponse|null
     */
    public function onRun()
    {
        if($this->sMode != self::MODE_SUBMIT) {
            return null;
        }

        $arReviewData = Input::all();
        if(empty($arReviewData)) {
            return null;
        }

        $this->create($arReviewData);

        return $this->getResponseModeForm();
    }

    /**
     * Create new review (AJAX)
     * @return \Illuminate\Http\RedirectResponse|array
     */
    public function onCreate()
    {
        $arReviewData = Input::all();

        $this->create($arReviewData);

        return $this->getResponseModeAjax();
    }

    /**
     * Create new review
     * @param array $arReviewData
     */
    public function create($arReviewData)
    {
        //Get product ID from request
        if(empty($arReviewData) || !isset($arReviewData['product_id']) || empty($arReviewData['product_id'])) {
            $sMessage = Lang::get('lovata.reviewsshopaholic::lang.message.e_product_id_field');
            Result::setFalse()->setMessage($sMessage);
            
            return;
        }
        
        //Get product object
        $this->obProduct = Product::find((int) $arReviewData['product_id']);
        if(empty($this->obProduct)) {
            $sMessage = Lang::get('lovata.reviewsshopaholic::lang.message.e_product_id_field');
            Result::setFalse()->setMessage($sMessage);

            return;
        }
        
        try {
            //Create new review
            $this->obReview = Review::create($arReviewData);
        } catch (\October\Rain\Database\ModelException $obException) {
            $this->processValidationError($obException);

            return;
        }
    }
}
