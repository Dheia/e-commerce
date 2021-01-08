<?php namespace Wapp\Database\Updates;

use Lovata\Buddies\Models\Property;
use October\Rain\Database\Updates\Seeder;


class SeederCreateBuddiesProperty extends Seeder
{

    public function run()
    {
        Property::create([
            'active' => true,
            'name' => 'gender',
            'slug' => 'gender',
            'code' => 'gender',
            'type' => 'select',
            'settings' => ["tab" => "", "list" => [["value" => "male"], ["value" => "female"],
                ["value" => "unknown"]], "datepicker" => "date", "mediafinder" => "file"],
            'sort_order' => 1,
        ]);
        Property::create([
            'active' => true,
            'name' => 'dateDay',
            'slug' => 'dateday',
            'code' => 'dateDay',
            'type' => 'number',
            'settings' => ["tab" => "BirthDay", "datepicker" => "date", "mediafinder" => "file", "list" => []],
            'sort_order' => 2,
        ]);
        Property::create([
            'active' => true,
            'name' => 'dateMonth',
            'slug' => 'datemonth',
            'code' => 'dateMonth',
            'type' => 'select',
            'settings' => ["tab" => "BirthDay", "list" => [["value" => "Jan"], ["value" => "Feb"], ["value" => "Mar"],
                ["value" => "Apr"], ["value" => "May"], ["value" => "Jun"], ["value" => "Jul"], ["value" => "Aug"],
                ["value" => "Sep"], ["value" => "Oct"], ["value" => "Nov"],
                ["value" => "Dec"]], "datepicker" => "date", "mediafinder" => "file"],
            'sort_order' => 3,
        ]);
        Property::create([
            'active' => true,
            'name' => 'dateYear',
            'slug' => 'dateyear',
            'code' => 'dateYear',
            'type' => 'number',
            'settings' => ["tab" => "BirthDay", "datepicker" => "date", "mediafinder" => "file", "list" => []],
            'sort_order' => 4,
        ]);
    }
}
