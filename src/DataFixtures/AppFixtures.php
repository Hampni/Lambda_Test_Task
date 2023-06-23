<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Locale;
use App\Entity\Country;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\VatRate;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $localeEnglish = new Locale();
        $localeEnglish->setName('English');
        $localeEnglish->setIsoCode('EN');
        $manager->persist($localeEnglish);

        $localeUkrainian = new Locale();
        $localeUkrainian->setName('Ukrainian');
        $localeUkrainian->setIsoCode('UA');
        $manager->persist($localeUkrainian);

        $countryEngland = new Country();
        $countryEngland->setName('England');
        $countryEngland->setLocale($localeEnglish);
        $manager->persist($countryEngland);

        $countryUkraine = new Country();
        $countryUkraine->setName('Ukraine');
        $countryUkraine->setLocale($localeUkrainian);
        $manager->persist($countryUkraine);

        $categoryFood = new Category();
        $categoryFood->setName('Food');
        $manager->persist($categoryFood);

        $categoryAlcohol = new Category();
        $categoryAlcohol->setName('Alcohol');
        $manager->persist($categoryAlcohol);

        $productBread = new Product();
        $productBread->setName('Bread');
        $productBread->setDescription('White bread');
        $productBread->setPrice('50');
        $productBread->setCategory($categoryFood);
        $manager->persist($productBread);

        $productWine = new Product();
        $productWine->setName('Wine');
        $productWine->setDescription('Red wine');
        $productWine->setPrice('100');
        $productWine->setCategory($categoryAlcohol);
        $manager->persist($productWine);

        $vatRateEnglandFood = new VatRate();
        $vatRateEnglandFood->setRate('5');
        $vatRateEnglandFood->setCountry($countryEngland);
        $vatRateEnglandFood->setCategory($categoryFood);
        $manager->persist($vatRateEnglandFood);

        $vatRateEnglandAlcohol = new VatRate();
        $vatRateEnglandAlcohol->setRate('10');
        $vatRateEnglandAlcohol->setCountry($countryEngland);
        $vatRateEnglandAlcohol->setCategory($categoryAlcohol);
        $manager->persist($vatRateEnglandAlcohol);

        $vatRateUkraineFood = new VatRate();
        $vatRateUkraineFood->setRate('3');
        $vatRateUkraineFood->setCountry($countryUkraine);
        $vatRateUkraineFood->setCategory($categoryFood);
        $manager->persist($vatRateUkraineFood);

        $vatRateUkraineAlcohol = new VatRate();
        $vatRateUkraineAlcohol->setRate('8');
        $vatRateUkraineAlcohol->setCountry($countryUkraine);
        $vatRateUkraineAlcohol->setCategory($categoryAlcohol);
        $manager->persist($vatRateUkraineAlcohol);

        $manager->flush();
    }
}
