<?php

declare(strict_types=1);

use App\Model\Link;
use Hyperf\Database\Seeders\Seeder;

class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 1000; $i++) {
            $link = new Link([
                'title' => 'Site do Diego',
                'alias' => dechex(time() + $i),
                'url' => 'https://diegoborgs.com.br',
                'expires_in' => (new DateTime())->add(new DateInterval('P2D'))->format(DateTimeInterface::W3C)
            ]);
            $link->save();
        }
    }
}
