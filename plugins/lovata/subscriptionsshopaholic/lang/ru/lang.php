<?php return [
    'plugin'     => [
        'name'        => 'Subscriptions for Shopaholic',
        'description' => 'Позволяет вам продавать подписки',
    ],
    'menu'       => [
        'period'             => 'Период доступа к подпискам',
        'period_description' => '',
        'access'             => 'Доступ пользователей к подпискам',
    ],
    'tab'        => [
        'subscription' => 'Подписки',
    ],
    'field'      => [
        'is_subscription'          => 'Подписка',
        'period'                   => 'Период',
        'period_access'            => 'Период доступа к подписке',
        'period_description'       => 'Вы можите задать относительный интервал, используя синтаксис: <strong>15 min, 2 hour, 10 day, 3 month, 1 year</strong>',
        'unlimited_period'         => 'Неограниченно',
        'expire_at'                => 'Дата истечения доступа',
        'order_status'             => 'Статус заказа',
        'order_status_description' => 'Выберете статус заказа, при котором будет создан доступ к подписке',
        'expire_type'              => 'Логика расчета даты истечения доступа к подпискам',
    ],
    'period'     => [
        'name'       => 'периода',
        'list_title' => 'Список периодов',
    ],
    'access'     => [
        'name'       => 'доступа',
        'list_title' => 'Список доступов',
    ],
    'permission' => [
        'period' => 'Управление периодами доступа к подпискам',
        'access' => 'Управление доступами пользовтаелей к подпискам',
    ],
    'type'       => [
        'right_now'    => 'Прямо сейчас',
        'begin_of_day' => 'Начало дня',
        'end_of_day'   => 'Окончание дня',
    ],
];