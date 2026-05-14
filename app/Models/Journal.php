<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App;

class Journal extends Model
{
    protected $fillable = [
      'title_uz',
      'title_ru',
      'title_en',
      'image',
      'views',
      'journal',
      'time_uz',
      'time_ru',
      'time_en',
      'sort',
      'editorial_staff_uz',
      'editorial_staff_ru',
      'editorial_staff_en',
      'editorial_board_uz',
      'editorial_board_ru',
      'editorial_board_en',
      'submission_uz',
      'submission_ru',
      'submission_en',
      'news_uz',
      'news_ru',
      'news_en',
      'subscription_uz',
      'subscription_ru',
      'subscription_en',
      'contacts_uz',
      'contacts_ru',
      'contacts_en',
      'issn',
    ];


    public function getTitleAttribute()
    {
        $locale = App::getLocale();
        $column = "title_" . $locale;
        return $this->{$column};
    }

    public function getEditorialStaffAttribute()
    {
        $locale = App::getLocale();
        $column = "editorial_staff_" . $locale;
        return $this->{$column};
    }

    public function getEditorialBoardAttribute()
    {
        $locale = App::getLocale();
        $column = "editorial_board_" . $locale;
        return $this->{$column};
    }

    public function getSubmissionAttribute()
    {
        $locale = App::getLocale();
        $column = "submission_" . $locale;
        return $this->{$column};
    }

    public function getSubscriptionAttribute()
    {
        $locale = App::getLocale();
        $column = "subscription_" . $locale;
        return $this->{$column};
    }

    public function getNewsAttribute()
    {
        $locale = App::getLocale();
        $column = "news_" . $locale;
        return $this->{$column};
    }

    public function getContactsAttribute()
    {
        $locale = App::getLocale();
        $column = "contacts_" . $locale;
        return $this->{$column};
    }

    public function getTimeAttribute()
    {
        $locale = App::getLocale();
        $column = "time_" . $locale;
        return $this->{$column};
    }

    public function getPdfAttribute()
    {
        $locale = App::getLocale();
        $column = "journal";
        return "/files/journals/". $this->{$column};
    }

    public function getCreatedData()
    {
        $locale = App::getLocale();
        Carbon::setlocale($locale);

        return Carbon::parse($this->created_at)->translatedFormat(' j F Y');
    }
}
