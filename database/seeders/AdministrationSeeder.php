<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Administration;

class AdministrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrator = new Administration();
        $administrator->title_uz = 'Director';
        $administrator->title_ru = 'Директор';
        $administrator->title_en = 'Director';
        $administrator->duties_uz = "Institut faoliyatiga umumiy rahbarlikni amalga oshiradi va institutga yuklatilgan vazifalar va funktsiyalarning bajarilishi uchun shaxsiy javobgarlikni o'z zimmasiga oladi, institut direktor o'rinbosarlari o'rtasida vazifalarni taqsimlaydi, ularning vakolatlarini belgilaydi";
        $administrator->duties_ru = 'Осуществляет общее руководство деятельностью Института и несет персональную ответственность за выполнение возложенных на Институт задач и функций, распределяет обязанности между заместителями директора Института, определяет их полномочия';
        $administrator->duties_en = "Carries out general management of the Institute's activities and bears personal responsibility for the implementation of the tasks and functions assigned to the Institute, distributes duties between the deputy directors of the Institute, determines their powers";
        $administrator->vacant = 'yes';
        $administrator->save();


        $administrator = new Administration();
        $administrator->title_uz = "Direktorning birinchi o'rinbosari";
        $administrator->title_ru = 'Первый заместитель директора';
        $administrator->title_en = 'First Deputy Director';
        $administrator->name_uz = 'Shukurov Shuhrat Zokirjanovich';
        $administrator->name_ru = 'Шукуров Шухрат Зокиржанович';
        $administrator->name_en = 'Shukurov Shukhrat Zokirjanovich';
        $administrator->email = 'info@ifmr.uz';
        $administrator->image = '1.jpg';
        $administrator->phone = '(998) 71 244-01-17)';
        $administrator->duties_uz = "Iqtisodiyotning real sektorini rivojlantirish bo'yicha olib borilayotgan izlanishlarni tashkiliy va uslubiy boshqarishni ta'minlaydi";
        $administrator->duties_ru = 'Oсуществляет организационное и методическое руководство проводимыми исследованиями по вопросам развития реального сектора экономики';
        $administrator->duties_en = "Provides organizational and methodological guidance for ongoing research on the development of the real sector of the economy";
        $administrator->biography_uz = "Shukurov Shuhrat Zokirjanovich
                                        1971 yilda Namangan shahrida tug'ilgan.
                                        Oliy ma'lumot.
                                        1993 yilda Moskva iqtisodiyot va statistika institutini tugatgan (Rossiya).
                                        2004 yilda O'zbekiston Respublikasi Prezidenti huzuridagi Davlat va jamoat qurilishi akademiyasining Oliy biznes maktabini tamomlagan.
                                        Prognozlashtirish va makroiqtisodiy tadqiqotlar institutida 2012 yildan beri rahbar lavozimlarida ishlab kelmoqda.
                                        2019 yildan hozirgi kungacha u prognozlashtirish va makroiqtisodiy tadqiqotlar instituti direktorining birinchi o'rinbosari lavozimida ishlab kelmoqda";
        $administrator->biography_ru = 'Шукуров Шухрат Зокиржанович
                                        Родился в 1971 году в городе Намангане.
                                        Образование – высшее.
                                        В 1993 году окончил Московский экономико-статистический институт (Россия).
                                        В 2004 году окончил Высшую школу бизнеса при Академии государственного и общественного строительства при Президенте Республики Узбекистан.
                                        В Институте прогнозирования и макроэкономических исследований работает с 2012 года на руководящих должностях.
                                        С 2019 г. по настоящее время работает Первым заместителем директора Института прогнозирования и макроэкономических исследований';
        $administrator->biography_en = "Shukurov Shukhrat Zokirzhanovich
                                        Was born in 1971 in the city of Namangan.
                                        Higher education.
                                        Graduated from the Moscow Institute of Economics and Statistics (Russia) in 1993.
                                        In 2004 he graduated from the Higher School of Business at the Academy of State and Public Construction under the President of the Republic of Uzbekistan.
                                        She has been working at the Institute for Forecasting and Macroeconomic Research since 2012 in executive positions.
                                        From 2019 to the present, he has been working as First Deputy Director of the Institute for Forecasting and Macroeconomic Research";
        $administrator->save();
    }
}
