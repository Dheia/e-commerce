<?php namespace Wapp\Database\Updates;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use October\Rain\Database\Updates\Seeder;
use RainLab\Blog\Models\Category;
use RainLab\Blog\Models\Post;
use System\Models\File;


class SeederCrateNationalTeam extends Seeder
{

    public function run()
    {
        $factory = Factory::create();
        $team = [
            'Национальная сборная',
            'Юниорская сборная',
            'Юношеская сборная',
            'Тренерский, менеджерский и руководящий состав команды',
            'Список спортсменов-инструкторов'
        ];

    }
}
