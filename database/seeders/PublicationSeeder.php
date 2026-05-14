<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Publication;

class PublicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $publication = new Publication();
      $publication->title_uz = "Intellektual matematik modellar asosida O'zbekiston Respublikasi iqtisodiyotining iqtisodiy rivojlanishini baholash usullarini takomillashtirish";
      $publication->title_ru = 'Совершенствование методик оценки социально-экономического потенциала регионов Республики Узбекистан на основе интеллектуальных математических моделей';
      $publication->title_en = 'Improvement of methods for assessing the economic development of the economy of the Republic of Uzbekistan on the basis of intelligent mathematical models';
      $publication->image_uz = '1.jpg';
      $publication->image_ru = '1.jpg';
      $publication->image_en = '1.jpg';
      $publication->slug     = 'improvement-of-methods-for-assessing-the-economic-development-of-the-economy-of-the-Republic-of-Uzbekistan-on-the-basis-of-intelligent-mathematical-models';
      $publication->description_uz = 'Otajanov Umid Abdullaevich
                                      Iqtisod fanlari doktori.
                                      Bosh ilmiy xodim,
                                      Prognozlashtirish va makroiqtisodiy tadqiqotlar instituti
                                      Elektron pochta: umidotajanov@rambler.ru';
      $publication->description_ru = 'Отажанов Умид Абдуллаевич
                                      Кандидат экономических наук.
                                      Главный научный сотрудник,
                                      Институт прогнозирования и макроэкономических исследований
                                      E-mail: umidotajanov@rambler.ru';
      $publication->description_en = 'Otazhanov Umid Abdullaevich
                                      Ph.D. in Economics.
                                      Chief Researcher,
                                      Institute for Forecasting and Macroeconomic Research
                                      E-mail: umidotajanov@rambler.ru';
      $publication->meta_keywords_uz = "Nashrlar, yangiliklar, arivlar";
      $publication->meta_keywords_ru = 'Публикации, новости, архивы';
      $publication->meta_keywords_en = 'Publications, news, archives';
      $publication->meta_description_uz = "Intellektual matematik modellar asosida O'zbekiston Respublikasi iqtisodiyotining iqtisodiy";
      $publication->meta_description_ru = 'Совершенствование методик оценки социально-экономического потенциала регионов Республики Узбекистан на основе интеллектуальных математических моделей';
      $publication->meta_description_en = 'Improvement of methods for assessing the economic development of the economy of the Republic of Uzbekistan on the basis of intelligent mathematical models';
      $publication->save();
      $publication->categories()->attach('3');

      $publication = new Publication();
      $publication->title_uz = "O'zbekiston aholisi daromadlarini oshirishning strategik maqsadlari va istiqbollari";
      $publication->title_ru = 'Стратегические цели и перспективы для повышения доходов населения Узбекистана';
      $publication->title_en = 'Strategic goals and prospects for increasing incomes of the population of Uzbekistan';
      $publication->image_uz = '2.jpg';
      $publication->image_ru = '2.jpg';
      $publication->image_en = '2.jpg';
      $publication->slug     = 'Strategic-goals-and-prospects-for-increasing-incomes-of-the-population-of-Uzbekistan';
      $publication->description_uz = "Xulosa: Maqolada O'zbekistonda aholi turmush darajasi va sifatidagi zamonaviy tendentsiyalarning aholining iste'mol va sotib olish qobiliyatlari dinamikasida tahlili
                                      ko'rib chiqiladi, rivojlanish barqarorligi, xatarlar va aholi farovonligini oshirish imkoniyatlari baholanadi, mavjud tizimli muammolar, nomutanosibliklar aniqlanadi va belgilanganlarga erishish uchun chora-tadbirlar tayyorlanadi aholining turmush darajasi va sifatini yaxshilash uchun daromadlarni oshirish orqali maqsadlar.";
      $publication->description_ru = 'Аннотация: В статье рассматривается анализ современных тенденций изменения уровня и качества жизни населения в Узбекистане в динамике
                                      потребления и покупательской способности населения, дана оценка устойчивости развития, рисков и возможностей повышения благосостояния населения, выявлены имеющиеся системные проблемы, диспропорции также подготовлены меры по устранению и достижению поставленных целевых задач путем повышения доходов для повышения уровня и качества жизни населения.';
      $publication->description_en = 'Abstract: The article examines the analysis of modern trends in the level and quality of life of the population in Uzbekistan in the dynamics of consumption and purchasing power of the
                                      population, assesses the sustainability of development, risks and opportunities for improving the welfare of the population, identifies existing systemic problems, imbalances, and prepares measures to eliminate and achieve the set targets by increasing incomes to improve the level and quality of life of the population.';
      $publication->meta_keywords_uz = "Nashrlar, yangiliklar, arivlar";
      $publication->meta_keywords_ru = 'Публикации, новости, архивы';
      $publication->meta_keywords_en = 'Publications, news, archives';
      $publication->meta_description_uz = "O'zbekiston aholisi daromadlarini oshirishning strategik maqsadlari va istiqbollari";
      $publication->meta_description_ru = 'Стратегические цели и перспективы для повышения доходов населения Узбекистана';
      $publication->meta_description_en = "Strategic goals and prospects for increasing incomes of the population of Uzbekistan";
      $publication->save();
      $publication->categories()->attach('1');
    }
}
