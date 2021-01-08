<?php return [
    'plugin'    => [
        'name'        => 'Reviews for Shopaholic',
        'description' => 'Отзывы для товаров каталога',
    ],
    'field'     => [
        'user_name'         => 'Имя пользователя',
        'rating'            => 'Оценка',
        'product'           => 'Товар',
        'comment'           => 'Комментарий',
        'reviews'           => 'Отзывы',
        'rating_from'       => 'Минимальное значение рейтинга',
        'rating_to'         => 'Максимальное значение рейтинга',
        'review_activation' => 'Автоматически активировать отзыв, после создания',
    ],
    'review'    => [
        'name'       => 'отзыва',
        'list_title' => 'Список отзывов',
    ],
    'tab'       => [
        'review_settings' => 'Отзывы',
    ],
    'menu'      => [
        'reviews' => 'Отзывы',
    ],
    'component' => [
        'make_review_name'        => 'Создание отзыва',
        'make_review_description' => 'Форма создания нового отзыва',
    ],
    'message'   => [
        'e_product_id_field' => 'Некорректное значение ID товара',
    ],
    'permission' => [
        'review' => 'Управление отзывами',
    ],
];