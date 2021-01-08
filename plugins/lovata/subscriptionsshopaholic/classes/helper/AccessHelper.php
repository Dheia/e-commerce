<?php namespace Lovata\SubscriptionsShopaholic\Classes\Helper;

use Log;
use October\Rain\Argon\Argon;

use Lovata\Shopaholic\Models\Settings;
use Lovata\SubscriptionsShopaholic\Models\SubscriptionAccess;

/**
 * Class AccessHelper
 * @package Lovata\SubscriptionsShopaholic\Classes\Helper
 * @author  Andrey Kharanenka, a.khoronenko@lovata.com, LOVATA Group
 */
class  AccessHelper
{
    const TYPE_RIGHT_NOW = 'right_now';
    const TYPE_BEGIN_OF_DAY = 'begin_of_day';
    const TYPE_END_OF_DAY = 'end_of_day';

    protected $bInit = false;
    protected $iUserID;
    protected $iElementID;
    protected $iElementType;
    /** @var \Lovata\OrdersShopaholic\Models\OrderPosition */
    protected $obOrderPosition;
    /** @var \Lovata\Shopaholic\Models\Offer */
    protected $obItem;
    /** @var \Lovata\Shopaholic\Models\Product */
    protected $obProduct;
    /** @var SubscriptionAccess */
    protected $obAccess;
    protected $sAccessType;

    /**
     * AccessHelper constructor.
     * @param \Lovata\OrdersShopaholic\Models\OrderPosition $obOrderPosition
     * @param int                                           $iUserID
     */
    public function __construct($obOrderPosition, $iUserID)
    {
        $this->sAccessType = Settings::getValue('subscription_expire_type', self::TYPE_RIGHT_NOW);

        $this->iUserID = $iUserID;
        $this->obOrderPosition = $obOrderPosition;
        $this->iElementID = $obOrderPosition->getProperty('access_element_id');
        $this->iElementType = $obOrderPosition->getProperty('access_element_type');

        //Get product object
        $this->obItem = $obOrderPosition->item;
        if (empty($this->obItem)) {
            return;
        }

        $this->obProduct = $this->obItem->product;
        if (empty($this->obProduct)) {
            return;
        }

        $this->bInit = true;
    }

    /**
     * Find or create access, add period to access
     */
    public function add()
    {
        if (!$this->bInit || !$this->obOrderPosition->is_subscription || !empty($this->obOrderPosition->subscription_access_id)) {
            return;
        }

        $this->findOrCreate();
        if (empty($this->obAccess)) {
            return;
        }

        $this->attachAccessToOrderPosition();
        $this->calculateExpireDate();

        $this->obAccess->save();
    }

    /**
     * Find access object or create new access object
     */
    protected function findOrCreate()
    {
        $this->obAccess = SubscriptionAccess::getByProduct($this->obProduct->id)
            ->getByUser($this->iUserID)
            ->getByElementID($this->iElementID)
            ->getByElementType($this->iElementType)
            ->first();
        if (!empty($this->obAccess)) {
            return;
        }

        try {
            $this->obAccess = SubscriptionAccess::create([
                'product_id'   => $this->obProduct->id,
                'user_id'      => $this->iUserID,
                'element_id'   => $this->iElementID,
                'element_type' => $this->iElementType,
            ]);
        } catch (\Exception $obException) {
            Log::error($obException->getMessage());
        }
    }

    /**
     * Attach order position to access
     */
    protected function attachAccessToOrderPosition()
    {
        if (empty($this->obAccess) || empty($this->obOrderPosition)) {
            return;
        }

        try {
            $this->obOrderPosition->subscription_access_id = $this->obAccess->id;
            $this->obOrderPosition->save();
        } catch (\Exception $obException) {
            Log::error($obException->getMessage());
        }
    }

    /**
     * Calculate new expire date
     */
    protected function calculateExpireDate()
    {
        $obPeriod = $this->obOrderPosition->subscription_period;
        if (empty($obPeriod)) {
            $this->obAccess->expire_at = null;
            return;
        }

        $obExpireAt = $this->obAccess->expire_at;
        if (empty($obExpireAt) || $obExpireAt->toDateTimeString() < Argon::now()->toDateTimeString()) {
            $obExpireAt = Argon::now();
        }

        switch ($this->sAccessType) {
            case self::TYPE_BEGIN_OF_DAY:
                $obExpireAt->startOfDay()->add($obPeriod->period);
                break;
            case self::TYPE_END_OF_DAY:
                $obExpireAt->endOfDay()->add($obPeriod->period);
                break;
            default:
                $obExpireAt->add($obPeriod->period);
        }

        $this->obAccess->expire_at = $obExpireAt;
    }
}
