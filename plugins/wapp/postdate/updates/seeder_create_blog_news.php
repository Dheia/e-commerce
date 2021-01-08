<?php namespace Wapp\Database\Updates;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Support\Facades\DB;
use October\Rain\Database\Updates\Seeder;
use RainLab\Blog\Models\Category;
use RainLab\Blog\Models\Post;
use System\Models\File;
use Illuminate\Support\Str;


class SeederCreateBlogNews extends Seeder
{

    public function run()
    {
        $cat = Category::create([
            'name' => 'Новости',
            'slug' => 'news',
        ]);

        $news = [
            'Новости: 50 лет',
            'Новости: Аналитика',
            'Новости: Антидопинг',
            'Новости: Видео',
            'Новости: Конференции',
            'Новости: Международная политика',
            'Новости: О федерации',
            'Новости: Попечительский совет',
            'Новости: Президиумы',
            'Новости: Пресса о нас',
            'Новости: Регионы',
            'Новости: Рейтинг текущий',
            'Новости: Сборная команда',
            'Новости: Слаломные каналы',
            'Новости: Тренерские советы',
        ];

        foreach ($news as $key=>$title){
            $category = Category::create([
                'name' => $title,
                'slug' => Str::slug($title),
                'parent_id' => $cat->id,
            ]);
        }

        $slalomChannels = Category::create([
            'name' => 'Слаломные каналы',
            'slug' => 'slalom-channels',
        ]);

        //regions
        $regions = Category::create([
            'name' => 'Регионы',
            'slug' => Str::slug('Регионы'),
        ]);

        $seeds = [
            'Центральный федеральный округ' => [
                'Москва (МФГС)',
                'Московская область',
                'Рязанская область',
                'Ярославская область'
            ],
            'Северо-Западный федеральный округ' => [
                'Ленинградская область',
                'Санкт-Петербург (СПБФГС)',
                'Архангельская область',
                'Мурманская область',
                'Новгородская область'
            ],
            'Дальневосточный федеральный округ' => [
                'Приморский край',
                'Хабаровский край'
            ],
            'Приволжский федеральный округ' => [
                'Республика Башкортостан',
                'Нижегородская область',
                'Пермский край',
                'Республика Чувашия'
            ],
            'Северо-Кавказский федеральный округ' => [
                'Республика Северная Осетия – Алания'
            ],
            'Сибирский федеральный округ' => [
                'Республика Алтай',
                'Новосибирская область',
                'Томская область',
                'Красноярский край'
            ],
            'Уральский федеральный округ' => [
                'Свердловская область',
                'Тюменская область',
                'ХМАО-ЮГРА',
                'Челябинская область'
            ],
            'Южный федеральный округ' => [
                'Краснодарский край',
                'Ростовская область'
            ]
        ];

        foreach ($seeds as $okrug => $titles) {
            $category = Category::create([
                'name' => $okrug,
                'slug' => Str::slug($okrug),
                'parent_id' => $regions->id,
            ]);

            foreach ($titles as $key => $title) {
                $subCategory = Category::create([
                    'name' => $title,
                    'slug' => Str::slug($title),
                    'parent_id' => $category->id,
                ]);
            }
        }

        $documents = Category::create([
            'name' => 'Документы',
            'slug' => 'documents',
        ]);
        $titles = [
            "Учредительные документы",
            "Конференции",
            "Президиумы",
            "Тренерские советы",
            "Нормативные документы",
            "Соглашения",
            "Доклады",
        ];

        foreach ($titles as $key => $title) {
            $category = Category::create([
                'name' => $title,
                'slug' => Str::slug($title),
                'parent_id' => $documents->id,
            ]);
        }


        //rules
        $rules = Category::create([
            'name' => 'Правила',
            'slug' => 'pravila',
        ]);
        $rulesFirst = Category::create([
            'name' => 'Требования к снаряжению',
            'slug' => Str::slug('Требования к снаряжению'),
            'parent_id' => $rules->id,
        ]);
        $rulesSecond = Category::create([
            'name' => 'Порядок определения квот на всероссийские соревнования',
            'slug' => Str::slug('Порядок определения квот на всероссийские соревнования'),
            'parent_id' => $rules->id,
        ]);

        $seeds = [
            $rules,
            $rulesFirst,
            $rulesSecond
        ];
        //rules


        //antidoping
        $antidoping = Category::create([
            'name' => 'Антидопинг',
            'slug' => 'antidoping',
        ]);

        $titles = [
            'Антидопинг: Документы',
            'Биодобавки'
        ];

        foreach ($titles as $key => $title) {
            $category = Category::create([
                'name' => str_replace('Антидопинг: ', '', $title),
                'slug' => Str::slug($title),
                'parent_id' => $antidoping->id,
            ]);
        }
        //antidoping

        //sbornaya
        $sbornaya = Category::create([
            'name' => 'Сборная',
            'slug' => Str::slug('Сборная'),
        ]);
        $sbornayaCategories = [
            'Единый календарный план',
            'Система отбора в сборные команды' => [
                'Система отбора в сборные команды на 2018 год',
                'Система отбора в сборные команды на 2016-2017 год',
                'Система отбора в сборные команды на 2015-2016 год',
                'Система отбора в сборные команды на 2014-2015 год',
                'Система отбора в сборные команды на 2013 год',
                'Список вызываемости на УТС в период 1.01.13 – до КР 2013',
                'Система отбора в сборные команды на 2012 год',
                'Система отбора в сборные команды на 2011 год',
                'Система отбора в сборные команды на 2010 год',
            ],
            'Список кандидатов в сборную команду' => [
                'Список кандидатов в сборную команду 2018',
                'Архив' => [
                    'Список кандидатов в сборную команду 2011' => [
                        'Утверждённый список атлетов на ставки Минспорта от 10.01.11',
                    ],
                    'Список кандидатов в сборную команду 2013',
                    'Список кандидатов в сборную команду 2014',
                    'Список кандидатов в сборную команду 2015',
                    'Список кандидатов в сборную команду 2016',
                    'Список кандидатов в сборную команду 2017',
                ],
            ],
            'Текущий состав сборной' => [
                'Национальная сборная',
                'Юниорская сборная',
                'Юношеская сборная',
            ],
            'Текущий рейтинг' => [
                'Система рейтинга 2016-2017',
                'Система рейтинга 2015-2016',
                'Система рейтинга 2014-2015',
                'Система рейтинга 2013',
                'Система рейтинга 2011',
                'Система рейтинга 2010',
            ],
            'Аналитические документы, отчёты',
            'Тренерский, менеджерский и руководящий состав команды',
            'Список спортсменов-инструкторов',
            'Достижения',
        ];
        foreach ($sbornayaCategories as $key => $firstDepth) {
            if (is_string($firstDepth)) {
                $category = Category::create([
                    'name' => $firstDepth,
                    'slug' => Str::slug($firstDepth),
                    'parent_id' => $sbornaya->id,
                ]);
            } else {
                $categoryParentFirst = Category::create([
                    'name' => $key,
                    'slug' => Str::slug($key),
                    'parent_id' => $sbornaya->id,
                ]);
                foreach ($firstDepth as $first => $secondDepth) {
                    if (is_string($secondDepth)) {
                        $category = Category::create([
                            'name' => $secondDepth,
                            'slug' => Str::slug($secondDepth),
                            'parent_id' => $categoryParentFirst->id,
                        ]);

                    }else{
                        $categoryParentSecond = Category::create([
                            'name' => $first,
                            'slug' => Str::slug($first),
                            'parent_id' => $categoryParentFirst->id,
                        ]);
                        foreach ($secondDepth as $second => $thirdDepth){
                            if (is_string($thirdDepth)) {
                                $category = Category::create([
                                    'name' => $thirdDepth,
                                    'slug' => Str::slug($thirdDepth),
                                    'parent_id' => $categoryParentSecond->id,
                                ]);
                            }else{
                                $categoryParentThird = Category::create([
                                    'name' => $second,
                                    'slug' => Str::slug($second),
                                    'parent_id' => $categoryParentSecond->id,
                                ]);
                                foreach ($thirdDepth as $third => $fourthDepth){
                                    $category = Category::create([
                                        'name' => $fourthDepth,
                                        'slug' => Str::slug($fourthDepth),
                                        'parent_id' => $categoryParentThird->id,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }
        //sbornaya


        //federation
        $federation = Category::create([
            'name' => 'Федерация',
            'slug' => 'federation',
        ]);

        $titles = [
            'Президиум',
            'Ревизионная комиссия',
            'Попечительский совет',
            'Пресса о нас',
        ];

        foreach ($titles as $key => $titleCategory){
            $category = Category::create([
                'name' => $titleCategory,
                'slug' => Str::slug($titleCategory),
                'parent_id' => $federation->id,
            ]);
        }
        //federation


        //clubs-and-sections
        $clubs = Category::create([
            'name' => 'Клубы и секции',
            'slug' => 'clubs-and-sections',
        ]);
        //clubs-and-sections
    }
}
