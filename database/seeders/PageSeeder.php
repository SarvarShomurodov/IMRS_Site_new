<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $page = new Page();
      $page->title_uz = "Tarix";
      $page->title_ru = "История";
      $page->title_en = "History";
      $page->description_uz = "Institut 1968 yilda tashkil etilgan bo'lib, makroiqtisodiy, pul-kredit, moliyaviy, bank va ijtimoiy muammolarni prognoz qilish va tadqiq qilish bo'yicha 51 yillik tajribaga ega. Faoliyat davomida institutning maqsad va vazifalari zamon talablarini hisobga olgan holda o'zgargan:
                                Iqtisodiyot ilmiy-tadqiqot instituti (1968);
                                Hisoblash markazi bilan iqtisodiyot va normalar ilmiy-tadqiqot instituti (1986);
                                Iqtisodiyot va statistika ilmiy-tadqiqot instituti (1992);
                                Iqtisodiyot va ishlab chiqarish kuchlarini rivojlantirish ilmiy tadqiqot instituti (1994);
                                Makroiqtisodiy va ijtimoiy tadqiqotlar instituti (1997);";
      $page->description_ru = "Институт образован в 1968 году и имеет 51-летний опыт работы в области прогнозирования и исследования макроэкономических, монетарных, финансово-банковских и социальных проблем. За время своей деятельности цели и задачи Института менялись с учетом требований времени:
                                Научно-исследовательский экономический институт (1968 г.);
                                Научно-исследовательский институт экономики и нормативов с Вычислительным центром (1986 г.);
                                Научно-исследовательский институт экономики и статистики (1992 г.);
                                Научно-исследовательский институт экономики и развития производительных сил (1994 г.);
                                Институт макроэкономических и социальных исследований (1997 г.);";
      $page->description_en = "The Institute was founded in 1968 and has 51 years of experience in forecasting and researching macroeconomic, monetary, financial, banking and social problems. During its activity, the goals and objectives of the Institute have changed taking into account the requirements of the time:
                                Scientific Research Institute of Economics (1968);
                                Research Institute of Economics and Norms with Computing Center (1986);
                                Research Institute of Economics and Statistics (1992);
                                Research Institute of Economics and Development of Productive Forces (1994);
                                Institute for Macroeconomic and Social Research (1997);";
      $page->slug = 'history';
      $page->save();
    }
}
